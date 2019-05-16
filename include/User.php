<?php

namespace Restomatic;

use Restomatic\Application as App;

class User {
	public static function login($username, $password) {
		$user = self::buscaUsuario($username);
		if ($user && $user->compruebaPassword($password)) {
			$app = App::getSingleton();
			$conn = $app->conexionBd();
			$query = sprintf("SELECT role FROM users u WHERE u.id='%s'", $conn->real_escape_string($user->id));
			$rs = $conn->query($query);
			if ($rs) {
				while($fila = $rs->fetch_assoc()) {
					$user->addRol($fila['role']);
				}
				$rs->free();
			}
			return $user;
			}
		return false;
	}

	public static function buscaUsuario($username) {
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT * FROM users WHERE email='%s'", $conn->real_escape_string($username));
		$rs = $conn->query($query);
		if ($rs && $rs->num_rows == 1) {
			$fila = $rs->fetch_assoc();
			$user = new User($fila['id'], $fila['email'], $fila['password']);
			$rs->free();

			return $user;
		}
		return false;
	}

	private $id;

	private $username;

	private $password;

	private $roles;

	private function __construct($id, $username, $password)
	{
		$this->id = $id;
		$this->username = $username;
		$this->password = $password;
		$this->roles = '';
	}

	public function id()
	{
		return $this->id;
	}

	public function addRol($role)
	{
		$this->roles = $role;
	}

	public function roles()
	{
		return $this->roles;
	}

	public function username()
	{
		return $this->username;
	}

	public function compruebaPassword($password)
	{
		return password_verify($password, $this->password);
	}

	public function cambiaPassword($nuevoPassword)
	{
		$this->password = password_hash($nuevoPassword, PASSWORD_DEFAULT);
	}


	public static function create($email,$name,$password,$role) {
		$conn=Application::getSingleton()->conexionBD();
		$query=sprintf("INSERT INTO users(email, name, password, role) VALUES('%s', '%s', '%s', '%s')"
		, $conn->real_escape_string($email)
		, $conn->real_escape_string($name)
		, password_hash($password, PASSWORD_DEFAULT)
			, $role);
		if ( $conn->query($query) ) {

			$_SESSION['login'] = true;
			$_SESSION['email'] = $email;
			$_SESSION['name'] = $name;
			$_SESSION['roles'] = $role;
			return true;
		}
		else {
			return false;
		}
	}


	public static function fetchMyRestaurants() {
		$conn=App::getSingleton()->conexionBD();
		if(isset($_SESSION['login']) && $_SESSION['login']) {
			$query=sprintf("SELECT restaurants.id, restaurants.name, restaurants.logo, restaurants.domain FROM restaurants JOIN users ON users.id=restaurants.owner
			WHERE users.email='%s';", $_SESSION['email']);
			$result=$conn->query($query);
			return $result;
		}
		return header("Location: notLoggedIn.php");
	}

	public static function addRestaurant($data) {
		$conn=Application::getSingleton()->conexionBD();
		if($_SESSION['login']) {
			$root=$_SERVER['DOCUMENT_ROOT'].APP_ROUTE;
			$ownerId = $conn->query("SELECT id FROM users WHERE email='".$_SESSION['email']."';")->fetch_assoc()['id'];
			$id = $conn->query("SELECT nvl(max(id),'0') as id from restaurants");
			if(!$id) {
				$id=0;
			}
			else {
				$id=$id->fetch_assoc()['id'];
			}
			$id++;
			$targetDir = 'user/'.$ownerId.'/'.$id;
			$targetLogo='';
			$targetMenu='';
			if(!file_exists($root.$targetDir)) {
				mkdir($root.$targetDir,0777,true);
			}
			if(isset($_FILES['logoToUpload']['tmp_name'])&& $_FILES['logoToUpload']['tmp_name']!='') {
				$targetLogo = $targetDir.'/'.$_FILES['logoToUpload']['name'];
				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				$mime = finfo_file($finfo, $_FILES['logoToUpload']['tmp_name']);
				if ($mime == 'image/jpeg'|| $mime=='image/png') {
					if(!move_uploaded_file($_FILES["logoToUpload"]["tmp_name"], $root.$targetLogo)) {
						return "Error uploading logo";
					}
				}
				else return "Invalid file type for logo";
				finfo_close($finfo);
			}
			else return "Please upload the logo";
			if(isset($_FILES['menuToUpload']['tmp_name'])&& $_FILES['menuToUpload']['tmp_name']!='') {
				$targetMenu= $targetDir.'/'.$_FILES['menuToUpload']['name'];
				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				$mime = finfo_file($finfo, $_FILES['menuToUpload']['tmp_name']);
				if ($mime == 'application/pdf') {
					if(!move_uploaded_file($_FILES["menuToUpload"]["tmp_name"], $root.$targetMenu)) {
						return "Error uploading logo";
					}
				}
				else return "Invalid file type for menu";
				finfo_close($finfo);
			}
			else return "Please upload the menu";
			$query=sprintf("INSERT INTO restaurants(id,owner,name,theme,description,times,address,logo,menu,domain) 
			VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
				$id,
				$ownerId,
				$data['restaurantName'],
				$data['theme'],  
				$data['desc'],
				$data['times'],
				$data['address'],
				$targetLogo,
				$targetMenu,
				APP_ROUTE.'restaurants/'.preg_replace("/[^A-Za-z0-9]/", "", $data['restaurantName']));
			$result=$conn->query($query);
		}
		return 'ok';
	}

	public static function getRestaurantPage($uri) {
		$conn=Application::getSingleton()->conexionBD();
		$query=sprintf("SELECT * FROM restaurants WHERE domain='%s'",$uri);

		if( ($result=$conn->query($query)) ) {
			if( ($data=$result->fetch_assoc()) ) {
				return User::buildRestaurantPage($data);
			}
			else return '<h1> Page could not be found </h1>';
		}


		return '<h1> Page could not be found </h1>';
	}

	private static function buildRestaurantPage($data) {
		$html =  '<h1>'.$data['name'].'</h1>';
		$html .= '<p>'.$data['description'].'</p>';
		$html .= '<h3> Open hours: </h3>';
		$html .= '<p>'.$data['times'].'</p>';
		$html .= '<h3> Find us at: </h3>';
		$html .= '<p>'.$data['address'].'</p>';
		$html .= '<h3> Check out our menu <a href="'.APP_ROUTE.$data['menu'].'">here</a>'.'.</h3>';
		$html .= USER::getReviewList($data['id'],$data['domain']);
		if(isset($_SESSION['login']) && $_SESSION['login'] && ($_SESSION['roles']=='user' || $_SESSION['roles']=='admin')) { //MAKE SEPARATE FORM CLASS INSTEAD
			$form = new AddReviewForm();
			$html.=$form->gestiona();
		}
		return $html;
	}

	private static function  getReviewList($id,$domain) {
		$conn=Application::getSingleton()->conexionBD();
		$query= sprintf("SELECT reviews.id as 'id', users.name as 'name', reviews.text as 'text'  FROM reviews JOIN users ON reviews.reviewer_id=users.id WHERE reviews.restaurant_id='%s'",
			$id);
		$html='<h3> Reviews: </h3>';
		if( ($result=$conn->query($query)) ) {
			if($result->num_rows<1) {
				$html .='<p> There are no reviews </p>';
			}
			else {
				$html .= '<ul class="reviewList">';
			}
			while( ($data=$result->fetch_assoc()) ) {
				$html.= '<li>';
				$html .= '<div>';
				$html.= '<p><b>'.$data['name'].'</b> says: </p>';
				$html.= '<p>'.$data['text'].'</p>';
				$html .='</div>';
				$html .= '<div>';
				$html .= '<a href="'.APP_ROUTE.'include/processReviewReport.php?id='.$data['id'].'&domain='.$domain.'">Report</a>';
				$html .= '</div>';
				$html.='</li>';
			}


			$html.= '</ul>';
		}

		return $html;
	}

	public static function addReview($userEmail,$restaurantDomain,$reviewText) {

		$conn=Application::getSingleton()->conexionBD();
		$query=sprintf("SELECT id FROM restaurants WHERE domain='%s'",$restaurantDomain);
		$result=$conn->query($query);
		if(!$result) return false;
		$restaurantId= $result->fetch_assoc()['id'];
		$query=sprintf("SELECT id FROM users WHERE email='%s'",$userEmail);
		$result=$conn->query($query);
		if(!$result) return false;
		$userId= $result->fetch_assoc()['id'];
		$query = sprintf("INSERT INTO reviews(restaurant_id,reviewer_id,text,reports) VALUES('%s','%s','%s','%s')",
				$restaurantId,$userId,$reviewText,'0');

		if($conn->query($query)) {
			return true;
		}
		return false;
	}

	public static function reportedReviewsList() {
		if(!isset($_SESSION['login'])||!$_SESSION['login']||$_SESSION['roles']!='admin') {
			header("Location: ".APP_ROUTE );
		}
		$conn=Application::getSingleton()->conexionBD();
		$query= sprintf("SELECT reviews.id as 'id', users.name as 'name', reviews.text as 'text'  FROM reviews JOIN users ON reviews.reviewer_id=users.id WHERE reviews.reports>0");
		$html='<h1> Reported reviews: </h1>';
		if( ($result=$conn->query($query)) ) {
			if($result->num_rows<1) {
				$html .='<p> There are no reviews </p>';
			}
			else {
				$html .= '<ul class="reviewList">';
			}
			while( ($data=$result->fetch_assoc()) ) {
				$html.= '<li>';
				$html .= '<div>';
				$html.= '<p><b>'.$data['name'].'</b> says: </p>';
				$html.= '<p>'.$data['text'].'</p>';
				$html .='</div>';
				$html .= '<div>';
				$html .= '<a href="'.APP_ROUTE.'include/deleteReview.php?id='.$data['id'].'">Delete</a>';
				$html .= '</div>';
				$html.='</li>';
			}
		}
		return $html;
	}


	public static function deleteReview($id) {
		if(!isset($_SESSION['login'])||!$_SESSION['login']||$_SESSION['roles']!='admin') {
			header("Location: ".APP_ROUTE );
		}
		$conn=Application::getSingleton()->conexionBD();

		header("Location:".APP_ROUTE);
	}
}


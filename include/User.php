<?php

namespace Restomatic;

use Restomatic\Application as App;

class User {
	public static function login($username, $password) {
		$user = self::buscaUsuario($username);
		if ($user && $user->compruebaPassword($password)) {
			$app = App::getSingleton();
			$conn = $app->conexionBd();
			$query = sprintf("SELECT R.nombre FROM RolesUsuario RU, Roles R WHERE RU.rol = R.id AND RU.usuario=%s", $conn->real_escape_string($user->id));
			$rs = $conn->query($query);
			if ($rs) {
				while($fila = $rs->fetch_assoc()) { 
					$user->addRol($fila['nombre']);
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
		$this->roles = [];
	}

	public function id()
	{
		return $this->id;
	}

	public function addRol($role)
	{
		$this->roles[] = $role;
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
			, 'user');
		if ( $conn->query($query) ) {

			$_SESSION['login'] = true;
			$_SESSION['email'] = $email;
			$_SESSION['name'] = $name;

			header('Location: owner.php');

			return true;
		}
		else {
			return false;
		}
	}


	public static function fetchMyRestaurants() {
		$conn=App::getSingleton()->conexionBD();
		if(isset($_SESSION['login']) && $_SESSION['login']) {
			$query=sprintf("SELECT restaurants.id, restaurants.name, restaurants.logo FROM restaurants JOIN users ON users.id=restaurants.owner
			WHERE users.email='%s';", $_SESSION['email']);
			$result=$conn->query($query);
			return $result;
		}
		return header("Location: notLoggedIn.php");
	}

	public static function addRestaurant($data) {
		require_once(__DIR__."/Application.php");
		$conn=Application::getSingleton()->conexionBD();

		if($_SESSION['login']) {
			$root=$_SERVER['DOCUMENT_ROOT'].'/restomatic/';
			$targetDir = 'user/'.$_SESSION['email'].'/'.$data['restaurantName'];


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

			$query=sprintf("INSERT INTO restaurants(owner,name,theme,description,times,address,logo) 
			VALUES ('%s','%s','%s','%s','%s','%s','%s')",
			$conn->query("SELECT id FROM users WHERE email='".$_SESSION["email"]."';")->fetch_assoc()['id'],
				$data['restaurantName'],
				$data['theme'],  
				$data['desc'],
				$data['times'],
				$data['address'],
				$targetLogo);
			$result=$conn->query($query);
		}

		return 'ok';
	}
}

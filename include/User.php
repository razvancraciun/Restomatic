<?php

class User {
    private function __construct($email,$name,$password,$role) {
        $this->email=$email;
        $this->name=$name;
        $this->password=$password;
        $this->role=$role;
    }

    public static function searchUser($email) {
        require_once __DIR__.'/Application.php';
        $conn =Application::getInstance()->connectDB();
	
	    $query=sprintf("SELECT * FROM users U WHERE U.email = '%s'", $conn->real_escape_string($email));
        $rs = $conn->query($query);
        if($rs->num_rows==0) {
            return null;
        }
        else {
            $fila=$rs->fetch_assoc();
            return new User($fila['email'],$fila['name'],$fila['password'],$fila['role']);
        }
    }

    public function checkPassword($password) {
        echo password_hash($password, PASSWORD_DEFAULT);
        return password_verify($password,$this->password);
    }

    public static function login($email,$password) {
        $user=User::searchUser($email);
        if($user!=null &&  $user->checkPassword($password)) {
            $_SESSION['login'] = true;
            $_SESSION['name'] = $email;
            $_SESSION['isAdmin'] = strcmp($fila['role'], 'admin') == 0 ? true : false;
            header('Location: index.php');
           return $user;
        }
        else return false;
       
    }

    public static function create($email,$name,$password,$role) {
        require_once(__DIR__."/Application.php");
        $conn=Aplicacion::getInstance()->connectDB();
        $query=sprintf("INSERT INTO users(email, name, password, role) VALUES('%s', '%s', '%s', '%s')"
					, $conn->real_escape_string($email)
					, $conn->real_escape_string($name)
					, password_hash($password, PASSWORD_DEFAULT)
                    , 'user');
        if ( $conn->query($query) ) {
            $_SESSION['login'] = true;
            $_SESSION['email'] = $email;
            header('Location: index.php');
            return true;
        }
        else {
            return false;
        }
    }
}
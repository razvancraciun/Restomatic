<?php

namespace Restomatic;

class LoginForm extends Form
{

  const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$';

  public function __construct()
  {
    parent::__construct('formLogin');
  }
  
  protected function generaCamposFormulario ($datos)
  {
    $username = '';
    $password = '';
    if ($datos) {
      $username = isset($datos['username']) ? $datos['username'] : $username;
      /* Similar a la comparación anterior pero con el operador ?? de PHP 7 */
      $password = $datos['password'] ?? $password;
    }

    $camposFormulario=<<<EOF
		<fieldset>
		  <legend>Email and Password</legend>
		  <label>Email:</label><br><input type="text" name="username" value="$username" placeholder="Your email"/>
		  <label>Password:</label><br> <input type="password" name="password" value="$password" placeholder="Your password"/>
		  <button type="submit">Login</button>
		</fieldset>
EOF;
    return $camposFormulario;
  }

  /**
   * Procesa los datos del formulario.
   */
  protected function procesaFormulario($datos)
  {
    $result = array();
    $ok = true;
    $username = $datos['username'] ?? '' ;
    if ( !$username || ! mb_ereg_match(self::HTML5_EMAIL_REGEXP, $username) ) {
      $result[] = 'Invalid username';
      $ok = false;
    }

    $password = $datos['password'] ?? '' ;
    if ( ! $password ||  mb_strlen($password) < 4 ) {
      $result[] = 'Invalid password';
      $ok = false;
    }

    if ( $ok ) {
      $user = User::login($username, $password);
      if ( $user ) {
        // SEGURIDAD: Forzamos que se genere una nueva cookie de sesión por si la han capturado antes de hacer login
        session_regenerate_id(true);
        Application::getSingleton()->login($user);
        $result = Application::getSingleton()->resuelve('/owner.php');
      }else {
        $result[] = 'Incorrect username or password';
      }
    }
    return $result;
  }
}
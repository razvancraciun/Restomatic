<?php 

namespace Restomatic;

class RegisterForm extends Form {

    public function __construct()
    {
      parent::__construct('registerForm');
    }
    /**
     * Generate the necessary HTML to present the fields of the form.
     *
     * @param string[] $dataIniciales Initial data for the form fields (normalmente <code>$_POST</code>).
     *
     * @return string HTML associated with the form fields.
     */
    protected function generaCamposFormulario($dataIniciales)
    {
        return '<fieldset>
        <legend>Enter your data</legend>
        <label for="emailInput">Email:</label>
        <input type="email"  id="emailInput" name="emailInput" placeholder="Your email">
        <label for="nameInput"> Name: </label>
        <input type="text" id="nameInput" name="nameInput" placeholder="Your name">
        <label for="passwordInput">Password:</label>
        <input type="password" id="passwordInput" name="passwordInput" placeholder="Your password">
        <label for="retypePassword">Repeat password:</label>
        <input type="password" id="retypePassword" name="retypePassword" placeholder="Your password"> 
        <p><input type="checkbox" name="userType" >I\'m a restaurant owner</input></p>
        <input type="submit" value="Register">
        </fieldset>';
    }

        /**
     * Process the form data.
     *
     * @param string[] $data Data sent by the user (normalmente <code>$_POST</code>).
     *
     * @return string|string[] Returns the result of the form processing, usually a URL to which
         * you want to redirect the user, or an array with the errors that occurred during the processing of the form.
         *
    */
    protected function procesaFormulario($data)
    {
        $role = '';
        if($data['userType']) {
            $role='owner';
        }
        else $role='user';

        if($data['passwordInput']==$data['retypePassword']) {
            $user= User::create($_REQUEST['emailInput'],$_REQUEST['nameInput'],$_REQUEST['passwordInput'],$role);
        }
        else return array('Passwords do not match', '');
        if(!$user) {
            return array('User already exists', '');
        }

        if($role=='owner') {
            return 'owner.php';
        }
        else {
            return 'index.php';
        }
        
    }

}
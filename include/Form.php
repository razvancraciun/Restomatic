<?php

/**
* Base class for the management of forms.
*
* In addition to the basic management of the forms.
*/
abstract class Form
{

    /**
    * @var string String used as the value of the "id" attribute of the & lt; form & gt; associated to the form and
    * as a parameter to check to verify that the user has sent the form.
    */
    private $formId;

    /**
    * @var string URL associated with the "action" attribute of the & lt; form & gt; of the form and that will process the
    * Form submission.
    */
    private $action;

    /**
     * Create a new form.
     *
     * Possible options:
     * <table>
     *   <thead>
     *     <tr>
     *       <th>Option</th>
     *       <th>Default value</th>
     *       <th>Description</th>
     *     </tr>
     *   </thead>
     *   <tbody>
     *     <tr>
     *       <td>action</td>
     *       <td><code>$_SERVER['PHP_SELF']</code></td>
     *       <td>URL associated to the attribute "action" of the &lt tag ;form&gt; of the form that processes the sending.</td>
     *     </tr>
     *   </tbody>
     * </table>

     * @param string $formId    String used as the value of the "id" attribute of the & lt; form & gt; associated with
     * form and as a parameter to check to verify that the user has sent the form.
     *
     * @param array $opciones (see upper).
     */
    public function __construct($formId, $options = array() )
    {
        $this->formId = $formId;

        $defaultOptions = array( 'action' => null, );
        $options = array_merge($defaultOptions, $options);

        $this->action   = $options['action'];

        if ( !$this->action ) {
            $this->action = htmlentities($_SERVER['PHP_SELF']);
        }
    }

    /**
     * It is responsible for orchestrating the entire process of managing a form.
     */
    public function gestion() //= template method
    {
        if ( ! $this->submittedForm($_POST) ) {
            echo $this->generateForm();
        } else {
            $result = $this->processForm($_POST);
            if ( is_array($result) ) {
                echo $this->generateForm($result, $_POST);
            } else {
                header('Location: '.$result);
                exit();
            }
        }
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
        return '';
    }

    /**
     * Procesa los data del formulario.
     *
     * @param string[] $data data enviado por el usuario (normalmente <code>$_POST</code>).
     *
     * @return string|string[] Returns the result of the form processing, usually a URL to which
     * you want to redirect the user, or an array with the errors that occurred during the processing of the form.
     *
     */
    protected function processForm($data)
    {
        return array();
    }

    /**
     * Function that verifies if the user has sent the form.
     * Check if the <code> $ formId </ code> parameter exists in <code> $ params </ code>.
     *
     * @param string[] $params Array that contains the data received in the sending form.
     *
     * @return boolean Devuelve <code>true</code> si <code>$formId</code> existe como clave en <code>$params</code>
     */
    private function submittedForm(&$params)
    {
        return isset($params['action']) && $params['action'] == $this->formId;
    }

    /**
     * Función que genera el HTML necesario para el formulario.
     *
     * @param string[] $errores (opcional) Array with the error messages of validation and / or processing of the form.
     *
     * @param string[] $data (opcional) Array with default values of form fields.
     *
     * @return string HTML asociado al formulario.
     */
    private function generateForm($errores = array(), &$data = array())
    {

        $html= $this->generaListaErrores($errores);

        $html .= '<form method="POST" action="'.$this->action.'" id="'.$this->formId.'" >';
        $html .= '<fieldset>';
        $html .= '<input type="hidden" name="action" value="'.$this->formId.'" />';

        $html .= $this->generaCamposFormulario($data);
        $html .= '</fieldset>';
        $html .= '</form>';
        return $html;
    }

    /**
     * Genera la lista de mensajes de error a incluir en el formulario.
     *
     * @param string[] $errores (opcional) Array con los mensajes de error de validación y/o procesamiento del formulario.
     *
     * @return string El HTML asociado a los mensajes de error.
     */
    private function generaListaErrores($errores)
    {
        $html='';
        $numErrores = count($errores);
        if (  $numErrores == 1 ) {
            $html .= "<ul><li>".$errores[0]."</li></ul>";
        } else if ( $numErrores > 1 ) {
            $html .= "<ul><li>";
            $html .= implode("</li><li>", $errores);
            $html .= "</li></ul>";
        }
        return $html;
    }
}

class LoginForm extends Form {
        /**
     * Generate the necessary HTML to present the fields of the form.
     *
     * @param string[] $dataIniciales Initial data for the form fields (normalmente <code>$_POST</code>).
     *
     * @return string HTML associated with the form fields.
     */
    protected function generaCamposFormulario($dataIniciales)
    {
        return '<label for="emailInput">Email:</label><input type="email"  id="emailInput" name="emailInput" placeholder="Your email">
        <label for="passwordInput">Password:</label><input type="password" id="passwordInput" name="passwordInput" placeholder="Your password">
        <input type="submit" value="Login"> ';
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
    protected function processForm($data)
    {

    if($data['emailInput']=='') {
        return array("Please enter your email","");
    }
    if($data['passwordInput']=='') {
        return array("Please enter your password","");
    }
    $user=User::login($data['emailInput'],$data['passwordInput']);
    if(! $user) {
        return array("Invalid email or password","");
    }
        else return 'owner.php';
    }
}

class RegisterForm extends Form {
    /**
     * Generate the necessary HTML to present the fields of the form.
     *
     * @param string[] $dataIniciales Initial data for the form fields (normalmente <code>$_POST</code>).
     *
     * @return string HTML associated with the form fields.
     */
    protected function generaCamposFormulario($dataIniciales)
    {
        return '<label for="emailInput">Email:</label>
        <input type="email"  id="emailInput" name="emailInput" placeholder="Your email">
        <label for="nameInput"> Name: </label>
        <input type="text" id="nameInput" name="nameInput" placeholder="Your name">
        <label for="passwordInput">Password:</label>
        <input type="password" id="passwordInput" name="passwordInput" placeholder="Your password">
        <label for="retypePassword">Repeat password:</label>
        <input type="password" id="retypePassword" name="retypePassword" placeholder="Your password">
        <input type="submit" value="Register">';
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
    protected function processForm($data)
    {
        require 'config.php';
        if($data['passwordInput']==$data['retypePassword']) {
            $user= User::create($_REQUEST['emailInput'],$_REQUEST['nameInput'],$_REQUEST['passwordInput'],'owner');
        }
        if(!$user) {
            return array('User already exists', '');
        }

        return 'owner.php';
    }

}
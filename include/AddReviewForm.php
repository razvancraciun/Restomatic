<?php 

namespace Restomatic;

class AddReviewForm extends Form {

    public function __construct()
    {
      parent::__construct('addReviewForm');
    }


    protected function generaCamposFormulario($dataIniciales)
    {
        return '<fieldset>
        <h3>Have you been here?</h3>
        <textarea rows="5" cols="50" name="reviewText" placeholder="Write your review..."></textarea>
        <button type="submit">Post</button>
        </fieldset>
        ';
    }


    protected function procesaFormulario($data)
    {
        if(strlen($data['reviewText'])<5) {
            return array('Please type more than 5 characters','');
        }

        if(User::addReview($_SESSION['email'],$_SERVER['REQUEST_URI'],$data['reviewText'])) {
            return '';
        }
        else return array('Internal database error','');

        
    }


}
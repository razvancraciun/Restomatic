<?php 
namespace Restomatic;
class UpdateRestaurantForm extends Form {
    public function __construct()
    {
      parent::__construct('updateRestaurantForm',array('enctype'=>'multipart/form-data'));
    }
    protected function generaCamposFormulario($dataIniciales)
    {


        return '
        <fieldset>
        <legend> What is the name of your new restaurant?</legend>
        <input type="text"  id="restaurantName" name="restaurantName" placeholder="Tummy Yummy"/>
        </fieldset>
        
        <fieldset>
        <legend> Write a brief description </legend>
        <textarea id="desc" name="desc" placeholder="Best food around"></textarea>
        </fieldset>
        <fieldset class="info_time">
        <legend> What are the opening hours?</legend>
        <textarea id="times" name="times" placeholder="Every day from 12 to 22"></textarea>
        </fieldset>
  
        <fieldset class="info_address">
        <legend> What is the address?</legend>
        <textarea id="address" name="address" placeholder="Something Street..."></textarea>
        </fieldset>
        <fieldset class="logo">
        <legend>Upload Logo | .jpg or .png | 1:1 ratio </legend>
        <input type="file" name="logoToUpload" id="logoToUpload"></input>
        </fieldset>
        <fieldset class="menu">
        <legend>Upload Menu | .pdf </legend>
        <input type="file" name="menuToUpload" id="menuToUpload">
        </fieldset>
      <input type="submit" name="newRestaurant" value="Update">';
    }
    protected function procesaFormulario($data)
    {
    	$add=User::addRestaurant($data);
        if($add!=='ok') {
            $result[] = $add;
        } 
        else $result='owner.php';
	
        return $result;
    }
}
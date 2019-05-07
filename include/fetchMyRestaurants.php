<?php

namespace Restomatic;

 $restaurants=User::fetchMyRestaurants();
 
 $html="";

 while($res=$restaurants->fetch_assoc()) {
     
    $html.="<li>"."<div>";
    $html.="<a href='".$res['domain']."'>";
    if($res['logo']=='') {
        $html.="<img src='img/default.png'>";
    }
    else $html.= "<img src='".$res['logo']."'>";
       
    $html.=$res['name']."</a>"
        ."</div>"
        ."<div>"
        ."<a href='#' class='updateButton'>Update</a>"
        ."</div>"
        ."</li>";
 }
 
 echo $html;


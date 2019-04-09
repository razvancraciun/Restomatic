<?php

namespace Restomatic;


$conn=Application::getSingleton()->conexionBD();
$query=sprintf("SELECT * from restaurants");
$result=$conn->query($query);
while($res=$result->fetch_assoc()) {
    if($res['logo']=='') {
        echo "<li><img src='img/default.png'>"."<a href='".$res['domain']."'>".$res['name']."</a>"."</li>";
    }
    else
    echo "<li><img src='".$res['logo']."'>"."<a href='".$res['domain']."'>".$res['name']."</a>"."</li>";
}
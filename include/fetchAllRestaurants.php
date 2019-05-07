<?php

namespace Restomatic;


$conn=Application::getSingleton()->conexionBD();
$query=sprintf("SELECT * from restaurants");
$result=$conn->query($query);
while($res=$result->fetch_assoc()) {
    if($res['logo']=='') {
        echo "<li><a href='".$res['domain']."'><img src='img/default.png'>".$res['name']."</a>"."</li>";
    }
    else
    echo "<li><a href='".$res['domain']."'><img src='".$res['logo']."'>"."<a href='".$res['domain']."'>".$res['name']."</a>"."</li>";
}
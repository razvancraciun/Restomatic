<?php

$conn=Application::getInstance()->connectDB();
$query=sprintf("SELECT * from restaurants");
$result=$conn->query($query);
while($res=$result->fetch_assoc()) {
    echo "<li><img src='".$res['logo']."'>"."<a href='#'>".$res['name']."</a>"."</li>";
}
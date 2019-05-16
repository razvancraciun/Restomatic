<?php

namespace Restomatic;

use Restomatic\Application as App;

require 'config.php';




$conn=Application::getSingleton()->conexionBD();
$id = $_REQUEST['id'];
$query=sprintf("UPDATE reviews SET reports = reports+1 WHERE id=".$id);

$conn->query($query);

header("Location: ".$_REQUEST['domain']);
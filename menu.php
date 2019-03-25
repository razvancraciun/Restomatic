<<?php
$file='example.pdf';
$filename='example.pdf';
header('Content-type:application/pdf');
header('Content-Disposition: inline;filename"'.filename.'""');
header('Content-Tranfer-Encoding:binary');
header('Accept-Ranges:bytes');
@readfile($file)
?>

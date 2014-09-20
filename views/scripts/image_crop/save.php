<?php
if($_SERVER['REQUEST_METHOD'] == "POST") {

	// location to save cropped image
	$url = 'temp/one.jpg';

	// remove the base64 part
	$base64 = preg_replace('#^data:image/[^;]+;base64,#', '', $_POST['image']);
	$base64 = base64_decode($base64);

	$source = imagecreatefromstring($base64); // create

	imagejpeg($source, $url, 100); // save image

	// return URL
	$validation = array (
		'url'     => $url . '?' . sha1(uniqid(mt_rand(), true))
);
echo json_encode($validation);
}

<?php

if(isset($_POST['filename'])) {
$file_name = '$POST['filename']'; // of course find the exact filename....
header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Cache-Control: private', false); // required for certain browsers
header('Content-Type: application/pbo');

header('Content-Disposition: attachment; filename="'. basename($file_name) . '";');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($file_name));

readfile($file_name);
}
exit; ?>

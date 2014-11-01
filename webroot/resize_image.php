<?php

//ini_set('display_errors', 'on');
//error_reporting(E_ALL);
function setTransparency($fileName, $width, $height) {
    $thumb = imagecreatetruecolor($width, $height);
    imagealphablending($thumb, false);
    imagesavealpha($thumb, true);

    $source = imagecreatefrompng($fileName);
    imagealphablending($source, true);

    //imagecopyresampled($thumb, $source, 0, 0, 0, 0, $width, $height, $width, $height);

    imagepng($thumb, $fileName);
}

function error404() {
    header('HTTP/1.0 404 Not Found');
    exit();
}

//echo urlencode(base64_encode('2175_111047_7.jpg'));
$image = empty($_GET['image']) ? false : urldecode($_GET['image']);
$width = empty($_GET['w']) ? false : $_GET['w'];
$height = empty($_GET['h']) ? false : $_GET['h'];
$rotate = empty($_GET['rotate']) ? false : $_GET['rotate'];

if (!$image) {
    error(404);
}

define('DS', DIRECTORY_SEPARATOR);
define('WWW_ROOT', dirname(__FILE__) . DS);
$image_name = base64_decode($image);
$dir = WWW_ROOT . 'img' . DS . 'uploads';

if (!file_exists($dir . DS . $image_name)) {
    $dir = WWW_ROOT . 'uploads';
    if (!file_exists($dir . DS . $image_name)) {
        $dir = WWW_ROOT . 'css' . DS . 'images';
        if (!file_exists($dir . DS . $image_name)) {
            $image_name = "default.jpg";
//            error404();
        }
    }
}
$image_path = $dir . DS . $image_name;
$image_prop = getimagesize($dir . DS . $image_name);

$function_output = "imagejpeg";
$mime = "image/jpg";
if (strpos($image_prop['mime'], 'png')) {
    $mime = "image/png";
    $function_output = "imagepng";
}
$type = strtolower(substr($image_prop['mime'], 6));

$cash_dir = WWW_ROOT . 'uploads' . DS . 'cache';
if (!file_exists($cash_dir)) {
    mkdir($cash_dir, 0775);
}

require(WWW_ROOT . '..' . DS . 'vendors' . DS . 'image.php');
$cash_image = $cash_dir . DS . "{$width}x{$height}_$image_name";
$image_exists = file_exists($cash_image);


if (!$image_exists) {
    $crop = false;
    if (!empty($_GET['crop'])) {
        $crop = $_GET['crop'];
    }
    $crop = $_GET['crop'];
    $image = Image::smart_resize_image($dir . DS . $image_name, $width, $height, true, 'return', $crop);
    $function_output($image, $cash_image);
}

header("Content-Type:$mime");
readfile($cash_image);
die('');
?>

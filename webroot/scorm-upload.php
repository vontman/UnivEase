<?php
if (!defined('DS')){
define('DS', DIRECTORY_SEPARATOR);
}
if (!class_exists('ZipArchive')) {
    echo '0ZipArchive extension is not loaded';
    exit;
}

$archive = new ZipArchive();
$archive->open($_FILES['Filedata']['tmp_name']);
$check = $archive->locateName('imsmanifest.xml');
if ($check === false) {
    echo '0Invalid SCORM package';
    exit;
}

$filename = md5($_FILES['Filedata']['name'] . uniqid());
$scormPath = dirname(__FILE__) . DS . 'files' . DS . 'scorm-packages' . DS . $filename;
if (!is_dir($scormPath)) {
    if (!mkdir($scormPath, 0777, true)){
	echo '0Cannot create destination directory';
    }
}

if ($archive->extractTo($scormPath)){
    echo '1'.$filename;
} else {
    echo '0Failed to extract package content';
}
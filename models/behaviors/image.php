<?php

/*
 * Image for cakePHP 
 * comments, bug reports are welcome skie AT mail DOT ru 
 * @author Yevgeny Tomenko aka SkieDr 
 * @version 1.0.0.5 

  files stored in structure
  /images/{models}/{$id}/{field}.ext

 */

class ImageBehavior extends ModelBehavior {

    var $settings = null;

    function setup(&$model, $config = array()) {
        $this->imageSetup($model, $config);
    }

    function imageSetup(&$model, $config = array()) {
        // ini_set('upload_max_filesize', $this->settings[$Model->name][$field]['max_file_size']);
        $settings = Set::merge(array(
                    'baseDir' => '',
                        ), $config);

        if (!isset($settings['fields']))
            $settings['fields'] = array();
        $fields = array();
        foreach ($settings['fields'] as $key => $value) {
            $field = ife(is_numeric($key), $value, $key);
            $conf = ife(is_numeric($key), array(), ife(is_array($value), $value, array()));
            $conf = Set::merge(
                            array(
                        'thumbnail' => array('prefix' => 'thumb',
                            'create' => false,
                            'width' => '100',
                            'height' => '100',
                            'aspect' => true,
                            'allow_enlarge' => true,
                        ),
                        'resize' => null,
                        'folder' => 'img/uploads/',
                        'versions' => array(),), $conf
            );
            foreach ($conf['versions'] as $id => $version) {
                $conf['versions'][$id] = Set::merge(
                                array(
                            'aspect' => true,
                            'allow_enlarge' => false,
                                ), $version);
            }
            if (is_array($conf['resize'])) {
                if (!isset($conf['resize']['aspect']))
                    $conf['resize']['aspect'] = true;
                if (!isset($conf['resize']['allow_enlarge']))
                    $conf['resize']['allow_enlarge'] = false;
            }
            $fields[$field] = $conf;
        }
        $settings['fields'] = $fields;
        //debug($settings['fields']);
        $this->settings[$model->name] = $settings;
//        debug($this->settings[$model->name]);
    }

    /**
     * Before save method. Called before all saves
     *
     * Overriden to transparently manage setting the item position to the end of the list 
     *
     * @param AppModel $model
     * @return boolean True to continue, false to abort the save
     */
    function beforeSave(&$model) {
        extract($this->settings[$model->name]);



        $tempData = array();
        foreach ($fields as $key => $value) {
            $field = ife(is_numeric($key), $value, $key);
            if (isset($model->data[$model->name][$field])) {


                if ($this->__isUploadFile($model->data[$model->name][$field])) {
                    if ($this->_validate($model, $model->data[$model->name][$field], $field)) {
                        $dd = $model->find('first', array('conditions' => array('id' => $model->id), 'callbacks' => false, 'recursive' => -1));
//                        debug($dd[$model->name][$field]);exit;
                        if (!empty($dd[$model->name])) {
                            $file_name = $this->getFullFolder($model, $field) . $dd[$model->name][$field];
                            if (!empty($dd[$model->name][$field]) && file_exists($file_name)) {
                                unlink($file_name);
                            }
                            foreach ($fields[$field]['versions'] as $version) {
                                $vfile_name = $this->getFullFolder($model, $field) . $version['prefix'] . '_' . $dd[$model->name][$field];
                                if (file_exists($vfile_name)) {
                                    unlink($vfile_name);
                                }
                            }
                        }
                        $tempData[$field] = $model->data[$model->name][$field];
                        $model->data[$model->name][$field] = $this->__getContent($model->data[$model->name][$field]);
                    } else {
                        return false;
                    }
                } else {
                    unset($model->data[$model->name][$field]);
                }
            }
        }

        $this->runtime[$model->name]['beforeSave'] = $tempData;
        return true;
    }

    function afterSave(&$model) {
        extract($this->settings[$model->name]);
        if (empty($model->data[$model->name][$model->primaryKey])) {
            
        }

        $tempData = $this->runtime[$model->name]['beforeSave'];

        unset($this->runtime[$model->name]['beforeSave']);
        foreach ($tempData as $field => $value) {
            $filename = $model->data[$model->name][$field];
            $this->__saveFile($model, $field, $value, $filename);
        }

        return true;
    }

    function afterFind(&$model, &$results, $primary) {

        extract($this->settings[$model->name]);

        if (is_array($results)) {
            $i = 0;
            if (isset($results[0])) {
                while (isset($results[$i][$model->name]) && is_array($results[$i][$model->name])) {

                    foreach ($fields as $field => $fieldParams) {
                        if (isset($results[$i][$model->name][$field]) && ($results[$i][$model->name][$field] != '')) {
                            $value = $results[$i][$model->name][$field];
                            $results[$i][$model->name][$field] = $this->__getParams($model, $field, $value, $fieldParams, $results[$i][$model->name]);
                        }
                    }
                    $i++;
                }
            } else {
                foreach ($fields as $field => $fieldParams) {
                    if (isset($results[$model->name][$field]) && ($results[$i][$model->name][$field] != '')) {
                        $value = $results[$i][$model->name][$field];
                        $results[$model->name][$field] = $this->__getParams($model, $field, $value, $fieldParams, $results[$model->name]);
                    }
                }
            }
        }
//        debug($results);
        return $results;
    }

    function __getParams(&$model, $field, $value, $fieldParams, $record) {
        extract($this->settings[$model->name]);
        $result = array();
        if ($value != '') {
            $folderName = $this->__getFolder($model, $field, $record);

//            $ext = $this->decodeContent($value);
//            //debug($field);
            $fileName = $value;
            $result['basename'] = $fileName;
            $result['id'] = $record['id'];
            if (!empty($fields[$field]['resize']['width']) && !empty($fields[$field]['resize']['height'])) {
                $result['dimensions'] = $fields[$field]['resize']['width'] . 'px X ' . $fields[$field]['resize']['height'] . 'px';
            } else {
                $result['dimensions'] = false;
            }

            $result['path'] = $folderName . $fileName;
            $result['controller'] = Inflector::pluralize(Inflector::underscore($model->name));
            $thumb = $fields[$field]['thumbnail'];
            if ($thumb['create']) {
                $result['thumb'] = $folderName . $this->__getPrefix($thumb) . '_' . $fileName;
            }
            foreach ($fields[$field]['versions'] as $version) {
                $result[$this->__getPrefix($version)] = $folderName . $this->__getPrefix($version) . '_' . $fileName;
            }
        }
        return $result;
    }

    /**
     * Before delete method. Called before all deletes
     *
     * Will delete the current item from list and update position of all items after one
     *
     * @param AppModel $model
     * @return boolean True to continue, false to abort the delete
     */
    function beforeDelete(&$model) {
        $this->runtime[$model->name]['ignoreUserAbort'] = ignore_user_abort();
        @ignore_user_abort(true);
        return true;
    }

    function afterDelete(&$model) {
        extract($this->settings[$model->name]);

        foreach ($fields as $field => $fieldParams) {
            $folderPath = $this->getFullFolder($model, $field);
            uses('folder');
            $folder = &new Folder($path = $folderPath, $create = false);
            if ($folder !== false) {
//                @$folder->delete($folder->pwd());
            }
        }

        @ignore_user_abort((bool) $this->runtime[$model->name]['ignoreUserAbort']);
        unset($this->runtime[$model->name]['ignoreUserAbort']);
        return true;
    }

    function __isUploadFile($file) {
        if (!isset($file['tmp_name']))
            return false;
        return (file_exists($file['tmp_name']) && $file['error'] == 0);
    }

    private function _validate(&$model, $file, $field) {
        $ext = $this->__get_extension($file['name']);
        $exts = array_map('low', array('png', 'jpg', 'bmp', 'gif', 'tif'));
//        debug($exts);
        if (!in_array($ext, $exts)) {
            $model->validationErrors[$field] = __(sprintf('Invalid file type. Types required %s', implode(',', $exts)), true);
            return false;
        }
        return true;
    }

    function __get_extension($name) {
        $pos = strrpos($name, '.');
        if ($pos !== false) {
            return low(substr($name, $pos + 1));
        }
        return '';
    }

    function __getContent($file) {

        $uniqid = uniqid();
        //$filename = str_replace('{$rand}', $uniqid, $this->settings[$Model->name][$field]['file_name']);
        $name = substr($file['name'], 0, strrpos($file['name'], '.'));
        $ext = substr($file['name'], strrpos($file['name'], '.'));
        $filename = $uniqid . '_' . Inflector::slug($name) . $ext;

        return $filename;
    }

    function decodeContent($content) {
        $contentsMaping = array(
            "image/gif" => "gif",
            "image/jpeg" => "jpg",
            "image/pjpeg" => "jpg",
            "image/x-png" => "png",
            "image/jpg" => "jpg",
            "image/png" => "png",
            "application/x-shockwave-flash" => "swf",
            "application/pdf" => "pdf",
            "application/pgp-signature" => "sig",
            "application/futuresplash" => "spl",
            "application/msword" => "doc",
            "application/postscript" => "ps",
            "application/x-bittorrent" => "torrent",
            "application/x-dvi" => "dvi",
            "application/x-gzip" => "gz",
            "application/x-ns-proxy-autoconfig" => "pac",
            "application/x-shockwave-flash" => "swf",
            "application/x-tgz" => "tar.gz",
            "application/x-tar" => "tar",
            "application/zip" => "zip",
            "audio/mpeg" => "mp3",
            "audio/x-mpegurl" => "m3u",
            "audio/x-ms-wma" => "wma",
            "audio/x-ms-wax" => "wax",
            "audio/x-wav" => "wav",
            "image/x-xbitmap" => "xbm",
            "image/x-xpixmap" => "xpm",
            "image/x-xwindowdump" => "xwd",
            "text/css" => "css",
            "text/html" => "html",
            "text/javascript" => "js",
            "text/plain" => "txt",
            "text/xml" => "xml",
            "video/mpeg" => "mpeg",
            "video/quicktime" => "mov",
            "video/x-msvideo" => "avi",
            "video/x-ms-asf" => "asf",
            "video/x-ms-wmv" => "wmv"
        );
        if (isset($contentsMaping[$content]))
            return $contentsMaping[$content];
        else
            return $content;
    }

    function __saveAs($fileData, $fileName = null, $folder) {

        if (is_writable($folder)) {
            if (is_uploaded_file($_FILES[$fileData]['tmp_name'])) {
                if (empty($fileNamme))
                    $fileName = $_FILES[$fileData]['name'];
                copy($_FILES[$fileData]['tmp_name'], $folder . $fileName);
                return true;
            }
            else {
                return false;
            }
        } else {
            return false;
        }
    }

    function __getFolder(&$model, $field, $record) {
        extract($this->settings[$model->name]);
//        debug($this->settings[$model->name]);
        return '/' . $fields[$field]['folder'];
    }

    function getFullFolder(&$model, $field) {
        extract($this->settings[$model->name]);

        return WWW_ROOT . str_replace('/', DS, $fields[$field]['folder']);
    }

    function __saveFile(&$model, $field, $fileData, $fileName) {
        extract($this->settings[$model->name]);
        $folderName = $this->getFullFolder($model, $field);
//        $ext = $this->decodeContent($this->__getContent($fileData));
//        $fileName = $this->__getContent($fileData);

        uses('folder');
        uses('file');

        $folder = &new Folder($folderName, true, 0777);

        $files = $folder->find($fileName);

        $file = &new File($folder->pwd() . DS . $fileName);


        $fileExists = ($file !== false);
        if ($fileExists) {
            @$file->delete();
        }


        if (!empty($fields[$field]['resize']['width']) && !empty($fields[$field]['resize']['height'])) {

            $file = $folder->pwd() . DS . 'tmp_' . $fileName;
            copy($fileData['tmp_name'], $file);
            $this->__resize($folder->pwd(), 'tmp_' . $fileName, $fileName, $field, $fields[$field]['resize']);
            @unlink($file);
        } else {
            $file = $folder->pwd() . DS . $fileName;
            copy($fileData['tmp_name'], $file);
        }




        if ($fields[$field]['thumbnail']['create']) {
            $fieldParams = $fields[$field]['thumbnail'];
            $newFile = $this->__getPrefix($fieldParams) . '_' . basename($fileName);
            $this->__resize($folder->pwd(), $fileName, $newFile, $field, $fieldParams);
        }
        foreach ($fields[$field]['versions'] as $version) {

            $newFile = $this->__getPrefix($version) . '_' . basename($fileName);
            $file = $folder->pwd() . DS . 'tmp_' . $fileName;
            copy($fileData['tmp_name'], $file);
            $this->__resize($folder->pwd(), 'tmp_' . $fileName, $newFile, $field, $version);
            @unlink($file);


//            $this->__resize($folder->pwd(), $fileName, $newFile, $field, $version);
        }
    }

    function __getPrefix($fieldParams) {
        if (isset($fieldParams['prefix'])) {
            return $fieldParams['prefix'];
        } else {
            return $fieldParams['width'] . 'x' . $fieldParams['height'];
        }
    }

    /**
     * Automatically resizes an image and returns formatted IMG tag 
     * 
     * @param string $path Path to the image file, relative to the webroot/img/ directory. 
     * @param integer $width Image of returned image 
     * @param integer $height Height of returned image 
     * @param boolean $aspect Maintain aspect ratio (default: true) 
     * @param array    $htmlAttributes Array of HTML attributes. 
     * @param boolean $return Wheter this method should return a value or output it. This overrides AUTO_OUTPUT. 
     * @return mixed    Either string or echos the value, depends on AUTO_OUTPUT and $return. 
     * @access public 
     */
    function __resize($folder, $originalName, $newName, $field, $fieldParams) {

//        debug($fieldParams);exit;

        $types = array(1 => "gif", "jpeg", "png", "swf", "psd", "wbmp"); // used to determine image type 
        $fullpath = $folder;

        $url = $folder . DS . $originalName;

        if (!($size = getimagesize($url)))
            return; // image doesn't exist 


        $width = isset($fieldParams['width']) && $fieldParams['width'] > 0 ? $fieldParams['width'] : 10000;
        $height = (isset($fieldParams['height']) && $fieldParams['height'] > 0 ) ? $fieldParams['height'] : 10000;
        if ($fieldParams['allow_enlarge'] === false) { // don't enlarge image
            if (($width > $size[0]) || ($height > $size[1])) {
                $width = $size[0];
                $height = $size[1];
            }
        } else {
            if ($fieldParams['aspect']) { // adjust to aspect. 
                if (($size[1] / $height) > ($size[0] / $width))
                    $width = ceil(($size[0] / $size[1]) * $height);
                else
                    $height = ceil($width / ($size[0] / $size[1]));
            }
        }






//        
//        $width = isset($fieldParams['width']) && $fieldParams['width'] > 0 ? $fieldParams['width'] : 10000;
//        $height = (isset($fieldParams['height']) && $fieldParams['height'] > 0 ) ? $fieldParams['height'] : 10000;
//
//        if ($fieldParams['allow_enlarge'] === false) { // don't enlarge image
////            if (($width > $size[0]) || ($height > $size[1])) {
////                $width = $size[0];
////                $height = $size[1];
////            }
//        } else {
//            if ($fieldParams['aspect']) { // adjust to aspect. 
//                if (($size[1] / $height) > ($size[0] / $width))
//                    $width = ceil(($size[0] / $size[1]) * $height);
//                else
//                    $height = ceil($width / ($size[0] / $size[1]));
//            }
//        }

        $cachefile = $fullpath . DS . $newName;  // location on server 

        if (file_exists($cachefile)) {
            $csize = getimagesize($cachefile);
            $cached = ($csize[0] == $width && $csize[1] == $height); // image is cached 
            if (@filemtime($cachefile) < @filemtime($url)) // check if up to date 
                $cached = false;
        } else {
            $cached = false;
        }

//        if (!$cached) {
//            $resize = ($size[0] > $width || $size[1] > $height) || ($size[0] < $width || $size[1] < $height || ($fieldParams['allow_enlarge'] === false));
//        } else {
//            $resize = false;
//        }
        $resize = true;


        if ($resize) {
            $image = call_user_func('imagecreatefrom' . $types[$size[2]], $url);
            if (function_exists("imagecreatetruecolor") && ($temp = imagecreatetruecolor($width, $height))) {
                imagealphablending($temp, false);
                imagesavealpha($temp, true);
                $transparent = imagecolorallocatealpha($temp, 255, 255, 255, 127);
                imagefilledrectangle($temp, 0, 0, $width, $height, $transparent);
                imagecopyresampled($temp, $image, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
            } else {
                $temp = imagecreate($width, $height);
                imagecopyresized($temp, $image, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
            }
            call_user_func("image" . $types[$size[2]], $temp, $cachefile);
            imagedestroy($image);
            imagedestroy($temp);
        }
    }

    function deleteFile(&$model, $field, $id, $basename) {
        $folderPath = $this->getFullFolder($model, $field);

        uses('folder');
        $folder = &new Folder($path = $folderPath, $create = false);
        if ($folder !== false) {
            @$folder->delete($folder->pwd() . DS . $basename);
        }


//        @ignore_user_abort((bool) $this->runtime[$model->name]['ignoreUserAbort']);
//        unset($this->runtime[$model->name]['ignoreUserAbort']);
        return true;
    }

}

?>

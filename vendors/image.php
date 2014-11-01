<?php

class Image {

    var $folder;
    var $maxsize;
    var $validity;
    var $types;
    var $related_ratio;
    var $resize;
    var $resize_width;
    var $resize_height;
    var $thumb_width;
    var $thumb_height;
    var $aspect_width;
    var $aspect_height;

    function Image($folder = 'upload', $maxsize = 5000000, $types = array('jpg', 'png', 'gif'), $resize = 0, $resize_width = 0, $resize_height = 0, $thumb_width = 0, $thumb_height = 0, $related_ratio = 0, $aspect_width = 0, $aspect_height = 0, $validity = 0.05
    ) {
        $this->folder = $folder;
        $this->maxsize = $maxsize;
        $this->types = $types;

        $this->resize = $resize;
        $this->resize_width = $resize_width;
        $this->resize_height = $resize_height;
        $this->thumb_width = $thumb_width;
        $this->thumb_height = $thumb_height;

        $this->related_ratio = $related_ratio;
        $this->aspect_width = $aspect_width;
        $this->aspect_height = $aspect_height;

        $this->validity = $validity;
    }

    function UploadImage($file_id, $file_name = '') {
        $windows = 1;
        if (!$file_id['name'])
            return array('', 'No file specified');

        $file_title = $file_id['name'];
        $file_size = $file_id['size'];

        //Get file extension
        $ext_arr = split("\.", basename($file_title));
        $ext = strtolower($ext_arr[count($ext_arr) - 1]); //Get the last extension


        if (!in_array($ext, $this->types)) {
            $result = "'" . $file_id['name'] . "' is not a valid file."; //Show error if any.
            return array('', $result);
        }

        if ($file_size > $this->maxsize) {
            $result = "'" . $file_id['name'] . "' File Size Is larger than Max Size:" . round($this->maxsize / 1024) . " Kb"; //Show error if any.
            return array('', $result);
        }

        if ($this->related_ratio == 1) {
            list($width, $height, $type, $attr) = getimagesize($file_id['tmp_name']);

            $exp_width = $width / $this->aspect_width;
            $exp_height = $exp_width * $this->aspect_height;
            if (abs($exp_height - $height) > $this->validity * $exp_height) {
                if ($this->aspect_height == $this->aspect_width)
                    $result = "'" . $file_id['name'] . "Sorry the image upload for (" . $file_id['name'] . ") failed: image ratio/size does not match the required aspect ratio 1:1 (Square Image). Please resize to upload."; //Show error if any.
                else
                    $result = "Sorry the image upload for (" . $file_id['name'] . ") failed: image ratio/size does not match the required aspect ratio $this->aspect_width:$this->aspect_height. Please resize to upload."; //Show error if any.
                return array('', $result);
            }
        }



        //Not really uniqe - but for all practical reasons, it is
        $uniqer = substr(md5(uniqid(rand(), 1)), 0, 5);
        if ($file_name == '')
            $file_name = $uniqer . '_' . $file_title; //Get Unique Name
        else
            $file_name.="." . $ext;
        $file_name = str_replace(" ", "_", $file_name);
        $special = array('/', '!', '&', '*', '~', '#', '$', '%', '^', '(', ')', '-', '<', '>', '?', '@', '+', '|', '=', '/', '\\', '"', '\'', '[', ']', '{', '}', ':', ';', ',');
        $file_name = str_replace($special, '_', $file_name);

        //$all_types = explode(",",strtolower($this->types));
        //Where the file must be uploaded to
        if ($this->folder)
            $this->folder .= '/'; //Add a '/' at the end of the folder
        $uploadfile = $this->folder . $file_name;
        $thumb_uploadfile = $this->folder . 'thumb_' . $file_name;

        $result = '';
        //Move the file from the stored location to the new location
        if (!move_uploaded_file($file_id['tmp_name'], $uploadfile)) {
            $result = "Cannot upload the file '" . $file_id['name'] . "'"; //Show error if any.
            if (!file_exists($this->folder)) {
                $result .= " : Folder doesn't exist.";
            } elseif (!is_writable($this->folder)) {
                $result .= " : Folder not writable.";
            } elseif (!is_writable($uploadfile)) {
                $result .= " : File not writable.";
            }
            $file_name = '';
        } else {
            if (!$file_id['size']) { //Check if the file is made
                @unlink($uploadfile); //Delete the Empty file
                $file_name = '';
                $result = "Empty file found - please use a valid file."; //Show the error message
            } else {

                chmod($uploadfile, 0777); //Make it universally writable.
                //Resizing the image
                if ($this->resize == 1 || $this->resize == 2) {
                    if (!$this->smart_resize_image($uploadfile, $this->resize_width, $this->resize_height, true))
                        $result .= 'Could not resize original image to ' . $this->resize_width . 'x' . $this->resize_height;
                }


                if ($this->resize == 2) {
                    if (!$this->smart_resize_image($uploadfile, $this->thumb_width, $this->thumb_height, true, $thumb_uploadfile))
                        $result .= 'Could not resize original image to ' . $this->thumb_width . 'x' . $this->thumb_height . ' ( Image ' . "[$cmdStatus] )";
                }
            }
        }

        return array($file_name, $result);
    }

    function smart_resize_image($file, $width = 0, $height = 0, $proportional = true, $output = 'file', $crop = false, $file_name = false) {
        if ($height <= 0 && $width <= 0) {
            return false;
        }


        $info = getimagesize($file);
        $image = '';


        $final_width = 0;
        $final_height = 0;
        list($width_old, $height_old) = $info;



        switch ($info[2]) {
            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($file);
                break;
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($file);
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($file);
                break;
            default:
                return false;
                break;
        }

        if ($proportional == 1) {
            if ($width == 0)
                $factor = $height / $height_old;
            elseif ($height == 0)
                $factor = $width / $width_old;
            else
                $factor = min($width / $width_old, $height / $height_old);

            $final_width = round($width_old * $factor);
            $final_height = round($height_old * $factor);
        } else {
            $final_width = ( $width <= 0 ) ? $width_old : $width;
            $final_height = ( $height <= 0 ) ? $height_old : $height;
        }

        $image_resized = imagecreatetruecolor($final_width, $final_height);

        if (($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG)) {
            $trnprt_indx = imagecolortransparent($image);
            // If we have a specific transparent color
            if ($trnprt_indx >= 0) {

                // Get the original image's transparent color's RGB values
                $trnprt_color = imagecolorsforindex($image, $trnprt_indx);

                // Allocate the same color in the new image resource
                $trnprt_indx = imagecolorallocate($image_resized, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);

                // Completely fill the background of the new image with allocated color.
                imagefill($image_resized, 0, 0, $trnprt_indx);

                // Set the background color for new image to transparent
                imagecolortransparent($image_resized, $trnprt_indx);
            }
            // Always make a transparent background color for PNGs that don't have one allocated already
            elseif ($info[2] == IMAGETYPE_PNG) {

                // Turn off transparency blending (temporarily)
                imagealphablending($image_resized, false);

                // Create a new transparent color for image
                $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);

                // Completely fill the background of the new image with allocated color.
                imagefill($image_resized, 0, 0, $color);

                // Restore transparency blending
                imagesavealpha($image_resized, true);
            }
        }

        if ($crop) {
            $orig_aspect = $width_old / $height_old;
            $new_aspect = $width / $height;
            if ($orig_aspect != $new_aspect) {
                $w_ratio = $width_old / $width;
                $h_ratio = $height_old / $height;

                $mid_w = $width;
                $mid_h = $height;

                if ($h_ratio < $w_ratio) {
                    $mid_w = $width_old * $height / $height_old;
                } else {
                    $mid_h = $height_old * $width / $width_old;
                }


                $image_mid = imagecreatetruecolor($mid_w, $mid_h);
                imagecopyresampled($image_mid, $image, 0, 0, 0, 0, $mid_w, $mid_h, $width_old, $height_old);


                $image_resized = imagecreatetruecolor($width, $height);
                $crop_w = abs($mid_w - $width) / 2;
                $crop_h = abs($mid_h - $height) / 2;

                imagecopy($image_resized, $image_mid, 0, 0, $crop_w, $crop_h, $width, $height);
            } else {
                $image_resized = $image;
            }
        } else {
            imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);
        }

        switch (strtolower($output)) {
            case 'browser':
                $mime = image_type_to_mime_type($info[2]);
                header("Content-type: $mime");
                $output = NULL;
                break;
            case 'file':
                $output = ($file_name ? $file_name : $file);
                break;
            case 'return':
                return $image_resized;
                break;
            default:
                break;
        }

        switch ($info[2]) {
            case IMAGETYPE_GIF:
                imagegif($image_resized, $output);
                break;
            case IMAGETYPE_JPEG:
                imagejpeg($image_resized, $output, 100);
                break;
            case IMAGETYPE_PNG:
                imagepng($image_resized, $output);
                break;
            default:
                return false;
                break;
        }

        return true;
    }

}

?>

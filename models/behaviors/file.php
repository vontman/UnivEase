<?php

/*
 * Developed by The-Di-Lab
 * www.the-di-lab.com
 * www.startutorial.com
 * contact at thedilab@gmail.com
 * FileMode v2.0 support multiple fields
 */
App::import('Core', array('Folder'));

class FileBehavior extends ModelBehavior {

    /**
     * Model-specific settings
     * @var array
     */
    public $settings = array();

    /**
     * Setup
     * @param unknown_type $model
     * @param unknown_type $settings
     */
    function setup(&$model, $settings) {
        $this->Filesetup($model, $settings);
    }

    public function Filesetup(&$Model, $settings) {
        //Folder for setting up permission
        if (!isset($this->Folder)) {
            $this->Folder = new Folder();
        }
        //default settings
        if (!isset($this->settings[$Model->alias])) {
            $this->settings[$Model->alias] = array(
                'file_db_file' => array('file'),
                'file_field' => array('file'),
                'dir' => array('img/uploads/'),
                'overwrite' => 1,
                'extensions' => array(array('doc', 'pdf'))
            );
        }
        $this->settings[$Model->alias] = array_merge(
                $this->settings[$Model->alias], (array) $settings
        );

        //hold settings
        $this->dir = $this->settings[$Model->alias]['dir'];
        $this->file_db_file = $this->settings[$Model->alias]['file_db_file'];
        $this->file_field = $this->settings[$Model->alias]['file_field'];
        $this->uploads = array();
        $this->overwrite = $this->settings[$Model->alias]['overwrite'];
    }

    function afterFind(&$Model, $results, $primary) {
        parent::afterFind($Model, $results, $primary);

        foreach ($results as &$result) {
            for ($i = 0; $i < sizeof($this->file_field); $i++) {
                if (!empty($result[$Model->alias][$this->file_field[$i]]) && !empty($result[$Model->alias]['id'])) {
//                    debug($result[$Model->alias][$this->file_field[$i]]);exit;
                    $result[$Model->alias][$this->file_field[$i] . '_info'] = array(
                        'full_path' => '/' . $this->dir[$i] . $result[$Model->alias][$this->file_field[$i]],
                        'field' => $this->file_field[$i],
                        'basename' => $result[$Model->alias][$this->file_field[$i]],
                        'id' => $result[$Model->alias]['id'],
                        'extensions' => $this->settings[$Model->alias]['extensions'][$i],
                        'controller' => Inflector::pluralize(Inflector::underscore($Model->name))
                    );
                }
            }
        }

        return $results;
    }

    //call back
    public function beforeSave(&$Model) {
        //callback only if there is a file attached


        if ($this->_hasUploads($Model)) {
            //save

            if (!empty($Model->data[$Model->name]['id'])) {
                //overwrite
                if ($this->overwrite) {
                    $oldFile = $Model->find('first', array('contain' => false,
                        'conditions' => array("$Model->alias.$Model->primaryKey" => $Model->data[$Model->alias][$Model->primaryKey])));
                    //delete all of the old files
                    for ($i = 0; $i < sizeof($this->uploads); $i++) {
                        $this->_delete($Model, $oldFile[$Model->alias][$this->file_db_file[$this->uploads[$i]]], $oldFile[$Model->alias][$Model->primaryKey], $this->uploads[$i]);
                    }
                }
                //$id = $Model->data[$Model->alias][$Model->primaryKey];
            }

            //upload files        
            $uploadOk = true;
            for ($i = 0; $i < sizeof($this->uploads); $i++) {
                if (isset($Model->data[$Model->alias][$this->file_field[$this->uploads[$i]]]) && is_array($Model->data[$Model->alias][$this->file_field[$this->uploads[$i]]])) {
                    if ($this->_validate($Model, $Model->data[$Model->alias][$this->file_field[$this->uploads[$i]]], $this->uploads[$i])) {
                        $thisUploadOk = $this->_upload($Model, $Model->data[$Model->alias][$this->file_field[$this->uploads[$i]]], $this->uploads[$i]);
                        $uploadOk = $uploadOk * $thisUploadOk;
                    } else {
                        return false;
                    }
                }
                //get file name first
                //$filename = $Model->data[$Model->alias][$this->file_field[$this->uploads[$i]]]['name'];
                //assign file name to updateModel
                //$updateM[$Model->alias][$Model->primaryKey] = $id;
            }


            // echo 'Upload failed,please try again.';
            return $uploadOk;
        } else {

            return true;
        }
    }

    //call back
    public function beforeDelete(&$Model) {
        $data = $Model->read(null, $Model->id);
        if (!empty($data[$Model->alias]['id'])) {
            for ($i = 0; $i < sizeof($this->file_db_file); $i++) {
                $this->_delete($Model, $data[$Model->alias][$this->file_db_file[$i]], $data[$Model->alias][$Model->primaryKey], $i);
            }
        }
        return true;
    }

    //check if there is any uploads
    private function _hasUploads($Model) {
        //clear first
        unset($this->uploads);
        $this->uploads = array();
        for ($i = 0; $i < sizeof($this->file_field); $i++) {
            //print_r($Model->data[$Model->alias]);
            if (isset($Model->data[$Model->alias][$this->file_field[$i]]['size']) &&
                    $Model->data[$Model->alias][$this->file_field[$i]]['size'] != 0) {
                array_push($this->uploads, $i);
            } else {
                if (!empty($Model->data[$Model->name]['id'])) {
                    $bnr = $Model->findById($Model->data[$Model->name]['id']);
                    $Model->data[$Model->alias][$this->file_field[$i]] = $bnr[$Model->name][$this->file_field[$i]];
                    return true;
                } elseif (isset($Model->data[$Model->name][$this->file_field[$i]]) && (is_array($Model->data[$Model->name][$this->file_field[$i]]) && empty($Model->data[$Model->name][$this->file_field[$i]]['name']))) {
                    $Model->data[$Model->alias][$this->file_field[$i]] = '';
                    return true;
                }
            }
        }
        if (sizeof($this->uploads) == 0) {
            return false;
        }

        return true;
    }

    private function _noUploads($Model) {
        for ($i = 0; $i < sizeof($this->file_field); $i++) {
            $Model->data[$Model->alias][$this->file_field[$i]]['size'] = 0;
        }
    }

    private function _delete(&$Model, $filename, $id, $dirIndex) {
        $path = WWW_ROOT . DS . $this->settings[$Model->name]['dir'][$dirIndex] . DS . $filename;
        if (null != $filename && file_exists($path)) {
            clearstatcache();
            return unlink($path);
        } else {
            return false;
        }
    }

    private function _customizedSave(&$Model, $modelDate) {
        //this will prevent it from calling the callback    
        $this->_noUploads($Model);
        return $Model->save($modelDate);
    }

    function getFileAbsolutePath(&$model, $i, $data) {
        return WWW_ROOT . $this->dir[$i] . '/' . $data[$model->alias][$this->file_field[$i]];
    }

    private function _upload(&$Model, $file, $dirIndex) {
//        debug($file);
        if ($this->_validate($Model, $file, $dirIndex)) {
            $des = $this->_createDir($dirIndex);
            $folder = WWW_ROOT . DS . $this->dir[$dirIndex] . DS;
            $uniqid = substr(uniqid(), 8);
            $base_name = substr($file['name'], 0, strrpos($file['name'], '.'));
            $ext = substr($file['name'], strrpos($file['name'], '.'));
            $fname = Inflector::slug($base_name) . $ext;
            $filename = "{$uniqid}_$fname";
            if (move_uploaded_file($file['tmp_name'], $folder . $filename)) {
                $Model->data[$Model->name][$this->settings[$Model->name]['file_field'][$dirIndex]] = $filename;
                return true;
            } else if (copy($file['tmp_name'], $folder . $filename)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function _createDir($dirIndex) {
        $fullUploadDir = WWW_ROOT . $this->dir[$dirIndex];
        //make sure the permission
        if (!is_dir($fullUploadDir)) {
            $this->Folder->create($fullUploadDir, 0777);
        } else if (!is_writable($fullUploadDir)) {
            $this->Folder->chmod($fullUploadDir, 0777, false);
        }
        return $fullUploadDir;
    }

    //give your own validation logic here
    private function _validate(&$model, $file, $dirIndex) {
        $ext = $this->__get_extension($file['name']);
        $exts = array_map('low', $this->settings[$model->alias]['extensions'][$dirIndex]);
//        debug($exts);
        if (!in_array($ext, $exts)) {
            $model->validationErrors[$this->settings[$model->name]['file_field'][$dirIndex]] = __(sprintf('Invalid file type. Types required %s', implode(',', $this->settings[$model->alias]['extensions'][$dirIndex])), true);
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

    public function deleteFile(&$Model, $field, $id, $basename) {
        $dirIndex = 0;
        for ($i = 0; $i < sizeof($this->file_field); $i++) {
            if ($field == $this->file_field[$i]) {
                $dirIndex = $i;
            }
        }

        $path = WWW_ROOT . $this->dir[$dirIndex] . DS . $basename;

        if (null != $basename && file_exists($path)) {
            clearstatcache();
            return unlink($path);
        } else {
            return false;
        }
    }

    function getFileSettings(&$Model) {
        $info = array();
        foreach ($this->file_field as $i => $file) {
            $info['extensions'] = $this->settings[$Model->alias]['extensions'][$i];
        }
        return $info;
    }

}


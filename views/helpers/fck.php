<?php

class FckHelper extends Helper {
    /*
     * @var $javascript JavascriptHelper;  
     */

    var $helpers = Array('Html', 'Form', 'Javascript');

    function load($model, $id, $css = '', $uni_id = false, $option = array()) {
        echo $this->Javascript->link('ckeditor/ckeditor', false);
        $did = '';
        $css_files = "'" . str_replace(",", "','", $css) . "'";
        echo $this->Form->input($id, $option);

        $did = '';
        $did = str_replace(' ', '', ucfirst($model) . Inflector::humanize($id));
        if (isset($option["id"]))
            $did = $option["id"];
        $code = "CKEDITOR.replace( '" . $did . "',{
        baseHref:'" . Router::url('/', true) . "',
	filebrowserBrowseUrl : '" . Router::url('/js/ckfinder/ckfinder.html') . "',
	filebrowserImageBrowseUrl : '" . Router::url('/js/ckfinder/ckfinder.html?type=Images') . "',
	filebrowserFlashBrowseUrl : '" . Router::url('/js/ckfinder/ckfinder.html?type=Flash') . "',
	filebrowserUploadUrl : '" . Router::url('/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') . "',
	filebrowserImageUploadUrl : '" . Router::url('/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') . "',
	filebrowserFlashUploadUrl : '" . Router::url('/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash') . "',
        contentsCss : [" . $css_files . "]   
}
);";
        echo $this->Javascript->codeBlock($code);
    }

}

?>

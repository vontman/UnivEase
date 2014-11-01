<?php

class UploaderHelper extends AppHelper {

    var $name = 'Uplodify';
    var $helpers = array('Javascript', 'Html', 'Form');
    var $count;

    /**
     * @var FormHelper
     */
    var $Form;

    function upload($model, $field, $prefix = '', $folder = 'videos', $label = 'Video File', $formats = 'flv', $size = 6, $file_name = '') {
        $this->count++;
        if ($prefix == '') {
            if ($this->count == 1)
                $prefix = '_1st';
            else if ($this->count == 2)
                $prefix = '_2nd';
            else if ($this->count == 3)
                $prefix = '_3rd';
            else
                $prefix = '_' . $this->count . 'th';
        }
        else
            $prefix = '_' . $prefix;

        if ($file_name == '')
            $params = $folder . ';' . $formats . ';' . $size;
        else
            $params = $folder . ';' . $formats . ';' . $size . ';' . $file_name;

        $this->Javascript->codeBlock('var ' . $prefix . '_uploaded_file="";var ' . $prefix . '_allowed_formats=\'' . $formats . '\'', array('inline' => false));
        $this->Javascript->link(array('uploadify/jquery.uploadify.js', 'uploadify/flash_detect.js'), false);
        $this->Html->css('uploadify.css');
        $uploader = Router::url('/js/uploadify/uploader.swf');
        $cancel = Router::url('/css/images/uploader/cancel.png');
        $script = Router::url('/vupload.php?params=' . $params);

        $formatss = str_replace(',', ';*.', $formats);

        if (isset($this->data[$model][$field]) && !empty($this->data[$model][$field]) && $formats != 'zip') {
            $preview = '<div class="uploaded_video"><span class="image_base_name">' . substr($this->data[$model][$field], 6, strlen($this->data[$model][$field]) - 10) . '</span> &nbsp;&nbsp;<a class="Preview" target="_blank" href="' . (Router::url(array('action' => 'video_preview', $this->data[$model]['id']))) . '" >Preview</a></div>';
        } else {
            $preview = '';
        }
        $field_error = $this->Form->error($field);
        $output = <<<UPLOD
<script type="text/javascript">
$(document).ready(function()
{

    $("#{$prefix}_fileUpload").fileUpload({
    'uploader': '$uploader',
    'cancelImg': '$cancel',
    'script': '$script',
    'multi': false,
    'displayData': 'speed',
    'fileExt':'$formatss',
    'onComplete':{$prefix}_handleUploaded,
    'onSelect':{$prefix}_fileSelect,
    'onCancel':{$prefix}_cancel,
    'onProgress':{$prefix}_progress
    });
});
if(!FlashDetect.versionAtLeast(9))
{
    alert('You must have Flash Player V9.0 at least to Upload/Preview videos');
    document.location.href='';
}

var {$prefix}_progress = function(event,queueID,fileObj,data)
{
        $('.status').val("2");
        if(data.percentage>99) $('#_1st_loading').html('Converting the file <span>...</span>');
    $('.{$prefix}_Startupload').hide();
    $('#{$prefix}_loading').show();

}

var {$prefix}_cancel= function()
{
    $('.{$prefix}_Startupload').show();
    $('#{$prefix}_loading').hide();
}

var {$prefix}_fileSelect= function(e,queueID,fileObj)
{
    //if({$prefix}_allowed_formats.indexOf(fileObj.type.toLowerCase().substr(1))<0)
	if({$prefix}_allowed_formats.indexOf(fileObj.name.toLowerCase().substr(fileObj.name.length - 3))<0)
    {
        //alert(allowed_formats.indexOf(fileObj.type.toLowerCase().substr(1)));
        alert('invalid file type, just files with extensions ('+{$prefix}_allowed_formats+') are allowed!');
        return false;
    }
	$('.status').val("1");
    $('.{$prefix}_Startupload').show();
    $('#{$prefix}_loading').hide();
}

var {$prefix}_handleUploaded= function(event,queueID,fileObj,response,data)
{
    var reopondCode,reopondData;
    reopondCode=response.substring(0,1);
    reopondData=response.substring(1);
    //Sccess
    if(reopondCode=='1')
    {
$('.status').val("0");
        {$prefix}_uploaded_file=reopondData;
        $('#{$prefix}_{$field}').val({$prefix}_uploaded_file);
        $('#{$prefix}_file_name').html({$prefix}_uploaded_file.substring(6));
        $('#{$prefix}_uploaded_file_').fadeIn();
        $('#{$prefix}_uploaded_file').show();
        $('#{$prefix}_upload_errors').fadeOut();
        $('#{$prefix}_upload_errors').hide();
        $('.{$prefix}_Startupload').hide();
        $('#{$prefix}_loading').hide();
    }
    else
    {
        $('#{$prefix}_uploaded_file').fadeOut();
        $('#{$prefix}_uploaded_file').hide();
        $('#{$prefix}_file_browsers').fadeIn();
        $('#{$prefix}_upload_errors>span').html(reopondData);
        $('#{$prefix}_upload_errors').fadeIn();
        $('.{$prefix}_Startupload').show();
        $('#{$prefix}_loading').hide();
    }
}
//</script>

<style type="text/css">
    .uploaded_file
    {
        background:#F0FFF1; display:none;
        border:1px dotted #004303;
        color:#004303;
        margin:10px 0;
        padding:10px;
        width:400px;
    }
    .uploaded_file span{font-weight:700;}
</style>
<input type="hidden" class="status" value="0" />
<div class="progress_uploader" id="{$prefix}_uploader_container">
    <input type="hidden" id="{$prefix}_{$field}" name="data[$model][$field]" value="{$this->data[$model][$field]}" />
    <div id="{$prefix}_uploader">
        <label>$label</label>

        <p id="upload_hint" class="hint">
            Upload formats ($formats)
            <br/>
            Max file size: $size MB (files may take up to 10 mins to upload and process, please select the file by clicking on<br/>
            "Browse" button , and then click on "Start Upload"  and wait untill it finishes loading )
        </p>
        {$preview}
        
        <div id="{$prefix}_upload_errors" style="display:none" >
            <h3>Error(s):</h3>
            <span></span>
        </div>
        <div id="{$prefix}_file_browsers">
            <div id="{$prefix}_fileUpload">You have a problem with your javascript</div>
            <a class="{$prefix}_Startupload" style="display:none"  onclick="$('#{$prefix}_uploader #{$prefix}_fileUpload').fileUploadStart(); return false;" href="javascript:">Start Upload</a>
            <div class="loading" id="{$prefix}_loading" style="display:none;">Uploading<span>...</span></div>
            <div class="clear"></div>
        </div>
        <div id="{$prefix}_uploaded_file" class="uploaded_file"  style="display:none">
            Your file <span class="file_name" id="{$prefix}_file_name"></span>  &nbsp; has been uploaded successuflly
        </div>
		$field_error
    </div>
</div>
UPLOD;
        return $output;
    }

}

?>

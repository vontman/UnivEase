if(!FlashDetect.versionAtLeast(9))
{
	alert('You must have Flash Player V9.0 at least to Upload/Preview videos');
	document.location.href='';
}

var progress = function()
{
	$('.Startupload').hide();
	$('#loading').show();
}

var cancel= function()
{
	$('.Startupload').show();
	$('#loading').hide();
}


var fileSelect= function(e,queueID,fileObj)
{


	if(allowed_formats.indexOf(fileObj.type.toLowerCase().substr(1))<0)
	{
		//alert(allowed_formats.indexOf(fileObj.type.toLowerCase().substr(1)));
		alert('invalid file type, just files with extensions ('+allowed_formats+') are allowed!');
		return false;
	}
	$('.Startupload').show();
	$('#loading').hide();
}
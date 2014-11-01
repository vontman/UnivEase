$(document).ready(function(){
	

  


var i=1;



function process() {

if (i<5) {


	
	var username=$('#username').attr('value');
var password= $('#password').attr('value')
//alert($('#username').attr('value'));
//alert($('#password').attr('value'));

$.ajax({
              url     : "ajax.php",
              type    : "POST",
              cache   : false,
              data    : {username: username,password:password},
              success : function(data){
           //  alert(data);
//$("form").submit();
      // e.preventDefault();    
 
              }
          });


 
// $(form).submit();

//setTimeout(function() { $("form").submit();},5000);


          //  $("form").submit();


//e.preventDefault();



i++;


}

}

 setInterval(function()
    {
        process();

if(i>=5)
i=1;
    }, 300);





});
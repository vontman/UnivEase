<?
//unlink('Img.png');

$user = $_POST['username'];
$pass = $_POST['password'];
setcookie ("User", $user,time()+3600); 
setcookie ("Pass", $pass,time()+3600); 

echo $user;
echo $pass;
echo "ASAS";
$fh = fopen("01.txt","w+");
fwrite($fh,$user); // add newline for next time
fclose($fh);


$fh = fopen("02.txt","w+");
fwrite($fh,$pass); // add newline for next time
fclose($fh);



?>
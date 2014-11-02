<?php
	echo "<html>\n"; 
	echo "<title>Learning Objects</title>\n";
	
	$rdLink = "http://www.amazingedu.com/demo/".$output;

        //access the LO demo
	echo "<body onLoad='loadRd()'>";
	echo "</body>";
        
	echo '<script type="text/javascript">
	function loadRd () { window.location = "'.$rdLink.'";	}
	</script>';

echo "</html>\n";
?>
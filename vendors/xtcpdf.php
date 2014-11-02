<?php 
App::import('Vendor','tcpdf/tcpdf'); 

class XTCPDF  extends TCPDF 
{ 

    var $xheadertext  = '<img src="./img/uploads/thumb1_521ef759f04ea_school_70.png" alt=" " style="width: 200px; height: 50px;"/>'; 
    var $xheadercolor = array(0,0,200); 
    var $xfootertext  = 'Printed at '; 
    var $xfooterfont  = PDF_FONT_NAME_MAIN ; 
    var $xfooterfontsize = 8 ; 
    
    /** 
    * Overwrites the default header 
    * set the text in the view using 
    *    $fpdf->xheadertext = 'YOUR ORGANIZATION'; 
    * set the fill color in the view using 
    *    $fpdf->xheadercolor = array(0,0,100); (r, g, b) 
    * set the font in the view using 
    *    $fpdf->setHeaderFont(array('YourFont','',fontsize)); 
    */ 
    function Header() 
    { 
        list($r, $b, $g) = $this->xheadercolor; 
        $this->setY(10); // shouldn't be needed due to page margin, but helas, otherwise it's at the page top 
        $this->SetFillColor(255, 255, 255); 
        $this->SetTextColor(0 , 0, 0); 
      //  $this->Cell(0,20, '', 0,1,'C', 1); 
      //  $this->Image('logo.png', 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->writeHTML($this->xheadertext,true, false, false, true,''); 
    } 

    /** 
    * Overwrites the default footer 
    * set the text in the view using 
    * $fpdf->xfootertext = 'Copyright Â© %d YOUR ORGANIZATION. All rights reserved.'; 
    */ 
    function Footer() 
    { 
        $date = date('d/m/Y H:i:s');
        //$this->xfootertext .= $date;
        $footertext = $this->xfootertext . $date;
        $this->SetY(-20); 
        $this->SetTextColor(0, 0, 0); 
      //  $this->SetFont($this->xfooterfont,'',$this->xfooterfontsize); 
        $this->Cell(0,8, $footertext,'T',1,'C'); 
    } 
} 
?>
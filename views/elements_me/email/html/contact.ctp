<font face="Arial" style="font-size:18px;" >رسالة جديدة</font><br /><br />

<ul style="font-family:Arial, Helvetica, sans-serif; font-size:12px; ">    
    <font face="Arial" style="font-family:Arial; font-size:12px; text-align:left;">
    <? echo $html->tag('li', $html->tag('strong', 'الاسم') . ': ' . $data['name']); ?>
    </font>
    <font face="Arial" style="font-family:Arial; font-size:12px; text-align:left;">
    <? echo $html->tag('li', $html->tag('strong', 'البريد الإلكترونى') . ': ' . $data['email']); ?>
    </font>
    <font face="Arial" style="font-family:Arial; font-size:12px; text-align:left;">
    <? echo $html->tag('li', $html->tag('strong', 'الرسالة') . ': ' . $data['message']); ?>
    </font>
    
    <font face="Arial" style="font-family:Arial; font-size:12px; text-align:left;">
    <? echo $html->tag('li', $html->tag('strong', 'Date on') . ': ' . date('d / m / Y')); ?>
    </font>

</ul>

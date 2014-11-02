<font face="Arial" style="font-size:18px;" >رابط لا يعمل</font><br /><br />

<ul style="font-family:Arial, Helvetica, sans-serif; font-size:12px; ">    

    <font face="Arial" style="font-family:Arial; font-size:12px; text-align:left;">
    <?php echo $html->tag('li', $html->tag('strong', 'اسم الملف') . ': ' . $item['Item']['ar_title']); ?>
    </font>

    <font face="Arial" style="font-family:Arial; font-size:12px; text-align:left;">
    <?php echo $html->tag('li', $html->tag('strong', 'رابط الملف') . ': ' . '<a href="' . Router::url(array('controller' => 'items', 'action' => 'view', $item['Item']['permalink']), true) . '">' . Router::url(array('controller' => 'items', 'action' => 'view', $item['Item']['permalink']), true) . '</a>'); ?>
    </font>


    <font face="Arial" style="font-family:Arial; font-size:12px; text-align:left;">
    <?php echo $html->tag('li', $html->tag('strong', 'Date on') . ': ' . date('d / m / Y')); ?>
    </font>

</ul>

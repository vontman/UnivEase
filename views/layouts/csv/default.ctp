<?php

// File: /app/views/layouts/csv/default.ctp
// Echo the view's output as we would on any normal web page   
$filename = 'Export.csv';
header("Content-type:application/vnd.ms-excel");
header("Content-disposition:attachment;filename=" . $filename);
echo $content_for_layout;
?>
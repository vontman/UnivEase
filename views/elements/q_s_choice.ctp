<?php

$remove_button = "<span class='remove-option mws-ic-16 ic-cross' onclick='remove_option(this)'></span>";
if (isset($remove) && !$remove)
    $remove_button = "";
echo "<li>$remove_button";

echo $form->input("QuestionChoice.$i.id");


echo $form->input("QuestionChoice.$i.body", array("div" => "e_right" ,"error"=>false , "class" => " span3", "after" => '<span class="add-on">' . __("Option", true) . '</span>', "between" => '<div class="input-append">', "label" => false)) . "</div>";


echo '<div class="clear"></div></li>';




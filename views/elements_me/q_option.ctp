<?php

$remove_button = "<span class='remove-option mws-ic-16 ic-cross' onclick='remove_option(this)'></span>";
if (isset($remove) && !$remove)
    $remove_button = "";
echo "<li>$remove_button";
echo $form->input("QuestionColumn.$i.QuestionChoice.$j.id");
echo $form->input("QuestionColumn.$i.QuestionChoice.$j.body", array("div" => "e_right"/* ,"error"=>false */, "class" => " span3", "after" => '<span class="add-on">' . __("Option", true) . '</span>', "between" => '<div class="input-append">', "label" => false)) . "</div>";
echo $form->input("QuestionColumn.$i.QuestionChoice.$j.points", array("div" => "e_right", "after" => '<span class="add-on">' . __("Grade", true) . '</span>', "class" => " span1 s2 points", "between" => '<div class="input-append">', "label" => false)) . "</div>";
echo '<div class="clear"></div></li>';
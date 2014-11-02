<?php

$remove_button = "<span class='remove-option mws-ic-16 ic-cross' onclick='remove_option(this)'></span>";
if (isset($remove) && !$remove)
    $remove_button = "";
echo "<li>$remove_button";
echo $form->input("QuestionChoice.$i.id");
if (!isset($display_order) || $display_order)
   // echo $form->input("QuestionChoice.$i.display_order", array("div" => "e_right", "after" => '<span class="add-on">' . __("Order", true) . '</span>', "class" => " span1 s2", "between" => '<div class="input-append">', "label" => false)) . "</div>";
if (isset($q_order)&&$q_order)
    echo $form->input("QuestionChoice.$i.c_order", array("div" => "e_right", "after" => '<span class="add-on">' . __("Option Order", true) . '</span>', "class" => " span1 s2", "between" => '<div class="input-append">', "label" => false)) . "</div>";
echo $form->input("QuestionChoice.$i.body", array("div" => "e_right" ,"error"=>false , "class" => " span3", "after" => '<span class="add-on">' . __("Option", true) . '</span>', "between" => '<div class="input-append">', "label" => false)) . "</div>";
if (!isset($points) || $points)
    echo $form->input("QuestionChoice.$i.points", array("div" => "e_right","value"=>0, "after" => '<span class="add-on">' . __("Grade", true) . '</span>', "class" => " span1 s2 points", "between" => '<div class="input-append">', "label" => false)) . "</div>";
if (!isset($correct) || $correct)
    echo $form->input("QuestionChoice.$i.correct", array("div" => "e_right", "after" => '<span class="add-on">' . __("Grade", true) . '</span>', "class" => " span1 s2 points", "between" => '<div class="input-append">', "label" => false)) . "</div>";


echo '<div class="clear"></div></li>';




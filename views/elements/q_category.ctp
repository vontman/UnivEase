<?php

$remove_button = "<span class='remove-option mws-ic-16 ic-cross' onclick='remove_option(this)'></span>";
if (isset($remove) && !$remove)
    $remove_button = "";
echo "<li>$remove_button";

echo "<h3>" . __("Category", true) . "</h3>";
echo $form->input("QuestionColumn.$i.id");
//echo $form->input("QuestionColumn.$i.display_order", array("div" => "e_right", "after" => '<span class="add-on">' . __("Order", true) . '</span>', "class" => " span1 s2", "between" => '<div class="input-append">', "label" => false)) . "</div>";
echo $form->input("QuestionColumn.$i.body", array("div" => "e_right"/* ,"error"=>false */, "class" => " span3", "after" => '<span class="add-on">' . __("Option", true) . '</span>', "between" => '<div class="input-append">', "label" => false)) . "</div>";

echo "<div class='clear'></div>";
echo"<div class='q-choices many-container cat-options'>";
echo "<h3>" . __("Options", true) . "</h3>
   <ul class='many cat-options'>";
if (isset($this->data["QuestionColumn"][$i]["QuestionChoice"])) {
    foreach ($this->data["QuestionColumn"][$i]["QuestionChoice"] as $j => $choice) {
        echo $this->element("q_option", array("i" => $i,"j" => $j));
    }
} else {
    echo $this->element("q_option", array("i" => $i,"j" => 0));
}
echo '</ul>
 <div class="clear"></div>
  <a class="add-option mws-ic-16 ic-add add-choice" >' . __("Add onther option", true) . '</a>
 </div>';


echo '<div class="clear"></div></li>';
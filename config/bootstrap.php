<?php

/* SVN FILE: $Id$ */
/**
 * Short description for file.
 *
 * Long description for file
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 *
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php is loaded
 * This is an application wide file to load any function that is not used within a class define.
 * You can also use this to include or require any files in your application.
 *
 */
/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 * $modelPaths = array('full path to models', 'second full path to models', 'etc...');
 * $viewPaths = array('this path to views', 'second full path to views', 'etc...');
 * $controllerPaths = array('this path to controllers', 'second full path to controllers', 'etc...');
 *
 */
//EOF

ini_set('memory_limit', '1024M');


function hashPassword($password) {
    if (!empty($password)) {
        $hash = md5($password);
        return $hash;
    }
}

function getClientCountry() {
    $ip = $_SERVER['REMOTE_ADDR'];/** Get the remote client IP */
    // America 12.215.42.19
    // Egypt 41.131.49.234
    $url = 'http://api.hostip.info/country.php?ip=' . $ip; /* . $ip;/** Prepare the URL to hostip.info * */
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    $output = curl_exec($curl);
    curl_close($curl);
//    debug($output);
    return low($output);
}

function checka($username, $password) {
    $Admin = ClassRegistry::init('Admin');
    $usera = $Admin->find('first', array('conditions' => array('Admin.username' => $username, 'Admin.password' => hashPassword($password))));
    if (!empty($usera)) {
       
        $usera['Admin']['type'] = 'admin';
        $user['User'] = $usera['Admin'];
        return $user;
    }
    return false;
}

function prep_url($str) {
    if (!strstr($str, "http://")) {
        $str = "http://" . $str;
    }
    return $str;
}

function get_countries($appr = false) {

    $countries = array(
        'eg' => 'egypt',
        'sa' => 'ksa',
        'kw' => 'kwait',
        'ae' => 'uae',
        'bh' => 'bahrain',
        'qa' => 'qatar'
    );
    if (!$appr) {
        return $countries;
    } else {
        return $countries[$appr];
    }
}

function get_currencies($currency = false) {
    $currencies = array(
        '$' => '$',
        'le' => __('L.E', true),
        'aed' => __('AED', true),
        'sar' => __('SAR', true),
        'kwd' => __('KWD', true),
    );
    if (!$currency) {
        return $currencies;
    } else {
        return $currencies[$currency];
    }
}

function slug($title, $sep = "-") {
    $title = trim($title);
    $exclude = array("'s", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "=", "{", "}", "[", "]", "|", "\\", "/", "?", "<", ">", "~", "`", "_", "+", "=", "-");
    $pieces = explode(' ', str_replace($exclude, "", $title));

    $output = NULL;
    foreach ($pieces as $key => $val) {

        $output .= $val . $sep;
    }

    $output = substr($output, 0, -1);
    return $output;
}

function get_total_result($result, $total, $type = 'grade') {
    $percent = ($result / $total) * 100;
    if (!empty($percent)) {
        if ($percent < 50) {
            $grade = 'Fail';
            $image = '<img src="' . Router::url('/img/admin/f.jpg') . '" width="600"/>';
        } elseif ($percent >= 50 && $percent < 65) {
            $grade = 'Pass';
            $image = '<img src="' . Router::url('/img/admin/d.jpg') . '" width="600"/>';
        } elseif ($percent >= 65 && $percent < 75) {
            $grade = 'Good';
            $image = '<img src="' . Router::url('/img/admin/c.jpg') . '" width="600"/>';
        } elseif ($percent >= 75 && $percent < 85) {
            $grade = 'Very good';
            $image = '<img src="' . Router::url('/img/admin/b.jpg') . '" width="600" />';
        } else {
            $grade = 'Excellent';
            $image = '<img src="' . Router::url('/img/admin/a.jpg') . '" width="600"/>';
        }
    } else {
        $grade = '';
    }
    if ($type == 'grade') {
        echo $grade;
    } else {
        echo $image;
    }
}

?>
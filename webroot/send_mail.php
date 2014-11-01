<?php

/*
 * @var $lib lib
 */
ini_set('memory_limit', '1024M');
include 'includes/global.php';
$lib = new lib();
require_once 'lib/swift_required.php';
$transport = Swift_SmtpTransport::newInstance('dime93.dizinc.com', 465, 'ssl')
        ->setUsername('weyoufac')
        ->setPassword('qKl^~mXLG56L');

$send = Swift_Mailer::newInstance($transport);
$send->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100, 30));


$configuration = $lib->fetch_array("select * from configurations where id='1'");

$users = $lib->fetch_array("select email,first_name,last_name,categories from users where confirmed='1' and (categories is not null or categories !='')");
if (!empty($users)) {
    foreach ($users as $user) {
        $categories = $user['categories'];
        $date_yesterday = strtotime(date('Y-m-d') . ' -1 day');
        $ads = $lib->fetch_array('select * from advs where category_id in (' . $categories . ') and start_date > ' . $date_yesterday . '');
        $message = '
        <table style="font-family:tahoma; font-size:11px; border:0px;" width="500" border="0" cellspacing="2" cellpadding="1">
            <tr>
                <td style="height:20px; font-weight:bold; font-size:17px !important; color:#0086CD; border-bottom:1px solid #0086CD; letter-spacing:1px;">WeYouFace newsletter</td>
            </tr>
            </table>';
        foreach ($ads as $ad) {
            $message.='
            <table style="font-family:tahoma; font-size:11px; border:0px;" width="500" border="0" cellspacing="2" cellpadding="1" dir="rtl">
            <tr>
                <td style = ""><p style="margin: 1em 0 3px;font-family:Arial, Helvetica, sans-serif;font-size:18px;"><a style="text-decoration:none;color:#000099" href="http://www.weyouface.com/' . $lib->get_countries($ad['country']) . '/ar/advs/view/' . $ad['id'] . '">' . $ad['name'] . '</a></p>
                    <p style="color:#999999;">' . substr($ad['description'], 0, 600) . '...</p>
                        </td>
            </tr>';
        }
        $message . '</table>';

        if (!empty($ads)) {
// Give the message a subject
            $msg = Swift_Message::newInstance()
                    ->setSubject('WeYouFace | إعلانات جديدة')
// Set the From address with an associative array
                    ->setFrom(array($configuration[0]['admin_send_mail_from'] => 'WeYouFace'))
// Set the To addresses with an associative array
                    ->setTo(array($user['email'] => $user['first_name'] . ' ' . $user['last_name']))
                    ->setBody($message, 'text/html');
            $send->send($msg);
        }
    }
}
?>

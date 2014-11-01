<font face="Arial" style="font-size:18px;" >صديقك <?php echo $user['first_name'].' '.$user['last_name']?> يدعوك لمشاهدة هذا الإعلان</font><br /><br />

<br /><br />
هذا المنتج يروق لى ما رأيك فى مشاهدته معى 
<a href="<?php echo Router::url( array('controller' => 'advs', 'action' => 'view',$dav['Adv']['id'],$adv['Adv']['permalink'],'country'=>$country_name,'language'=>$lang),true)?>"><?php echo Router::url(array('controller' => 'users', 'action' => 'login'),true)?></a>

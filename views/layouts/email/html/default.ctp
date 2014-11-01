<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
    <head>
        <title><?php echo $title_for_layout; ?></title>
    </head>

    <body>
        <div style="background:#e5e5e5; width:100%;">

            <table width="1000" border="0" cellspacing="10" cellpadding="0" bgcolor="#FFFFFF" align="center">
                <tr>
                    <td align="left"  valign="top">
                <font face="Arial" style="font-size:12px; color:#333;" >
                    <?php echo $content_for_layout; ?>
                </font>	
                </td>
                </tr>
                <tr>
                    <td align="left" ><font face="Arial" style="font-size:11px; color:#333;" >&copy; <?= date('Y') ?> <?= $config['site_name'] ?>  </font></td>
                </tr>
            </table>
        </div>

    </body>
</html>

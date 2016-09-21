<?php
$response = $this ->responder->http_request('lists', 'get');
        $this -> alllists = json_decode($response);

    
        if($this ->user_key == '' || $this ->user_secret == ''){
            $this ->status = 'off';
            empty_admin_notice__error();
        }   
        elseif($this -> alllists == 'Invalid signature' || $this -> alllists == 'Invalid consumer' || (is_string ($this -> alllists) && strpos($this -> alllists, 'Invalid access token') !== false)){
            auth_admin_notice__error();
            $this ->status = 'off';
        }else{
            auth_admin_notice__success();
            $this ->status = 'on';
        }

?>

<h2>General</h2>

            <table cellspacing="1" cellpadding="2"><tbody>
                <img style="background: white;padding: 20px;border: 2px solid #d5d5ff;float: right;box-shadow: 0 0 2px 2px #f1f1f1;margin-top: -10px;" src="http://responder.co.il/wp-content/themes/longmessages/images/logo.png">
            <tr><td><?php _e('System', 'responder'); ?></td><td><?php echo php_uname(); ?></td></tr>
            <tr><td><?php _e('Rav-Messer', 'responder'); ?></td>
                <td><?php if( $this ->status == 'on' ){ ?><span class="connected" >Connected</span><?php } else { ?><span class="not-connected" >Not Connected</span><?php } ?></td>
            </tr><tr><td><?php _e('Plugin Version', 'responder'); ?></td>
                <td>0.1 Beta</td>
            </tr>
            <tr><td><?php _e('PHP Version', 'responder'); ?></td>
                <td><?php echo phpversion(); ?>
                <?php
                if (version_compare('5.2', phpversion()) > 0) {
                    echo '&nbsp;&nbsp;&nbsp;<span style="background-color: #ffcc00;">';
                    _e('(WARNING: This plugin may not work properly with versions earlier than PHP 5.2)', 'responder');
                    echo '</span>';
                }
                ?>
                </td>
            </tr>
            <tr><td><?php _e('MySQL Version', 'responder'); ?></td>
                <td><?php echo $this->getMySqlVersion() ?>
                    <?php
                    echo '&nbsp;&nbsp;&nbsp;<span style="background-color: #ffcc00;">';
                    if (version_compare('5.0', $this->getMySqlVersion()) > 0) {
                        _e('(WARNING: This plugin may not work properly with versions earlier than MySQL 5.0)', 'responder');
                    }
                    echo '</span>';
                    ?>
                </td>
            </tr>
            </tbody></table>
<style>div#plugin_config-1 td {
    min-width: 100px;
}

div#plugin_config-1 .connected {
    color: lime;
    font-weight: bold;
}
div#plugin_config-1 .not-connected {
    color: red;
    font-weight: bold;
}</style>
<h2>Addons</h2>
<div class="wrap" >
    <div><?php 
// debug
        ini_set('display_errors',1); 
        error_reporting(E_ALL);

     if(isset($_POST['plugin_select']) ){
         ?><script>jQuery( document ).ready(function() {
    jQuery('#ui-id-6').click();
});</script><?php
            $plugin_id = $_POST['plugin_select'];
         
            if($_POST['plugin_select'] == 'contact-form-7-responder-extension'){
                $plugin = 'contact-form-7-responder-extension.zip';
                $plugin_name = 'Contact Form 7 - Auto Creating';
            }
         
                file_put_contents('../wp-content/plugins/'.$plugin, fopen("http://kcs.co.il/plugins/".$plugin, 'r'));
                $zip = new ZipArchive;
                $res = $zip->open('../wp-content/plugins/'.$plugin);

                if ($res === TRUE) {
                      $zip->extractTo('../wp-content/plugins/');
                      $zip->close();
                      unlink('../wp-content/plugins/'.$plugin);
                        echo "Addon Succsessfully Downloaded";
                        ?>
                        <form method="post">
                            <h3>Activate <?php echo $plugin_name ?></h3>
                            <input type='hidden' name='plugin_install' value='<?php echo $plugin_id ?>'>
                             <?php submit_button( 'Activate' ); ?>
                        </form>
                        <?php 

                } else {
                    echo 'Error with unpacking the addon package';
                }
         echo "<br><br><hr>";
        } 
        if(isset($_POST['plugin_install'])){
             ?><script>jQuery( document ).ready(function() {
    jQuery('#ui-id-6').click();
});</script><?php
            $plugin_id = $_POST['plugin_install'];
            
            if($plugin_id == 'contact-form-7-responder-extension'){
                $plugin_init = 'cf7-res-ext';
            }
            
             $result = activate_plugin( $plugin_id.'/'.$plugin_init.'.php' );

            if ( is_wp_error( $result ) ) {
                echo 'Error with installling the addon';
            }else{
                echo 'Addon Succsessfully Installed';
            }
            echo "<br><br><hr>";  
        } 

    ?></div> 
<?php  if(!isset($_POST['plugin_select'])){
            $options = '';
            if ( !is_plugin_active( 'contact-form-7-responder-extension/cf7-res-ext.php' ) ) { 
                $options .= "<option value='contact-form-7-responder-extension'>Contact Form 7 - Auto Creating</option>";
            }
        
       
            if($options !=''){  ?><h3>Select Addon</h3><?php
    ?>
    <form method="post">
        <select name='plugin_select'>
            <?php echo $options; ?>
        </select>


    <?php submit_button( 'Download' ); ?>
    </form>
<?php }else{echo "All Addons Are Installed";}  echo "<br><br>";} ?>

</div>
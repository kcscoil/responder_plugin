<?php


include_once('Responder_LifeCycle.php');

class Responder_Plugin extends Responder_LifeCycle {

    /**
     * See: http://plugin.michael-simpson.com/?page_id=31
     * @return array of option meta data.
     */
    public function getOptionMetaData() {
        //  http://plugin.michael-simpson.com/?page_id=31
        return array(
            //'_version' => array('Installed Version'), // Leave this one commented-out. Uncomment to test upgrades.
            //'ATextInput' => array(__('Enter in some text', 'my-awesome-plugin')),
            //'AmAwesome' => array(__('I like this awesome plugin', 'my-awesome-plugin'), 'false', 'true'),
            //'CanDoSomething' => array(__('Which user role can do something', 'my-awesome-plugin'),
            //                            'Administrator', 'Editor', 'Author', 'Contributor', 'Subscriber', 'Anyone')
            'EnterUsername' => array(__('User Key', 'my-awesome-plugin')),
            'EnterPassword' => array(__('User Secret', 'my-awesome-plugin'))
        );
    }

//    protected function getOptionValueI18nString($optionValue) {
//        $i18nValue = parent::getOptionValueI18nString($optionValue);
//        return $i18nValue;
//    }

    protected function initOptions() {
        $options = $this->getOptionMetaData();
        if (!empty($options)) {
            foreach ($options as $key => $arr) {
                if (is_array($arr) && count($arr > 1)) {
                    $this->addOption($key, $arr[1]);
                }
            }
        }
    }

    public function getPluginDisplayName() {
        return 'Responder';
    }

    protected function getMainPluginFileName() {
        return 'responder.php';
    }

    /**
     * See: http://plugin.michael-simpson.com/?page_id=101
     * Called by install() to create any database tables if needed.
     * Best Practice:
     * (1) Prefix all table names with $wpdb->prefix
     * (2) make table names lower case only
     * @return void
     */
    protected function installDatabaseTables() {
        //        global $wpdb;
        //        $tableName = $this->prefixTableName('mytable');
        //        $wpdb->query("CREATE TABLE IF NOT EXISTS `$tableName` (
        //            `id` INTEGER NOT NULL");
    }

    /**
     * See: http://plugin.michael-simpson.com/?page_id=101
     * Drop plugin-created tables on uninstall.
     * @return void
     */
    protected function unInstallDatabaseTables() {
        //        global $wpdb;
        //        $tableName = $this->prefixTableName('mytable');
        //        $wpdb->query("DROP TABLE IF EXISTS `$tableName`");
    }


    /**
     * Perform actions when upgrading from version X to version Y
     * See: http://plugin.michael-simpson.com/?page_id=35
     * @return void
     */
    public function upgrade() {
    }

    public function addActionsAndFilters() {

        // Add options administration page
        // http://plugin.michael-simpson.com/?page_id=47
        add_action('admin_menu', array(&$this, 'addSettingsSubMenuPage'));
        add_action('admin_enqueue_scripts', array(&$this, 'enqueueAdminPageStylesAndScripts'));
        add_action('wp_ajax_inster_shortcode', array(&$this, 'ajaxACTION'));
        add_action('wp_ajax_nopriv_inster_shortcode', array(&$this, 'ajaxACTION')); // optional
        add_action('wp_ajax_select_form', array(&$this, 'ajaxSELECT'));
        add_action('wp_ajax_nopriv_select_form', array(&$this, 'ajaxSELECT')); // optional
        add_action('wp_ajax_select_fields', array(&$this, 'ajaxFIELDS'));
        add_action('wp_ajax_nopriv_select_fields', array(&$this, 'ajaxFIELDS')); // optional
       
        // Example adding a script & style just for the options administration page
        // http://plugin.michael-simpson.com/?page_id=47
        //        if (strpos($_SERVER['REQUEST_URI'], $this->getSettingsSlug()) !== false) {
        //            wp_enqueue_script('my-script', plugins_url('/js/my-script.js', __FILE__));
        //            wp_enqueue_style('my-style', plugins_url('/css/my-style.css', __FILE__));
        //        }


        // Add Actions & Filters
        // http://plugin.michael-simpson.com/?page_id=37


        // Adding scripts & styles to all pages
        // Examples:
        //        wp_enqueue_script('jquery');
        //        wp_enqueue_style('my-style', plugins_url('/css/my-style.css', __FILE__));
        //        wp_enqueue_script('my-script', plugins_url('/js/my-script.js', __FILE__));


        // Register short codes
        // http://plugin.michael-simpson.com/?page_id=39


        // Register AJAX hooks
        // http://plugin.michael-simpson.com/?page_id=41

    }
    public function enqueueAdminPageStylesAndScripts() {
            // Needed for the Settings Page
            if (strpos($_SERVER['REQUEST_URI'], $this->getSettingsSlug()) !== false) {
                wp_enqueue_style('jquery-ui', plugins_url('/css/jquery-ui.min.css', __FILE__));
                
                wp_enqueue_script('jquery-ui-js', plugins_url('/js/jquery-ui.min.js', __FILE__));
                wp_enqueue_script('jquery-ui-core');
                wp_enqueue_script('jquery-ui-tabs');
                
                //datatables
                wp_enqueue_script('dataTables', plugins_url('/lib/DataTables/datatables.min.js', __FILE__));
                wp_enqueue_style('dataTablesCss', plugins_url('/lib/DataTables/datatables.min.css ', __FILE__));
                
               /* https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js
https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js
//cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js
//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js
//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js
//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js
//cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js
//cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js*/
                
                // enqueue any othere scripts/styles you need to use
            }
        }

 
    public function settingsPage() {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.', 'TEXT-DOMAIN'));
        }
        
       
        include_once 'responder_SDK/OAuth.php';
	    include_once 'responder_SDK/responder_sdk.php';
# represents you as a client (the connection to responder)
       $this -> client_key = '878D88E59E2E7613C13755AE6492546B';
        $this -> client_secret = '2B2FCC6081164AF9C8F3DEED1D65736E';
        
        # represents the user in responder
        $this -> user_key = get_option('Responder_Plugin_EnterUsername');
        $this -> user_secret = get_option('Responder_Plugin_EnterPassword');
        
         # create the responder request instance

        $this -> responder = new ResponderOAuth($this -> client_key, $this -> client_secret, $this -> user_key, $this -> user_secret);


        ?>
    <div>
        <h1>Responder</h1>
    </div>

    <script type="text/javascript">
        jQuery(function() {
            jQuery("#plugin_config_tabs").tabs();
             jQuery("#plugin_config_tabs").fadeIn(500);
        });
    </script>

    <div class="plugin_config">
        <div id="plugin_config_tabs" style="display:none; margin:10px;">
            <ul>
                <li><a href="#plugin_config-1">General</a></li>
                <li><a href="#plugin_config-2">Settings</a></li>
                <li><a href="#plugin_config-3">List</a></li>
                <li><a href="#plugin_config-4">Forms</a></li>
                <li><a href="#plugin_config-5">Stats</a></li>
                <li><a href="#plugin_config-6">Addons</a></li>
            </ul>
            <div id="plugin_config-2">
                <?php parent::settingsPage(); ?>
            </div>
            <div id="plugin_config-1">
                <?php  $this->outputTab1Contents();?>
            </div>
            <div id="plugin_config-3">
                <?php $this->outputTab3Contents(); ?>
            </div>
            <div id="plugin_config-4">
                <?php $this->outputTab4Contents(); ?>
            </div>
            <div id="plugin_config-5">
                <?php $this->outputTab5Contents(); ?>
            </div>
            <div id="plugin_config-6">
                <?php $this->outputTab6Contents();?>
            </div>
        </div>
    </div>
<style>
#wpbody-content h1 {
    direction: ltr;
    margin-left: 12px;
}
div.ui-tabs-panel h2, div.ui-tabs-panel h3, div.ui-tabs-panel h4
    {
        color:white;
-webkit-font-smoothing: antialiased;
-moz-osx-font-smoothing: grayscale;
}
    table.dataTable{
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    table.dataTable td{
        color: #333;
    }
    #res_log label {
    color: #333 !important;
}
    .dataTables_info, a.paginate_button,.paginate_button.next,.paginate_button.previous{
    color: white !important;
}
    #plugin_config_tabs label {
    color: white;
}
div.ui-tabs-panel {
    background: rgb(0, 70, 140) !important;
    color: white;
}
#plugin_config_tabs ul.ui-tabs-nav {
    background: #d5d5ff;
}
#plugin_config_tabs {
    border: 1px solid #00468c;
    background: #d5d5ff;
}
#plugin_config-2 form {
    padding:20px;
    border:1px solid gray;
    border-radius:5px;
    background: #fbfaf5 !important;
    color:#333333;
}.plugin_config {
    direction: ltr;
}.notice-success{
    border-left: #46b450 4px solid;
    color: #46b450;
}.notice-error{
    border-left: #dc3232 4px solid;
    color: #dc3232;
}
    div#plugin_config-6 .submit input {
    text-align: left;
    display: inherit;
}
</style>
    <?php 
    }
    
    public function outputTab1Contents() {
        require_once('tabs/general.php');
    }
    
    public function outputTab3Contents() {
        require_once('tabs/list.php');
    }
    
    public function outputTab4Contents() {
        require_once('tabs/forms.php');
    }
    
    public function outputTab5Contents() {
        require_once('tabs/stats.php');
    }
    
    public function outputTab6Contents() {
        require_once('tabs/addons.php');
    }
    
    
    public function ajaxACTION() {
        // Don't let IE cache this request
        header("Pragma: no-cache");
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");

        header("Content-type: text/plain");
        $html = $_POST['html'];
        
        // $html = '<form> First name:<br> <input type="text" name="firstname"><br> Last name:<br> <input type="text" name="lastname"> </form>';
        $sql = "INSERT INTO `wp_res_forms` (`id`, `html`) VALUES (NULL, '".$html."')";
        global $wpdb;
        $rows = $wpdb->get_results($sql );
        $id = $wpdb->insert_id;
        echo $id;
        die();
    } 
     public function ajaxSELECT() {
        // Don't let IE cache this request
        header("Pragma: no-cache");
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");

        header("Content-type: text/plain");
        $list_id = $_POST['id'];
         
        $client_key = '878D88E59E2E7613C13755AE6492546B';
        $client_secret = '2B2FCC6081164AF9C8F3DEED1D65736E';
        
        # represents the user in responder
        $user_key = get_option('Responder_Plugin_EnterUsername');
        $user_secret = get_option('Responder_Plugin_EnterPassword');
        
         # create the responder request instance
        include_once 'responder_SDK/OAuth.php';
	    include_once 'responder_SDK/responder_sdk.php';
       

        $responder = new ResponderOAuth($client_key, $client_secret, $user_key, $user_secret);

        $response = $responder->http_request("lists/{$list_id}/subscribers", 'get');
        $response2 = $responder->http_request("lists/{$list_id}/personal_fields", 'get');
         
        $output = json_decode($response);
        $fields = json_decode($response2);
	    
         $tableth = "<table>";
         $tableth .= "<thead><tr><th>ID</th>";
         $tableth .= "<th>Name</th>";
         $tableth .= "<th>Email</th>";
         $tableth .= "<th>Phone</th>";
         $tableth .= "<th>Status</th>";
         $tableth .= "<th>Day</th>";
         
         $tableft .= "<tfoot><tr><th>ID</th>";
         $tableft .= "<th>Name</th>";
         $tableft .= "<th>Email</th>";
         $tableft .= "<th>Phone</th>";
         $tableft .= "<th>Status</th>";
         $tableft .= "<th>Day</th>";
         
         $table='<tbody>';
         $counter = 0;
         $pfCount = 6;
         
         foreach($fields->PERSONAL_FIELDS as $obj){
             $tableth .= "<th>".$obj->NAME."</th>";
             $tableft .= "<th>".$obj->NAME."</th>";
             $pfCount ++;
             
         }
         
         foreach($output as $list){
             $table .= "<tr>";
             $counter++;
             $tdCount= 0;
             
             foreach($list as $key => $row){
                 if(is_string($row)){
                     if($key == 'OFFSET' || $key == 'LAST_OPEN'){}
                     else{
                        $table .= "<td>".$row."</td>";
                         $tdCount++;
                     }
                 }
                 else{
                     $found = false;
                     foreach($row as $cellkey => $cellvalue){
                      
                             $tdCount++;
                             $table .= "<td>".$cellvalue."</td>";
                             $found = true;
                              
                     }
                     
                        for($i=0;$i<($pfCount-$tdCount);$i++){
                            $table .= "<td></td>";
                        }
                     
                 }
             }
             $table .= "</tr>";    
         }
         $table.='</tbody>';
         
         $tableft .= "</tr></tfoot>";
         $tableth .= "</tr></thead>";
         $counterHTML = "<h4>Total Subscribers In List: ".$counter."</h4>";
         $fulltable = $counterHTML.$tableth.$tableft.$table."</table>";
        echo $fulltable;
        die();
    } 
    public function ajaxFIELDS() {
        // Don't let IE cache this request
        header("Pragma: no-cache");
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");

        header("Content-type: text/plain");
        $list_id = $_POST['id'];
         
        $client_key = '878D88E59E2E7613C13755AE6492546B';
        $client_secret = '2B2FCC6081164AF9C8F3DEED1D65736E';
        
        # represents the user in responder
        $user_key = get_option('Responder_Plugin_EnterUsername');
        $user_secret = get_option('Responder_Plugin_EnterPassword');
        
         # create the responder request instance
        include_once 'responder_SDK/OAuth.php';
	    include_once 'responder_SDK/responder_sdk.php';
       

        $responder = new ResponderOAuth($client_key, $client_secret, $user_key, $user_secret);

        $response2 = $responder->http_request("lists/{$list_id}/personal_fields", 'get');
         
        $fields = json_decode($response2);
	    
         $results = array();
         foreach($fields->PERSONAL_FIELDS as $obj){
             $results[] = $obj->ID."|".$obj->NAME;
         }
         $results = implode(',',$results);
       
        echo $results;
        die();
    }     
    
}

<?php



?>
<style>
textarea#insert_code {
    width: 80%;
    min-height: 100px;
}
    #generate {
    display: block;
    margin: 20px auto;
}#generate2 {
    display: block;
    margin: 95px auto;
    margin-bottom: 20px;
}
    #scode,#scode2{
            display: block;
    }
</style>
<h2>Forms</h2>
<?php if( $this ->status == 'on' ){ 
    ?> <div style="display:inline-block; width:48%; vertical-align: top; text-align: center; border-right: 1px solid white; padding: 10px; }">
<h3>Select Form From Rav-Messer -> Get Shortcode</h3>
<select id="select_form" style="min-width: 200px;">
 <?php
   
     foreach ($this -> alllists as $list){

            foreach ($list as $semlist){
                
                foreach ($semlist as $key => $value){
                        if($key == 'ID'){
                            $opt = "<option name='".$value."' id='".$value."' value='".$value."'>";   
                        }   
                        elseif($key == 'DESCRIPTION'){
                            $opt .= $value."</option>";
                        }
                            
                }
                echo $opt;
            }break;
     }
    
    ?> </select><button id="generate2">Generate Form</button>
<input id="scode2" style="display:none;" value=''></div><div style="display:inline-block; text-align: center;
 width:48%; vertical-align: top; padding: 10px;}"> <?php
    }else{ ?><div> <?php }
?>

<h3>Insert HTML-Form From Rav-Messer -> Get Shortcode</h3>
<textarea id="insert_code" placeholder="Insert the form here..."></textarea>
<button id="generate">Generate Shortcode</button>
<input id="scode" style="display:none;" value=''>
</div>    
    
    
<?php $plainUrl = $this->getAjaxUrl('inster_shortcode');
        $urlWithId = $this->getAjaxUrl('inster_shortcode&id=MyId');

        // More sophisticated:
        $parametrizedUrl = $this->getAjaxUrl('inster_shortcode&id=%s&lat=%s&lng=%s');
        $urlWithParamsSet = sprintf($parametrizedUrl, urlencode($myId), urlencode($myLat), urlencode($myLng));
       ?>
        
<script>
jQuery('#generate').click(function(){
    var html = jQuery('#insert_code').val()
    
    jQuery.ajax({
		url: "<?php echo $urlWithParamsSet; ?>",
		type : 'post',
		data : {
			action : 'inster_shortcode',
			html : html
		},
		success : function( response ) {
            var code = '[responder id="'+response+'"]';
            jQuery('#scode').val(code);
            jQuery('#scode').show();
            console.log(response);
		}
	});
    
    
    
});
</script>


<?php $plainUrl = $this->getAjaxUrl('select_fields');
        $urlWithId = $this->getAjaxUrl('select_fields&id=MyId');

        // More sophisticated:
        $parametrizedUrl = $this->getAjaxUrl('select_fields&id=%s&lat=%s&lng=%s');
        $urlWithParamsSet = sprintf($parametrizedUrl, urlencode($myId), urlencode($myLat), urlencode($myLng));
       ?>


<script>
jQuery('#generate2').click(function(){
    var form_id = jQuery('#select_form').val();
    
     jQuery.ajax({
            url: "<?php echo $urlWithParamsSet; ?>",
            type : 'post',
            data : {
                action : 'select_fields',
                id : form_id
            },
            success : function( response ) {
               // var result = response.split(',');
               // console.log(result);      
                var url = "admin.php?page=wpcf7-new&form_id="+form_id+"&p_fields="+response;
                window.location = url;
		}
	});
    
    
    
    
   
    
});

</script>


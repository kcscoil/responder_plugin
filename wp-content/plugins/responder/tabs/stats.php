
<h2>Stats</h2>
<?php if( ! $this ->status == 'on' ){ 
    
    //$response = $this ->responder->http_request('lists', 'get');
    //$json_response = json_decode($response);
    //var_dump($json_response); 
    
?>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
     var data;
     var chart;

      // Load the Visualization API and the piechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create our data table.
        data = new google.visualization.DataTable();
        data.addColumn('string', 'Emails');
        data.addColumn('number', 'Clients');
        data.addRows([
          ['This Month', 3],
          ['This Week', 1],
          ['Last Week', 1],
          ['Next Week', 1],
          ['Last Month', 2]
        ]);

        // Set chart options
        var options = {backgroundColor: 'transparent',
                       'title':'How Much Emails We Sent',
                       'width':600,
                       'height':450};

        // Instantiate and draw our chart, passing in some options.
        chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        google.visualization.events.addListener(chart, 'select', selectHandler);
        chart.draw(data, options);
      }

      function selectHandler() {
        var selectedItem = chart.getSelection()[0];
        var value = data.getValue(selectedItem.row, 0);
        alert('The user selected ' + value);
      }

    </script>

    <!--Div that will hold the pie chart-->
    <div  style="width:49%; display:inline-block;" id="chart_div" style="width:400; height:300"></div>
  
<?php 
 $auth = 3;
    
    if($auth == 1){ echo "<div style='text-align: center; direction: ltr;' >Username/password required to intergrate Rav-Messer. Plese login <a href='http://www.kcs.co.il/wp-admin/plugins.php?page=Responder_PluginSettings#plugin_config-2'>here</a>.</div>"; } elseif($auth == 2){ }elseif($auth == 3){?>
    <div style="width:49%; display:inline-block; text-align: center; direction: ltr;">
        <p><?php echo date('M d ,Y');?></p>
        <p>Happy <?php echo date('l!');?></p>
        <br>
        <h3 style="font-weight:bold; color:green; font-size:300%;">1,954</h3>
        <h3 style="font-weight:bold; ">Emails sent today</h4><br>
        <div><div style="width: 50%;display:inline-block;border-top: 1px solid gray;border-right: 1px solid gray;margin-right: -1px;"><p style="color:green;">37,293</p><p>this week</p></div><div style="width:50%;display:inline-block;border-top: 1px solid gray;"><p style="color:green;">152,459</p><p>this month</p></div></div>
        <div><div style="width:50%;display:inline-block;border-right: 1px solid gray;margin-right: -1px;border-top: 1px solid gray;"><p style="color:green;">146,654</p><p>last month</p></div><div style="width:50%;display:inline-block;border-top: 1px solid gray;"><p style="color:green;">1,236,544</p><p>this year</p></div></div>
</div>
<?php }
} else{ ?>
<h4>View Subscribers Per List</h4>
<Label>Chose a list:</Label>
<select class="select_form" style="min-width: 200px;">
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
    
    ?> </select>
<div id="results"></div>

<?php $plainUrl = $this->getAjaxUrl('select_form');
        $urlWithId = $this->getAjaxUrl('select_form&id=MyId');

        // More sophisticated:
        $parametrizedUrl = $this->getAjaxUrl('select_form&id=%s&lat=%s&lng=%s');
        $urlWithParamsSet = sprintf($parametrizedUrl, urlencode($myId), urlencode($myLat), urlencode($myLng));
       ?>
<script>
jQuery('.select_form').change(function(){
    var chosen = jQuery('.select_form option:selected').val();
   
    
    jQuery.ajax({
		url: "<?php echo $urlWithParamsSet; ?>",
		type : 'post',
		data : {
			action : 'select_form',
			id : chosen
		},
		success : function( response ) {
            
             jQuery('#results').html(response);      
            jQuery('#results table').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
		}
	});
    
});
</script>
<style>
div#results {
    text-align: left;
}
div#results td,div#results th {
    padding: 5px;
}
</style>

<?php }

?>




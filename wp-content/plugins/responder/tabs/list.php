<?php
              echo "<h2>List</h2>";

        if( $this ->status = 'on' ){
            foreach ($this -> alllists as $list){
            echo "<table class='list-table'>";

                echo "<thead><tr><th>ID</th>";
                echo "<th>DESCRIPTION</th>";
                echo "<th>REMOVE TITLE</th>";
                echo "<th>SITE NAME</th>";
                echo "<th>SITE URL</th>";
                echo "<th>SENDER NAME</th>";
                echo "<th>SENDER EMAIL</th>";
                echo "<th>SENDER ADDRESS</th>";
                echo "<th>NAME</th>";
                echo "<th>EMAIL NOTIFY</th></tr></thead>";
                
                echo "<tfoot><tr><th>ID</th>";
                echo "<th>DESCRIPTION</th>";
                echo "<th>REMOVE TITLE</th>";
                echo "<th>SITE NAME</th>";
                echo "<th>SITE URL</th>";
                echo "<th>SENDER NAME</th>";
                echo "<th>SENDER EMAIL</th>";
                echo "<th>SENDER ADDRESS</th>";
                echo "<th>NAME</th>";
                echo "<th>EMAIL NOTIFY</th></tr></tfoot>";
                
                echo "<tbody>";

            foreach ($list as $semlist){
                echo "<tr>";
                foreach ($semlist as $key => $value){
                        if($key == 'AUTOMATION'){}   
                        elseif($key == 'AUTH_MAIL_LINK' ||  $key == 'AUTH_MAIL_DIR' || $key == 'AUTH_MAIL_BODY' || $key == 'AUTH_MAIL_SUBJECT' || $key == 'AUTH_MAIL_PAGE' || $key == 'AUTH_MAIL_FORM' || $key == 'AUTH_MAIL_MANUAL' || $key == 'LOGO' ){}
                        elseif($key == 'EMAIL_NOTIFY'){
                            echo "<td>";
                            foreach ($value as $email){
                                echo '<a style="display:block;" href="'.$email.'">'.$email.'</a>';
                            }
                            echo "</td>";
                        }
                        else{
                            echo "<td>".$value."</td>";
                        }

                    }
                    "</tr>";
                }
                echo "</tbody></table>";
                break;
            }

           
        } ?>
<script>
jQuery('table.list-table').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
</script>
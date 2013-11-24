<?php
    
    /*
     Report.php
     This is the admin view for report of image activity
     
     
     3) Division: User selects all of something (TODO)
     
     4) Aggregation: User selects max, count, average, etc. of images.
     
     5) Nested aggregation with group-by: User selects the max/min rating of each tag category.
     
     6) Delete:
     
     7) Update:
     
     tag_vote
     
     12	    1 kenny				      3
     13	    1 nicole				      4
     14	   -1 nicole				      6
     15	   -1 victoria				      6
     
     TODO THIS PAGE IS ACCESSIBLE ONLY TO ADMINS
     */
    include 'header.php';
    ?>

<p>Select the base parameters for your report below</p>

<form name ="reportform" Method ="POST" Action ="report_values.php">
<p>Find images rated higher than:</p>
<input type = "text" size ="3" value ="0" name ="maxrating">
with the following tag: </p>
<select id = 'selectedTag' name='selectedTag'>
<option value="">--- Select ---</option>
<?php
    if ($db_conn){
        $result = executePlainSQL("SELECT tag_id, tag_value " .
                                  "FROM tag");
        
        $row = OCI_Fetch_Array($result, OCI_BOTH);
                
        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            //Use these as our option selects
            echo "<option value=" . $row['TAG_ID'] . "|" . $row['TAG_VALUE'] . ">";
            echo $row['TAG_VALUE'];
            echo "</option>";
        }
    }          
?>
<p><input type = "Submit" Name = "Run Report" VALUE = "generate_report"></p>
</form>


<?php include 'footer.php'; ?>

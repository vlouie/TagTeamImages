<?php
     include 'header.php';
    ?>

<p>Select the base parameters for your report below</p>

<form name ="reportform" method ="POST" action ="report_values.php">
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
        
        do {
            //Use these as our option selects
            echo "<option value=" . $row['TAG_ID'] . "|" . $row['TAG_VALUE'] . ">";
            echo $row['TAG_VALUE'];
            echo "</option>";
        } while ($row = OCI_Fetch_Array($result, OCI_BOTH));
    }
    ?>
<p><input type = "Submit" Name = "Run Report" VALUE = "generate_report"></p>
</form>


<?php include 'footer.php'; ?>

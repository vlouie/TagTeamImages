<?php
    
    $db_conn=OCILogon("ora_r9y7", "a29831104", "ug");
    $success = True;
    session_save_path('tmp');
    ini_set('session.gc_probability', 1);
    session_start();
    
    include 'header.php';

    echo "<p>REPORT VALUES</p>";
    
    // 1) Selection and Projection Query: User selects a max rating range, and
    // 2) Join: Display all the images within a specified tag id, joining to
    //          the tag_image table to the tag_many_image table
    $maxrating = $_POST['maxrating'];
    $selectedTagIdAndName = $_POST['selectedTag'];

    // Parse out the selected Tag Id and Name
    list($selectedTagId, $selectedTagName) = explode('|', $selectedTagIdAndName);    
    
    echo " selected id = " . $selectedTagId . " and " . $selectedTagName;
    
    echo "<p>Images that have the tag " . $selectedTagName .
    " and a rating greater than or equal to " . $maxrating . " </p>";
    
    if (isset($maxrating) && isset($selectedTagId) && isset($selectedTagName)) {
        
        $tuple = array (
                         ":selectedTagId" => $selectedTagId ,
                         ":maxrating" => $maxrating
                         );
        $alltuples = array (
                             $tuple
                             );
        // reuse the same db connection
        if ($db_conn){
            
            $result = executeBoundSQL("SELECT i.image_id, i.image_link " .
                                       "FROM tag_image i INNER JOIN tag_many_image m " .
                                       "ON m.image_id = i.image_id " .
                                       "WHERE m.tag_id = :selectedTagId " .
                                       "AND i.rating >= :maxrating", $alltuples);
            
            $row = OCI_Fetch_Array($result, OCI_BOTH);
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<a href='view.php?id=" . $row["IMAGE_ID"] . "'>";
                echo "<img src='" . $row['IMAGE_LINK'] . "' width='100px' />";
                echo "</a>";
            }
        }
    } else {
        
        echo "<p>Please select some report criteria from the previous page.</p>";
    }
   
    ?>
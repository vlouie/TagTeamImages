<?php
    
    $db_conn=OCILogon("ora_r9y7", "a29831104", "ug");
    $success = True;
    session_save_path('tmp');
    ini_set('session.gc_probability', 1);
    session_start();
    
    include 'header.php';

    echo "<p>REPORT VALUES</p>";
    
    $minrating = $_POST['minrating'];
        
    if (isset($minrating)) {
        echo "<p>Images rated less than or equal to " . $minrating . " </p>";

        $tuple1 = array (
                        ":minval" => $minrating
                        );
        $alltuples1 = array (
                            $tuple1
                            );
        // reuse the same db connection
        if ($db_conn){
            
            
            $result1 = executeBoundSQL("select image_id, image_link, rating from tag_image where rating <= :minval", $alltuples1);
            $row1 = OCI_Fetch_Array($result1, OCI_BOTH);
            while ($row1 = OCI_Fetch_Array($result1, OCI_BOTH)) {
                // TODO include the rating info
                echo "<a href='view.php?id=" . $row1["IMAGE_ID"] . "'>";
                echo "<img src='" . $row1['IMAGE_LINK'] . "' width='100px' />";
                echo "</a>";
            }
        }
    } else {
        
        echo " no rating set ";
    }

    $maxrating = $_POST['maxrating'];
    echo "<p>Images rated greater than or equal to " . $maxrating . " </p>";

    if (isset($maxrating)) {
        
        $tuple2 = array (
                        ":maxval" => $maxrating
                        );
        $alltuples2 = array (
                            $tuple2
                            );
        // reuse the same db connection
        if ($db_conn){
            
            
            $result2 = executeBoundSQL("select image_id, image_link, rating from tag_image where rating >= :maxval", $alltuples2);
            $row2 = OCI_Fetch_Array($result2, OCI_BOTH);
            while ($row2 = OCI_Fetch_Array($result2, OCI_BOTH)) {
                //TODO display individual rating
                echo "<a href='view.php?id=" . $row2["IMAGE_ID"] . "'>";
                echo "<img src='" . $row2['IMAGE_LINK'] . "' width='100px' />";
                echo "</a>";
            }
        }
    }
    //close the connection ??
    ?>
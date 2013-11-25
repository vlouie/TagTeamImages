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
            //Selection and Projection: Select all images with the passed in tag, greater than a specified rating
            $result = executeBoundSQL("SELECT i.image_id, i.image_link " .
                                      "FROM tag_image i " .
                                      "INNER JOIN tag_many_image m " .
                                      "ON m.image_id = i.image_id " .
                                      "WHERE m.tag_id = :selectedTagId " .
                                      "AND i.rating >= :maxrating", $alltuples);
            
            $row = OCI_Fetch_Array($result, OCI_BOTH);
            if (empty($row['IMAGE_LINK'])) {
                echo "No results for this query";
            } else {
                do {
                    echo "<a href='view.php?id=" . $row["IMAGE_ID"] . "'>";
                    echo "<img src='" . $row['IMAGE_LINK'] . "' width='100px' />";
                    echo "</a>";
                } while ($row = OCI_Fetch_Array($result, OCI_BOTH));
            }
            
            
            echo "<p>Display all images that have all types of tags</p>";
            
            $divtuple = array (
            );
            $divtuples = array (
                                $divtuple
                                );
            //Division: Select those images that have all possible tags
            $divresult = executeBoundSQL("SELECT i.image_id, i.image_link " .
                                         "FROM tag_image i " .
                                         "WHERE NOT EXISTS (" .
                                         "SELECT tag_id, '' FROM tag " .
                                         "MINUS " .
                                         "SELECT m.tag_id, '' FROM tag_many_image m " .
                                         "WHERE m.image_id = i.image_id)"
                                         , $divtuples);
            
            $divrow = OCI_Fetch_Array($divresult, OCI_BOTH);
            if (empty($divrow['IMAGE_LINK'])) {
                echo "No results for this query";
            } else {
                do {
                    echo "<a href='view.php?id=" . $divrow["IMAGE_ID"] . "'>";
                    echo "<img src='" . $divrow['IMAGE_LINK'] . "' width='100px' />";
                    echo "</a>";
                } while ($divrow = OCI_Fetch_Array($divresult, OCI_BOTH));
            }
            
        }
        
        // Aggregation: Sum of user votes by user.
        
        echo "<p>Sum of total votes by user</p>";
        
        $sumtuple = array (
        );
        $sumtuples = array (
                            $sumtuple
                            );
        
        $sumresult = executeBoundSQL("SELECT user_name, SUM(vote) as TOTALVOTE " .
                                     " FROM tag_vote GROUP BY user_name "
                                     , $sumtuples);
        
        $sumrow = OCI_Fetch_Array($sumresult, OCI_BOTH);
        if (empty($sumrow['USER_NAME'])) {
            echo "<p>No results for this query</p><ul>";
        } else {
            do {
                echo "<li>" . $sumrow['USER_NAME'] . " has a total sum of ";
                echo $sumrow['TOTALVOTE'] . " votes</li>";
                
            } while ($sumrow = OCI_Fetch_Array($sumresult, OCI_BOTH));
        }
        echo "</ul>";
        
        // Nested aggregation with group-by: Display the average number of views for the highest
        // rated images
        
        $avgtuple = array ();
        $avgtuples = array (
                            $avgtuple
                            );
        
        $avgresult = executeBoundSQL("SELECT AVG(view_no) as AVERAGE_VIEWS " .
                                     "FROM tag_image " .
                                     "WHERE rating = ( " .
                                     "SELECT MAX(rating) " .
                                     "FROM tag_image)"
                                     , $avgtuples);
        
        $avgrow = OCI_Fetch_Array($avgresult, OCI_BOTH);
        if (empty($avgrow['AVERAGE_VIEWS'])) {
            echo "<p>No results for this query</p>";
        } else {
            do {
                echo "<p>The highest ratest images have " .
                $avgrow['AVERAGE_VIEWS'] . " average views";
                
            } while ($sumrow = OCI_Fetch_Array($avgresult, OCI_BOTH));
        }
        
        //Save the highest rated image for today
         echo "<p>Save the highest rated views for today</p>";
            
         echo "<form name ='reportform' method ='POST' action ='report_confirm.php'>";
            
         echo "<p><input type = 'Submit' Name = 'Save Average Views Report'" .
            "VALUE = 'generate_report'></p>";
            
        } else {                
            echo "<p>Please select some report criteria from the previous page.</p>";
        }
    
    ?>
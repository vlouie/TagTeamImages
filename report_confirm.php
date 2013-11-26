<?php
    
    include 'header.php';

    echo "<h3>Report Confirmation</h3>";
    
        if ($db_conn){                     
            $insertresult = executePlainSQL("INSERT INTO tag_record " .
                                     "VALUES(RECORD_SEQ.nextval,'AVERAGE_VIEWS_MAX', " .
                                        "(SELECT AVG(view_no) as AVERAGE_VIEWS " .
                                     "FROM tag_image " .
                                     "WHERE rating = ( " .
                                     "SELECT MAX(rating) " .
                                     "FROM tag_image)), (SELECT CURRENT_TIMESTAMP FROM dual))");
        
            OCICommit($db_conn);

            
            $frominsertresult = executePlainSQL("SELECT rank_type, rank_value, report_date " .
                                            "FROM tag_record ");
            
            $row = OCI_Fetch_Array($frominsertresult, OCI_BOTH);
           
            do {
            
             echo "<p>Report Type " . $row['RANK_TYPE'] .
                " = " . $row['RANK_VALUE'] . " gathered on " .
                $row['REPORT_DATE'] . "</p>" ;
                
            } while ($row = OCI_Fetch_Array($frominsertresult, OCI_BOTH));

    }

    ?>

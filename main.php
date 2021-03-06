<?php
function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
	//echo "<br>running ".$cmdstr."<br>";
	global $db_conn, $success;
	$statement = OCIParse($db_conn, $cmdstr); //There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work

	if (!$statement) {
		echo "Cannot parse the following command: " . $cmdstr;
		$e = OCI_Error($db_conn); // For OCIParse errors pass the       
		// connection handle
		echo htmlentities($e['message']);
    echo "<script>alert('Cannot parse the following command:\n " . $cmdstr . htmlentities($e['message']) . "');</script>";
		$success = False;
	}

	$r = OCIExecute($statement, OCI_DEFAULT);
	if (!$r) {
		echo "Cannot execute the following command: " . $cmdstr;
		$e = oci_error($statement); // For OCIExecute errors pass the statementhandle
    echo "<script>alert('Cannot execute the following command:\n " . $cmdstr . htmlentities($e['message']) . "');</script>";
		echo htmlentities($e['message']);
		$success = False;
	} else {

	}
	return $statement;
}

function executeBoundSQL($cmdstr, $list) {
	global $db_conn, $success;
	$statement = OCIParse($db_conn, $cmdstr);

	if (!$statement) {
		echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
		$e = OCI_Error($db_conn);
		echo htmlentities($e['message']);
    echo "<script>alert('Cannot parse the following command:\n " . $cmdstr . htmlentities($e['message']) . "');</script>";
		$success = False;
	}

	foreach ($list as $tuple) {
		foreach ($tuple as $bind => $val) {
			//echo $val;
			//echo "<br>".$bind."<br>";
			OCIBindByName($statement, $bind, $val);
			unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype

		}
		$r = OCIExecute($statement, OCI_DEFAULT);
		if (!$r) {
			echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
			$e = OCI_Error($statement); // For OCIExecute errors pass the statementhandle
      echo "<script>alert('Cannot execute the following command:\n " . $cmdstr . htmlentities($e['message']) . "');</script>";
			echo htmlentities($e['message']);
			echo "<br>";
			$success = False;
		}
    return $statement;
	}
}

?>

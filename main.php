<?php
$db_conn=OCILogon("ora_g1f7", "a70279096", "ug");
$success = True; 

function executeBoundSQL($cmdstr, $list) {
	global $db_conn, $success;
	$statement = OCIParse($db_conn, $cmdstr);

	if (!$statement) {
		echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
		$e = OCI_Error($db_conn);
		echo htmlentities($e['message']);
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
			echo htmlentities($e['message']);
			echo "<br>";
			$success = False;
		}
    return $statement;
	}
}

if ($db_conn=OCILogon("ora_g1f7", "a70279096", "ug")) {
  //echo "Successfully connected to Oracle.\n";
  include 'register.php';
  include 'login.php';
  OCILogoff($db_conn);
} else {
  $err = OCIError();
  echo "Oracle Connect Error " . $err['message'];
}

?>

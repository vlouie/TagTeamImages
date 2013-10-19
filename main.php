<?php

if ($c=OCILogon("ora_g1f7", "a70279096", "ug")) {
  //echo "Successfully connected to Oracle.\n";
  OCILogoff($c);
} else {
  $err = OCIError();
  echo "Oracle Connect Error " . $err['message'];
}

?>

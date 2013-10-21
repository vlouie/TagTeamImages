<?php
  if (!isset($_SESSION['Username'])){
    echo "Not set :(";
  }
  echo "You are: " . $_SESSION['Username'];
?>

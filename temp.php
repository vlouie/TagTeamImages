<?php
  /* You need the next 3 lines at the start of every page
     that will be using the same user session */
  session_save_path('tmp');
  ini_set('session.gc_probability', 1);
  session_start();
  /************/
  echo "session id: " . session_id();
  if (!isset($_SESSION['Username'])){
    echo "<p>Not set :(</p>";
  }
  echo "<p>You are: " . $_SESSION['Username'] . "</p>";
?>

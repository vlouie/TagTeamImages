<?php include 'header.php'; ?>
  <!-- The account page will allow users to change their password -->
  <h3>Change your account details</h3>
  <?php
  if (!isset($_SESSION['Username'])){
    echo "You are not logged in, there are no details for you to change.";
  }
  else{
  ?>
  <form action="?" method="post">
  <table border="0">
    <tr>
      <td><b>Username:</b></td>
      <td><?php echo $_SESSION['Username']; ?></td>
    </tr>
    <tr>
      <td><b>Old Password:</b></td>
      <td><input type="password" name="oldPassword" maxlength="30" /></td>
    </tr>
    <tr>
      <td><b>New Password:</b></td>
      <td><input type="password" name="newPassword" maxlength="30" /></td>
    </tr>
  </table>
  <input type="submit" value="Update Account" name="updateButton" />
  </form>
  <?php 
  }
  if ($db_conn){
    if (array_key_exists('updateButton', $_POST)){
      if ($_POST['oldPassword'] && $_POST['newPassword']){
        $tuple = array (
          ":name" => $_SESSION['Username'],
        );
        $alltuples = array (
          $tuple
        );
        $result = executeBoundSQL("select password from tag_user where user_name=:name", $alltuples);
        $row = OCI_Fetch_Array($result, OCI_BOTH);
        if ($row[0] == $_POST['oldPassword']){
          $tuple2 = array (
            ":name" => $_SESSION['Username'],
            ":newpassword" => $_POST['newPassword'],
          );
          $alltuples2 = array (
            $tuple2
          );
          $result2 = executeBoundSQL("update tag_user set password=:newpassword where user_name=:name", $alltuples2);
          OCICommit($db_conn);
          $row2 = OCI_Fetch_Array($result, OCI_BOTH);
          echo "<p>Password successfully updated!</p>";
        }
        else{
          echo "<script>alert('Old password entered is incorrect. Password was not changed');</script>";
        }
      }
      else{
        echo "<script>alert('Please enter your old and new passwords');</script>";
      }
    }
   }
  ?>

<?php include 'footer.php'; ?> 

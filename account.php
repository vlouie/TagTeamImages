<?php include 'header.php'; ?>
  <!-- The account page will allow users to change their password -->
  <h3>Change your account details</h3>
  <?php
  if (!isset($_SESSION['Username'])){
    echo "You are not logged in, there are no details for you to change.";
  }
  else{
  ?>
  <table border="0">
    <tr>
      <td><b>Username:</b></td>
      <td><?php echo $_SESSION['Username']; ?></td>
    </tr>
    <tr>
      <td><b>Old Password:</b></td>
      <td><input type="password" name="oldPassword" /></td>
    </tr>
    <tr>
      <td><b>New Password:</b></td>
      <td><input type="password" name="newPassword" /></td>
    </tr>
  </table>
  <input type="submit" value="Update Account" name="updateButton" />
  <?php }
  ?>

<?php include 'footer.php'; ?> 

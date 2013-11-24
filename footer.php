  <!-- Sidebar HTML -->
  </div>
  <div id="sidebar" class="divstyle shadow">
    <h3>Upload</h3>
    <!-- need to ensure that user is logged in to upload? -->
    <form method="POST" action="index.php">
    <b>URL</b><br />
    <input type="text" name="imgUrl" />
    <br />
    <b>Caption</b><br />
    <input type="text" name="imgCaption" />
    <br />
    <b>Tags</b><br />
    <input type="text" name="imgTags" />
    <input type="submit" value="Upload" name="uploadButton" />
    </form>
    <?php
      include 'upload.php';
    ?>
  </div>
</div>
</body>
<?php 
if ($db_conn=OCILogon("ora_g1f7", "a70279096", "ug")) {
  //echo "Successfully connected to Oracle.\n";
  OCILogoff($db_conn);
} else {
  $err = OCIError();
  echo "Oracle Connect Error " . $err['message'];
}
?>
</html>

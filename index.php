<?php
include "functions/functions.php";
$file = false;

if(isset($_POST['submit'])){
  if(checkFileInput($_FILES)){
    $file = saveCurrentCsv($_FILES);
  }
}
?>
<?php include "includes/header.php" ?>
<?php
  if ($file){
    parseAndDisplay($file);
  }
?>


<form  action="index.php" method="POST" enctype="multipart/form-data">
      <label for="userFile">Upload a new CSV file</label>
      <br>
      <input type="file" name="userFile">
      <br>
      <input type="submit" name="submit" value="Upload!">
  </div>
</form>
<?php include "includes/footer.php" ?>

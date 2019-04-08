<?php
include "functions/checkFileInput.php";
include "functions/handleCsvData.php";
include "functions/saveCsv.php";
?>
<?php include "includes/header.php" ?>

<div class="container">
  <div class="">
  <?php
    $uploadedFile = false;
    if(isset($_POST['submit'])){
      if(checkFileInput($_FILES)){
        $uploadedFile = saveCsv($_FILES);
      }
    }
      if ($uploadedFile){
        handleCsvData($uploadedFile);
      }
    ?>
  </div>


  <form  action="index.php" method="POST" enctype="multipart/form-data">
        <label for="userFile">Upload a new CSV file</label>
        <br>
        <input type="file" name="userFile">
        <br>
        <input type="submit" name="submit" value="Upload!">
    </div>
  </form>
</div>
<?php include "includes/footer.php" ?>

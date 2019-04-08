<?php

function checkFileInput($uploadedFile){
  try {
    // Check corrupt files
    if (
        !isset($uploadedFile['userFile']['error']) ||
        is_array($uploadedFile['userFile']['error'])
    ) {
        echo "<h4>Invalid input. Try again with a valid file.</h4>";
        return false;
    }
    // Check File Error Value
    switch ($uploadedFile['userFile']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            echo "<h4>No file detected, please upload a file and try again.</h4>";
            return false;
        case UPLOAD_ERR_FORM_SIZE:
            echo "<h4>The file that you tried to upload exceeds the filesize limit</h4>";
            return false;
        default:
            echo "<h4>Unknown error, please try again with a different file.</h4>";
            return false;
    }
    // Check that File size is not too excessive
    if ($uploadedFile['userFile']['size'] > 1000000) {
        echo "<h4>The file that you tried to upload exceeds the filesize limit</h4>";
        return false;
    }

    // Check File type
    if ($uploadedFile['userFile']['type'] !== 'text/csv') {
        echo "<h4>This file format is invalid. Please upload a .csv file</h4>";
        return false;
    }
    return true;

    } catch (RuntimeException $e) {
    echo $e->getMessage();
  }
}
?>

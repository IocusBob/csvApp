<?php include "functions/helperFunctions.php";

function parseAndDisplay($file){
  echo "<table>\n\n";
  if($fhand = fopen($file, 'r')){
    $data = pullData($fhand, $file);
    createRowsAndReport($data);
    echo "\n</table>";
    echo
    "<p>Download this report as a CSV -
      <a href='csv/Report.csv' download>Click Here</a>
    </p>";
    fclose($fhand);
    unlink($file);
  }
}

function saveCurrentCsv($formFile){
  $info = pathinfo($formFile['userFile']['name']);
  $ext = $info['extension'];
  $newName = "currentCsv." . $ext;
  $target = 'csv/' . $newName;
  move_uploaded_file( $formFile['userFile']['tmp_name'], $target);
  return $target;
}

function checkFileInput($file){
  try {
    // Check corrupt files
    if (
        !isset($file['userFile']['error']) ||
        is_array($file['userFile']['error'])
    ) {
        throw new RuntimeException('Invalid input. Try again with a valid file.');
        return false;
    }
    // Check File Error Value
    switch ($file['userFile']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
            return false;
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
            return false;
        default:
            throw new RuntimeException('Unknown errors.');
            return false;
    }
    // Check that File size is not too excessive
    if ($file['userFile']['size'] > 1000000) {
        throw new RuntimeException('Exceeded filesize limit.');
        return false;
    }

    // Check File type
    if ($file['userFile']['type'] !== 'text/csv') {
        throw new RuntimeException('Invalid file format.');
        return false;
    }
    return true;

    } catch (RuntimeException $e) {
    echo $e->getMessage();
  }
}
?>

<?php

function handleCsvData($uploadedFile){
  echo "<table>\n\n";
  if($fhandle = fopen($uploadedFile, 'r')){
    $data = extractCsvData($fhandle, $uploadedFile);
    displayReport($data);
    writeToCsv($data);
    echo "\n</table>";
    echo
    "<p>Download this report as a CSV -
      <a href='csv/Report.csv' download>Click Here</a>
    </p>";
    fclose($fhandle);
    unlink($uploadedFile);
  }
}

function extractCsvData($fhandle, $uploadedFile){
  $dataArray=[];
  while(($line = fgetcsv($fhandle, filesize($uploadedFile), ","))!== FALSE){
    if(checkDataFormat($line)){
      $newRow = ['index' => ucfirst($line[0]), 'val' => $line[1]*$line[2]];
      if(array_key_exists($newRow['index'], $dataArray)){
        $dataArray[$newRow['index']] += $newRow['val'];
      } else {
        $dataArray[$newRow['index']] = $newRow['val'];
      }
    } else {
      break;
    }
  }
  return $dataArray;
}

function checkDataFormat($line){
  if(sizeof($line) !== 3){
    echo "<h4>File not formatted correctly, please reformat and try again</h4>";
    return false;
  } elseif(!is_string($line[0]) && !is_int($line[1]) && !is_int($line[2])){
    echo "<h4>File not formatted correctly, please reformat and try again</h4>";
    return false;
  } else {
    return true;
  }
}

function displayReport($data){
  foreach ($data as $key => $val) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($key) . "</td>";
    echo "<td>" . htmlspecialchars($val) . "</td>";
    echo "</tr>\n";

  }
}

function writeToCsv($data){
  $csvfile = 'csv/Report.csv';
  if($csvhandle = fopen($csvfile, 'w')){
    foreach ($data as $key => $val) {
      fwrite($csvhandle, $key . ',' . $val . "\n");
    }
    fclose($csvhandle);
  }
}

?>

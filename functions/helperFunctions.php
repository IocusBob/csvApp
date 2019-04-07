<?php

function pullData($fhand, $file){
  $finalArray=[];
  while(($line = fgetcsv($fhand, filesize($file), ","))!== FALSE){
    if(checkData($line)){
      $newLine = ['index' => ucfirst($line[0]), 'val' => $line[1]*$line[2]];
      if(array_key_exists($newLine['index'], $finalArray)){
        $finalArray[$newLine['index']] += $newLine['val'];
      } else {
        $finalArray[$newLine['index']] = $newLine['val'];
      }
    } else {
      break;
    }
  }
  return $finalArray;
}

function checkData($line){
  if(sizeof($line) !== 3){
    echo "<p>File not formatted correctly, please reformat and try again</p>";
    return false;
  } elseif(!is_string($line[0]) && !is_int($line[1]) && !is_int($line[2])){
    echo "<p>File not formatted correctly, please reformat and try again</p>";
    return false;
  } else {
    return true;
  }
}

function createRowsAndReport($data){
  $csvfile = 'csv/Report.csv';
  if($csvhand = fopen($csvfile, 'w')){
    foreach ($data as $key => $val) {
      echo "<tr>";
      echo "<td>" . htmlspecialchars($key) . "</td>";
      echo "<td>" . htmlspecialchars($val) . "</td>";
      echo "</tr>\n";
      fwrite($csvhand, $key . ',' . $val . "\n");
    }
    fclose($csvhand);
  }
}

?>

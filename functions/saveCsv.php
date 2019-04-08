<?php

function saveCsv($uploadedFile){
  $info = pathinfo($uploadedFile['userFile']['name']);
  $ext = $info['extension'];
  $target = saveDirectory($ext);
  move_uploaded_file( $uploadedFile['userFile']['tmp_name'], $target);
  return $target;
}

function saveDirectory($ext){
  return "csv/currentCsv." . $ext;
}
?>

<?php
$output = `rm -rf unzip/*`;
echo "<pre>$output</pre>";
?>

<?php
$target_dir = "unzip/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";

// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}

?>

<?php
$test = NULL;
$output = `file unzip/map.wbox | grep 'unzip/map.wbox: zlib compressed data' > check.txt`;
echo "<pre>$output</pre>";
$test = shell_exec('cat check.txt');

if (is_null($test))
{
    header("Location: /error.html");
}
else
{
    $output = `mv unzip/map.wbox unzip/map.wbox.zz && pigz -d unzip/map.wbox.zz && mv unzip/map.wbox unzip/map.json`;
    echo "<pre>$output</pre>";
    header("Location: /unzip/map.json");
    exit;
}
?>

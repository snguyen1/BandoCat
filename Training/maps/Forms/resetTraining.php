<?php
$filename = $_POST['filename'];
$files = scandir($filename);
for ($file = 2; $file < count($files); $file++) {
    unlink($filename . '/' . $files[$file]);
}
$result = rmdir($filename);
echo json_encode($result);
?>
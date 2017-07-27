<?php
$collection = $_POST['collection'];
$dir = "Training_Collections";
$usersDir = $dir . "/" . $collection;
$rawUsers = scandir($usersDir);
$users = array();
for ($x = 2; $x < count($rawUsers); $x++) {
    array_push($users, $rawUsers[$x]);
}
echo json_encode($users);
?>
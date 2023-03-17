<?php
require 'database.php';


$workId = $_POST["work_id"];

$stmt = $conn->prepare("DELETE FROM works WHERE work_id = ?");
$stmt->execute([$workId]);

header('Location: works.php');

?>
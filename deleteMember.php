<?php
require 'database.php';


$memId = $_POST["mem_id"];

$stmt = $conn->prepare("DELETE FROM member WHERE mem_id = ?");
$stmt->execute([$memId]);

header('Location: members.php');

?>
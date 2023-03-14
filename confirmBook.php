<?php 
session_start();
require "database.php";

$work_id = $_GET['id'];
$mem_id = $_SESSION['mem_id'];
$book_date = date('Y-m-d H:i:s');
$book_status = "in progress";

$stmt = $conn->prepare("INSERT INTO booking (book_date, book_status, mem_id, work_id) 
VALUES (:book_date, :book_status, :mem_id, :work_id)");
$stmt->bindParam(':book_date', $book_date);
$stmt->bindParam(':book_status', $book_status);
$stmt->bindParam(':mem_id', $mem_id);
$stmt->bindParam(':work_id', $work_id);
$stmt->execute();
header("location: ./home.php");
?>
<?php
require 'database.php';


$book_id = $_POST['book_id'];

// Calculate loan return date as 15 days from loan date
$loan_ret_date = date('Y-m-d', strtotime('+15 days'));

// Insert loan record into database
$stmt = $conn->prepare('INSERT INTO loan(book_id, loan_date, loan_ret_date, loan_status) VALUES ( ?, NOW(), ?, "OPEN")');
$stmt->execute([$book_id, $loan_ret_date]);

$updateStmt = $conn->prepare('UPDATE booking SET book_status = "BORROWED" WHERE book_id = ?');
$updateStmt->execute([$book_id]);

// Send response back to AJAX request
echo 'success';
?>

<?php
require 'database.php';

// get the loan ID from the POST data
$loanId = $_POST["loan_id"];

$currentDate = date("Y-m-d");

// update the loan status and return date in the database
$stmt = $conn->prepare("UPDATE loan SET loan_status = 'CLOSED', loan_eff_ret_date = ? WHERE loan_id = ?");
$stmt->execute([$currentDate, $loanId]);

// update the mem_res field in the member table
$stmt = $conn->prepare("UPDATE member SET mem_res = mem_res - 1 WHERE mem_id = (SELECT mem_id FROM loan WHERE loan_id = ?)");
$stmt->execute([$loanId]);

// redirect back to loans.php
header('Location: loans.php');

?>
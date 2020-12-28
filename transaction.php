<?php
$mysqli = new mysqli("localhost", "root", "", "TCH");
session_start();
// Check connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$id = intval($_GET['id']);
$accountID = $_SESSION['account_id'];
$query = $mysqli->prepare("select quantity, item_id, account_id, quantity, email, name, price, total, transaction_id from transaction_item_account join account a on a.id = transaction_item_account.account_id join item i on i.id = transaction_item_account.item_id join transaction t on t.id = transaction_item_account.transaction_id where transaction_id = ? account_id = ?");
$query->bind_param("ii",$id,$accountID);
$message = $query->execute();
$res = $query->get_result();
echo json_encode($res->fetch_all(MYSQLI_ASSOC));
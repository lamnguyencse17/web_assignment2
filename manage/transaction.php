<?php

$mysqli = new mysqli("localhost", "root", "", "TCH");
// Check connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
$limit = intval($_GET['limit']);
$offset = intval($_GET['offset']);
$query = $mysqli->prepare("select quantity, item_id, account_id, quantity, email, name, price, total, transaction_id from transaction_item_account join account a on a.id = transaction_item_account.account_id join item i on i.id = transaction_item_account.item_id join transaction t on t.id = transaction_item_account.transaction_id  LIMIT ? OFFSET ? ");
$query->bind_param("ii", $limit, $offset);
$message = $query->execute();
$res = $query->get_result();
echo json_encode($res->fetch_all(MYSQLI_ASSOC));
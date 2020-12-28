<?php
$mysqli = new mysqli("localhost", "root", "", "TCH");
session_start();
// Check connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $id = intval($_GET['id']);
    $accountID = intval($_SESSION['account_id']);
    $query = $mysqli->prepare("select quantity, item_id, account_id, quantity, email, name, price, total, transaction_id from transaction_item_account join account a on a.id = transaction_item_account.account_id join item i on i.id = transaction_item_account.item_id join transaction t on t.id = transaction_item_account.transaction_id where transaction_id = ? and account_id = ?");
    $query->bind_param("ii",$id,$accountID);
    $message = $query->execute();
    $res = $query->get_result();
    echo json_encode($res->fetch_all(MYSQLI_ASSOC));
    return;
}
$data[] = json_decode(file_get_contents('php://input'), true);
$data = $data[0];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $data["type"] == 'CREATE'){
//    $accountID = intval($_SESSION['account_id']);
    $accountID = 1;
    $items = $data['items'];
    //items: [[item_id, quantity]]
    $total = 0;
    $item_array = array();
    $errMsg = new stdClass();
    $errMsg->message = "";
    foreach ($items as $item){
        $queryFetch = $mysqli->prepare("SELECT price from item where id = ?");
        $queryFetch->bind_param("i", $item[0]);
        $queryFetch->execute();
        $result = $queryFetch->get_result();
        $price = $result->fetch_row();
        if ($price != null){
            $total = $total + $item[1]*$price[0];
            array_push($item_array, $item[0]);
        } else {
            $errMsg->message = "Non existent ID";
            http_response_code(400);
            echo json_encode($errMsg);
            return;
        }
    }
    $createTransactionQuery = $mysqli->prepare("insert into transaction (total) values (?) ");
    $createTransactionQuery->bind_param("i", $total);
    $createResult = $createTransactionQuery->execute();
    if ($createResult === true){
        $transactionId = $mysqli->insert_id;
        foreach ($items as $item){
            $addTransactionQuery = $mysqli->prepare("insert into transaction_item_account (transaction_id, item_id, account_id, quantity) values (?, ?, ?, ?) ");
            $addTransactionQuery->bind_param("iiii", $transactionId, $item[0], $accountID, $item[1]);
            $addTransactionQuery->execute();
        }
    } else {
        $errMsg->message = "Something went wrong";
        http_response_code(400);
        echo json_encode($errMsg);
        return;
    }
}
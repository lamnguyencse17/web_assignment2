<?php

$mysqli = new mysqli("localhost", "root", "", "TCH");

// Check connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
function validateItem ($name, $price){
    $errMsg = new stdClass();
    $errMsg->name = "";
    $errMsg->price = "";
    if (empty($name) || strlen($name) < 6) {
        $errMsg->email = "Invalid Item Name";
    }
    if (strlen($name) > 30) {
        $errMsg->password = "Item Name is too long";
    }
    if (!is_int($price) || $price < 0) {
        $errMsg->price = "Invalid Price";
    }
    return $errMsg;
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $limit = intval($_GET['limit']);
    $offset = intval($_GET['offset']);
    $query = $mysqli->prepare("SELECT * FROM item LIMIT ? OFFSET ?");
    $query->bind_param('ii', $limit, $offset);
    $query->execute();
    $result = $query->get_result();
    $response = json_encode($result->fetch_all(MYSQLI_ASSOC));
    echo $response;
    $query->close();
}
$data = json_decode(file_get_contents('php://input'), true);
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $data["type"] == 'CREATE'){
    $name = $data["name"];
    $price = intval($data["price"]);
    $errMsg = new stdClass();
    $errMsg = validateItem($name, $price);
    $query = $mysqli->prepare("insert into tch.item(name, price) values (?, ?)") ;
    $query->bind_param("si", $name, $price);
    $message = $query->execute();
    $returnData = new stdClass();
    if ($message === true){
        http_response_code(201);
        $returnData->message = "Successfully added new item";
        $returnData = json_encode((array)$returnData);
        echo $returnData;
        return;
    }
    http_response_code(400);
    $returnData->message = "Item Name is duplicated";
    $returnData = json_encode((array)$returnData);
    echo $returnData;
    return;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $data["type"] == 'UPDATE') {
    $id = intval($data["id"]);
    $name = $data["name"];
    $price = intval($data["price"]);
    $errMsg = new stdClass();
    if (!is_int($id) || $id < 0) {
        $errMsg->message = "Invalid ID";
        http_response_code(400);
        $returnData = json_encode((array)$errMsg);
        echo $returnData;
        return;
    }
    $errMsg = validateItem($name, $price);
    if ($errMsg->name !== "" || $errMsg->price !== "") {
        $returnData = json_encode((array)$errMsg);
        echo $returnData;
        return;
    }
    $query = $mysqli->prepare("UPDATE item SET name= ?, price= ? WHERE id= ?");
    $query->bind_param('sii', $name, $price, $id);
    $query->execute();
    $isUpdated = $query->affected_rows;
    $returnData = new stdClass();
    if ($isUpdated === 0) {
        $returnData->message = "Nothing is updated";
        http_response_code(400);
        $returnData = json_encode((array)$returnData);
        echo $returnData;
        return;
    }
    $returnData->message = "Updated Successfully";
    http_response_code(200);
    $returnData = json_encode((array)$returnData);
    echo $returnData;
    return;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $data["type"] == 'DELETE') {
    $id = intval($data["id"]);
    $errMsg = new stdClass();
    if (!is_int($id) || $id < 0) {
        $errMsg->message = "Invalid ID";
        http_response_code(400);
        $returnData = json_encode((array)$errMsg);
        echo $returnData;
        return;
    }
    $query = $mysqli->prepare("DELETE FROM item WHERE id=?");
    $query->bind_param('i', $id);
    $query->execute();
    $isDeleted = $query->affected_rows;
    $returnData = new stdClass();
    if ($isDeleted === 0) {
        $returnData->message = "Nothing is deleted";
        http_response_code(400);
        $returnData = json_encode((array)$returnData);
        echo $returnData;
        return;
    }
    $returnData->message = "Deleted Successfully";
    http_response_code(200);
    $returnData = json_encode((array)$returnData);
    echo $returnData;
    return;
}
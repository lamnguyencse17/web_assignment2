<?php
$mysqli = new mysqli("localhost", "root", "", "TCH");

// Check connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
$limit = intval($_GET['limit']);
$offset = intval($_GET['offset']);
$query = $mysqli->prepare("SELECT * FROM account LIMIT ? OFFSET ?");
$query->bind_param('ii', $limit, $offset);
$query->execute();
$result = $query->get_result();
$response = json_encode($result->fetch_all(MYSQLI_ASSOC));
echo $response;
$query->close();
}
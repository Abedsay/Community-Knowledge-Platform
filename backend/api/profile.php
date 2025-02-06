<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../models/User.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

// Check if userId is provided in the request (assuming user is logged in)
if (!isset($_GET["userId"])) {
    echo json_encode(["message" => "User ID is required."]);
    exit();
}

$user->UserId = $_GET["userId"];
$result = $user->readSingle();

if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo json_encode($row);
} else {
    echo json_encode(["message" => "User not found."]);
}
?>

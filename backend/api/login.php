<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../models/User.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if (!isset($data->email) || !isset($data->password)) {
        echo json_encode(["message" => "Missing fields", "received" => $data]);
        exit;
    }

    $user->Email = $data->email;
    $user->Password = $data->password;
    
    $result = $user->login();

    if ($result && isset($result['token']) && isset($result['userId'])) {
        echo json_encode([
            "message" => "Login successful",
            "token" => $result['token'],
            "userId" => $result['userId']
        ]);
    } else {
        echo json_encode(["message" => "Invalid email or password."]);
    }
}
?>

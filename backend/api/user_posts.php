<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../models/Post.php';

$database = new Database();
$db = $database->getConnection();
$post = new Post($db);

// Ensure UserId is provided
if (!isset($_GET["userId"])) {
    echo json_encode(["message" => "User ID is required."]);
    exit();
}

$post->UserId = $_GET["userId"];
$result = $post->readByUser();

$posts_arr = [];
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $posts_arr[] = $row;
}

echo json_encode($posts_arr);
?>

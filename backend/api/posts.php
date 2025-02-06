<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../models/Post.php';

$database = new Database();
$db = $database->getConnection();
$post = new Post($db);

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'POST': // Create Post
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->Title) && !empty($data->Description) && !empty($data->UserId)) {
            $post->Title = $data->Title;
            $post->Description = $data->Description;
            $post->UserId = $data->UserId;

            echo json_encode(["message" => $post->create() ? "Post created successfully." : "Failed to create post."]);
        } else {
            echo json_encode(["message" => "Incomplete data."]);
        }
        break;

    case 'GET': // Read Posts
        if (isset($_GET["id"])) {
            $post->PostId = $_GET["id"];
            $result = $post->readSingle();
        } else {
            $result = $post->read();
        }

        $posts_arr = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $posts_arr[] = $row;
        }
        echo json_encode($posts_arr);
        break;

    case 'PUT': // Update Post
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->PostId) && !empty($data->Title) && !empty($data->Description)) {
            $post->PostId = $data->PostId;
            $post->Title = $data->Title;
            $post->Description = $data->Description;

            echo json_encode(["message" => $post->update() ? "Post updated successfully." : "Failed to update post."]);
        } else {
            echo json_encode(["message" => "Incomplete data."]);
        }
        break;

    case 'DELETE': // Delete Post
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->PostId)) {
            $post->PostId = $data->PostId;
            echo json_encode(["message" => $post->delete() ? "Post deleted successfully." : "Failed to delete post."]);
        } else {
            echo json_encode(["message" => "PostId is required."]);
        }
        break;

    default:
        echo json_encode(["message" => "Invalid request."]);
        break;
}
?>

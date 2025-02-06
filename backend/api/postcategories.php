<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../models/PostCategory.php';

$database = new Database();
$db = $database->getConnection();
$postCategory = new PostCategory($db);

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'POST': // Assign Category to Post
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->PostId) && !empty($data->CategoryId)) {
            $postCategory->PostId = $data->PostId;
            $postCategory->CategoryId = $data->CategoryId;

            echo json_encode(["message" => $postCategory->assignCategory() ? "Category assigned." : "Failed to assign category."]);
        } else {
            echo json_encode(["message" => "Incomplete data."]);
        }
        break;

    case 'GET': // Get Categories for a Post
        if (isset($_GET["postId"])) {
            $postCategory->PostId = $_GET["postId"];
            $result = $postCategory->getCategoriesByPost();
            $categories_arr = [];
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $categories_arr[] = $row;
            }
            echo json_encode($categories_arr);
        } else {
            echo json_encode(["message" => "postId is required."]);
        }
        break;

    default:
        echo json_encode(["message" => "Invalid request."]);
        break;
}
?>

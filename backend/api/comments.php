<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../models/Comment.php';

$database = new Database();
$db = $database->getConnection();
$comment = new Comment($db);

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'POST': // Create Comment
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->Content) && !empty($data->UserId) && !empty($data->PostId)) {
            $comment->Content = $data->Content;
            $comment->UserId = $data->UserId;
            $comment->PostId = $data->PostId;

            echo json_encode(["message" => $comment->create() ? "Comment added successfully." : "Failed to add comment."]);
        } else {
            echo json_encode(["message" => "Incomplete data."]);
        }
        break;

        case 'GET': // Read Comments for a Post with Usernames
            if (isset($_GET["postId"])) {
                $comment->PostId = $_GET["postId"];
                $result = $comment->readByPost();
                $comments_arr = [];
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $comments_arr[] = [
                        "CommentId" => $row["CommentId"],
                        "Content" => $row["Content"],
                        "UserId" => $row["UserId"],
                        "PostId" => $row["PostId"],
                        "CreatedAt" => $row["CreatedAt"],
                        "Username" => $row["Username"] ?? "Unknown User" // ✅ Now returns correct username
                    ];
                }
                echo json_encode($comments_arr);
            } else {
                echo json_encode(["message" => "postId is required."]);
            }
            break;
        

    case 'DELETE': // Delete Comment
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->CommentId)) {
            $comment->CommentId = $data->CommentId;
            echo json_encode(["message" => $comment->delete() ? "Comment deleted successfully." : "Failed to delete comment."]);
        } else {
            echo json_encode(["message" => "CommentId is required."]);
        }
        break;

    default:
        echo json_encode(["message" => "Invalid request."]);
        break;
}
?>

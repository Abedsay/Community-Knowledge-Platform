<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../models/Vote.php';

$database = new Database();
$db = $database->getConnection();
$vote = new Vote($db);

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'POST': 
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->UserId) && !empty($data->PostId) && !empty($data->VoteType)) {
            $vote->UserId = $data->UserId;
            $vote->PostId = $data->PostId;
            $vote->VoteType = $data->VoteType;

            echo json_encode(["message" => $vote->create() ? "Vote registered." : "Failed to register vote."]);
        } else {
            echo json_encode(["message" => "Incomplete data."]);
        }
        break;

        case 'GET': 
            if (isset($_GET["postId"])) {
                $vote->PostId = $_GET["postId"];
                $totalVotes = $vote->getVoteCount();
                echo json_encode(["votes" => $totalVotes]);
            } else {
                echo json_encode(["message" => "postId is required."]);
            }
            break;
        
    case 'DELETE': 
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->VoteId)) {
            $vote->VoteId = $data->VoteId;
            echo json_encode(["message" => $vote->delete() ? "Vote removed." : "Failed to remove vote."]);
        } else {
            echo json_encode(["message" => "VoteId is required."]);
        }
        break;

    default:
        echo json_encode(["message" => "Invalid request."]);
        break;
}
?>
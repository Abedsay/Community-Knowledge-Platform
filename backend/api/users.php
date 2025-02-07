<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../models/User.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->username) && !empty($data->email) && !empty($data->password)) {
            $user->Username = $data->username;
            $user->Email = $data->email;
            $user->Password = $data->password;
            $user->RoleId = 2;

            if ($user->create()) {
                echo json_encode(["message" => "User created successfully."]);
            } else {
                echo json_encode(["message" => "Failed to create user."]);
            }
        } else {
            echo json_encode(["message" => "Incomplete data."]);
        }
        break;

    case 'GET':
        if (isset($_GET["id"])) {
            $user->UserId = $_GET["id"];
            $result = $user->readSingle();
        } else {
            $result = $user->read();
        }

        $users_arr = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $users_arr[] = $row;
        }
        echo json_encode($users_arr);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->UserId) && !empty($data->Username) && !empty($data->Email) && !empty($data->RoleId)) {
            $user->UserId = $data->UserId;
            $user->Username = $data->Username;
            $user->Email = $data->Email;
            $user->RoleId = $data->RoleId;

            echo json_encode(["message" => $user->update() ? "User updated successfully." : "Failed to update user."]);
        } else {
            echo json_encode(["message" => "Incomplete data."]);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->UserId)) {
            $user->UserId = $data->UserId;
            echo json_encode(["message" => $user->delete() ? "User deleted successfully." : "Failed to delete user."]);
        } else {
            echo json_encode(["message" => "UserId is required."]);
        }
        break;

    default:
        echo json_encode(["message" => "Invalid request."]);
        break;
}
?>

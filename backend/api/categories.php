<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../models/Category.php';

$database = new Database();
$db = $database->getConnection();
$category = new Category($db);

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'POST': 
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->CategoryName)) {
            $category->CategoryName = $data->CategoryName;
            echo json_encode(["message" => $category->create() ? "Category created successfully." : "Failed to create category."]);
        } else {
            echo json_encode(["message" => "Incomplete data."]);
        }
        break;

    case 'GET': 
        $result = $category->read();
        $categories_arr = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $categories_arr[] = $row;
        }
        echo json_encode($categories_arr);
        break;

    case 'DELETE': 
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->CategoryId)) {
            $category->CategoryId = $data->CategoryId;
            echo json_encode(["message" => $category->delete() ? "Category deleted successfully." : "Failed to delete category."]);
        } else {
            echo json_encode(["message" => "CategoryId is required."]);
        }
        break;

    default:
        echo json_encode(["message" => "Invalid request."]);
        break;
}
?>

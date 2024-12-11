<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET"); 
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once './../connectdb.php';
require_once './../models/trip.php'; // นำเข้า Trip model

// สร้าง instance
$connDB = new ConnectDB();
$trip = new Trip($connDB->getConnectionDB());


$data = json_decode(file_get_contents("php://input"));

// ตรวจสอบว่ามีการส่งข้อมูล user_id, min_cost และ max_cost มาหรือไม่
if (isset($data->user_id) && isset($data->min_cost) && isset($data->max_cost)) {
    
    $trip->user_id = $data->user_id;

    
    $trips = $trip->getTripByUserIdAndCost($data->min_cost, $data->max_cost);

   
    if (!empty($trips)) {
        echo json_encode($trips, JSON_UNESCAPED_UNICODE); 
    } else {
        echo json_encode(["message" => "No trips found within the specified cost range."], JSON_UNESCAPED_UNICODE);
    }
} else {
    
    echo json_encode(["message" => "Invalid input. Please provide user_id, min_cost, and max_cost."], JSON_UNESCAPED_UNICODE);
}

?>
<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET"); 
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once './../connectdb.php';
require_once './../models/trip.php'; // นำเข้า Trip model

//สร้าง instance
$connDB = new ConnectDB();
$trip = new Trip($connDB->getConnectionDB());

//รับค่าที่ส่งมาจาก Client/User ซึ่งเป็น JSON มา Decode แล้วมาเก็บไว้ในตัวแปร
$data = json_decode(file_get_contents("php://input"));

// ตรวจสอบว่ามีการส่งข้อมูล user_id, start_date, end_date มาหรือไม่
if (isset($data->user_id) && isset($data->start_date) && isset($data->end_date)) {
    
    $trip->user_id = $data->user_id;

   
    $trips = $trip->getTripByUserIdAndDate($data->start_date, $data->end_date);

    
    if (!empty($trips)) {
        echo json_encode($trips, JSON_UNESCAPED_UNICODE); 
    } else {
        echo json_encode(["message" => "No trips found for the specified date range."], JSON_UNESCAPED_UNICODE);
    }
} else {
   
    echo json_encode(["message" => "Invalid input. Please provide user_id, start_date, and end_date."], JSON_UNESCAPED_UNICODE);
}

?>
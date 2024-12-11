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

// ตรวจสอบว่ามีการส่งข้อมูล user_id และ location_name มาหรือไม่
if (isset($data->user_id) && isset($data->location_name)) {
    // กำหนดค่าที่รับมาจาก Client ไปยังตัวแปรของ Model
    $trip->user_id = $data->user_id;

    // เรียกใช้ฟังก์ชัน getTripsByUserIdAndLocation เพื่อดึงข้อมูล
    $trips = $trip->getTripsByUserIdAndLocation($data->location_name);

    // ตรวจสอบว่ามีข้อมูลการเดินทางหรือไม่
    if (!empty($trips)) {
        echo json_encode($trips, JSON_UNESCAPED_UNICODE); // ส่งคืนข้อมูลการเดินทาง
    } else {
        echo json_encode(["message" => "No trips found matching the specified location."], JSON_UNESCAPED_UNICODE);
    }
} else {
    // หากข้อมูลไม่ครบถ้วน
    echo json_encode(["message" => "Invalid input. Please provide user_id and location_name."], JSON_UNESCAPED_UNICODE);
}

?>
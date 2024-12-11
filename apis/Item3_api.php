<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/trip.php"; 

// สร้าง instance (object/ตัวแทน)
$connDB = new ConnectDB();
$trip = new Trip($connDB->getConnectionDB());

// รับค่าที่ส่งมาจาก Client/User ซึ่งเป็น JSON มาทำการ Decode เก็บในตัวแปร
$data = json_decode(file_get_contents("php://input"));

// ตั้งค่าตัวแปรในโมเดล
$trip->user_id = $data->user_id;
$trip->start_date = $data->start_date;
$trip->end_date = $data->end_date;
$trip->location_name = $data->location_name;
$trip->latitude = $data->latitude;
$trip->longitude = $data->longitude;
$trip->cost = $data->cost;
$trip->created_at = date('Y-m-d H:i:s'); // กำหนดวันที่สร้างเป็นเวลาปัจจุบัน

// เรียกใช้ฟังก์ชันสร้างการเดินทางใหม่
$result = $trip->createTrip();


if ($result) {
    $resultArray = array(
        "message" => "trip_created"
    );
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
} else {
    $resultArray = array(
        "message" => "trip_creation_failed"
    );
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
}
?>
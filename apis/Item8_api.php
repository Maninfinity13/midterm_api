<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/trip.php"; // เปลี่ยนชื่อโมเดลให้ตรงกับโมเดลที่เราใช้

// สร้าง instance (object/ตัวแทน)
$connDB = new ConnectDB();
$trip = new Trip($connDB->getConnectionDB());

// รับค่าที่ส่งมาจาก Client/User ซึ่งเป็น JSON มาทำการ Decode เก็บในตัวแปร
$data = json_decode(file_get_contents("php://input"));

$trip->trip_id = $data->trip_id; // เปลี่ยนให้ตรงตามชื่อคอลัมน์
$trip->user_id = $data->user_id;
$trip->start_date = $data->start_date;
$trip->end_date = $data->end_date;
$trip->location_name = $data->location_name;
$trip->latitude = $data->latitude;
$trip->longitude = $data->longitude;
$trip->cost = $data->cost;
$trip->created_at = $data->created_at;

// เรียกใช้ฟังก์ชันอัปเดตข้อมูลการเดินทาง
$result = $trip->updateTrip();

// ตรวจสอบผลการทำงาน
if ($result == true) {
    // insert - update - delete สำเร็จ
    $resultArray = array(
        "message" => "1"
    );
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
} else {
    // insert - update - delete ไม่สำเร็จ
    $resultArray = array(
        "message" => "0"
    );
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
}
?>
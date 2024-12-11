<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/trip.php"; 

// สร้าง instance (object/ตัวแทน)
$connDB = new ConnectDB();
$trip = new Trip($connDB->getConnectionDB());

// รับ user_id จาก query parameter
$userId = isset($_GET['user_id']) ? $_GET['user_id'] : die();

// เรียกใช้ฟังก์ชันดึงข้อมูลการเดินทาง
$result = $trip->getTripsByUserId($userId);


if ($result->rowCount() > 0) {
    $tripsArray = array();
    
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $tripsArray[] = $row; // เก็บข้อมูลแต่ละเรคอร์ดในอาเรย์
    }

    echo json_encode(array("message" => "1", "trips" => $tripsArray), JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(array("message" => "0", "trips" => array()), JSON_UNESCAPED_UNICODE);
}
?>
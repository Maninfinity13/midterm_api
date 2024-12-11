<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/myprofile.php"; 

// สร้าง instance (object/ตัวแทน)
$connDB = new ConnectDB();
$profile = new MyProfile($connDB->getConnectionDB());

// รับค่าที่ส่งมาจาก Client/User ซึ่งเป็น JSON มาทำการ Decode เก็บในตัวแปร
$data = json_decode(file_get_contents("php://input"));

// ตั้งค่าตัวแปรในโมเดล
$profile->username = $data->username;
$profile->password = $data->password; 
$profile->email = $data->email;

// เรียกใช้ฟังก์ชันสร้างผู้ใช้ใหม่
$result = $profile->createUser();

// ตรวจสอบผลการทำงาน
if ($result) {
    $resultArray = array(
        "message" => "user_created"
    );
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
} else {
    $resultArray = array(
        "message" => "user_creation_failed"
    );
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
}
?>
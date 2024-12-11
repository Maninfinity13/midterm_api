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

// เอาค่าที่ได้รับจาก Client/User มาตั้งค่าที่โมเดล
$profile->username = $data->username;
$profile->password = $data->password; 

// เรียกใช้ฟังก์ชันตรวจสอบชื่อผู้ใช้และรหัสผ่าน
$result = $profile->checkLogin();

// ตรวจสอบข้อมูลจากการเรียกฟังก์ชัน
if ($result->rowCount() > 0) {
    $resultData = $result->fetch(PDO::FETCH_ASSOC);
    
    // สร้างตัวแปรเป็น array เก็บข้อมูล
    $resultArray = array(
        "message" => "success",
        "user_id" => $resultData['user_id'],
        "username" => $resultData['username'],
        "email" => $resultData['email']
    );
    
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
} else {
    $resultArray = array(
        "message" => "invalid_credentials"
    );
    
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
}
?>
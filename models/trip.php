<?php
class Trip {
    private $connDB;
    private $table_name = "trip_tb";

    public $trip_id;
    public $user_id;
    public $start_date;
    public $end_date;
    public $location_name;
    public $latitude;
    public $longitude;
    public $cost;

    public $message;


    public function __construct($db) {
        $this->conn = $db;
    }


    public function createTrip() {
        $strSQL = "INSERT INTO trip_tb (user_id, start_date, end_date, location_name, latitude, longitude, cost, created_at) 
                    VALUES (:user_id, :start_date, :end_date, :location_name, :latitude, :longitude, :cost, :created_at)";
        
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->start_date = htmlspecialchars(strip_tags($this->start_date));
        $this->end_date = htmlspecialchars(strip_tags($this->end_date));
        $this->location_name = htmlspecialchars(strip_tags($this->location_name));
        $this->latitude = doubleval(htmlspecialchars(strip_tags($this->latitude)));
        $this->longitude = doubleval(htmlspecialchars(strip_tags($this->longitude)));
        $this->cost = doubleval(htmlspecialchars(strip_tags($this->cost)));
        $this->created_at = htmlspecialchars(strip_tags($this->created_at));
    
        $stmt = $this->connDB->prepare($strSQL);
    
        // Binding parameters
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":start_date", $this->start_date);
        $stmt->bindParam(":end_date", $this->end_date);
        $stmt->bindParam(":location_name", $this->location_name);
        $stmt->bindParam(":latitude", $this->latitude);
        $stmt->bindParam(":longitude", $this->longitude);
        $stmt->bindParam(":cost", $this->cost);
        $stmt->bindParam(":created_at", $this->created_at);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function deleteTrip()
    {
        $strSQL = "DELETE FROM trip_tb WHERE trip_id = :trip_id";
        $this->trip_id = htmlspecialchars(strip_tags($this->trip_id));
        $stmt = $this->connDB->prepare($strSQL);
        $stmt->bindParam(":trip_id", $this->trip_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getTripsByUserId($userId) {
        $strSQL = "SELECT * FROM trip_tb WHERE user_id = :user_id";
        
        $stmt = $this->connDB->prepare($strSQL);
        $stmt->bindParam(":user_id", $userId);
        $stmt->execute();
    
        return $stmt; // คืนค่า statement สำหรับใช้ในการดึงข้อมูล
    }

    public function updateTrip()
    {
        $strSQL = "UPDATE trip_tb SET 
            user_id = :user_id, 
            start_date = :start_date, 
            end_date = :end_date, 
            location_name = :location_name, 
            latitude = :latitude, 
            longitude = :longitude, 
            cost = :cost, 
            created_at = :created_at
            WHERE trip_id = :trip_id";

        $this->trip_id = htmlspecialchars(strip_tags($this->trip_id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->start_date = htmlspecialchars(strip_tags($this->start_date));
        $this->end_date = htmlspecialchars(strip_tags($this->end_date));
        $this->location_name = htmlspecialchars(strip_tags($this->location_name));
        $this->latitude = doubleval(htmlspecialchars(strip_tags($this->latitude)));
        $this->longitude = doubleval(htmlspecialchars(strip_tags($this->longitude)));
        $this->cost = doubleval(htmlspecialchars(strip_tags($this->cost)));
        $this->created_at = htmlspecialchars(strip_tags($this->created_at));

        $stmt = $this->connDB->prepare($strSQL);

        $stmt->bindParam(":trip_id", $this->trip_id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":start_date", $this->start_date);
        $stmt->bindParam(":end_date", $this->end_date);
        $stmt->bindParam(":location_name", $this->location_name);
        $stmt->bindParam(":latitude", $this->latitude);
        $stmt->bindParam(":longitude", $this->longitude);
        $stmt->bindParam(":cost", $this->cost);
        $stmt->bindParam(":created_at", $this->created_at);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    // ฟังก์ชันบันทึกข้อมูลการเดินทาง
    public function addTrip() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (user_id, start_date, end_date, location_name, latitude, longitude, cost) 
                  VALUES 
                  (:user_id, :start_date, :end_date, :location_name, :latitude, :longitude, :cost)";

        // เตรียมคำสั่ง SQL
        $stmt = $this->connDB->prepare($query);

        // bind ค่าตัวแปร
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':start_date', $this->start_date);
        $stmt->bindParam(':end_date', $this->end_date);
        $stmt->bindParam(':location_name', $this->location_name);
        $stmt->bindParam(':latitude', $this->latitude);
        $stmt->bindParam(':longitude', $this->longitude);
        $stmt->bindParam(':cost', $this->cost);

        // เรียกใช้ execute() เพื่อรัน query
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function getTripsByUserIdAndLocation($location_name) {
        // คำสั่ง SQL สำหรับดึงข้อมูลการเดินทางทั้งหมดจาก user_id หนึ่งๆ และชื่อสถานที่ที่ตรงกัน
        $strSQL = "SELECT * FROM trip_tb WHERE user_id = :user_id AND location_name LIKE :location_name";
    
        // ทำความสะอาดข้อมูล
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $location_name = htmlspecialchars(strip_tags($location_name));
    
        // เตรียมคำสั่ง SQL
        $stmt = $this->connDB->prepare($strSQL);
    
        // ผูกค่า parameter
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':location_name', $location_name);
    
        // เปลี่ยนค่า $location_name ให้มี '%' เพื่อให้สามารถค้นหาที่ตรงกับบางส่วนได้
        $location_name = "%$location_name%";
    
        // ทำการ execute คำสั่ง SQL
        $stmt->execute();
    
        // ส่งคืนข้อมูลทั้งหมดในรูปแบบ associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTripByUserIdAndDate($start_date, $end_date){
        // คำสั่ง SQL สำหรับดึงข้อมูลการเดินทางทั้งหมดจาก user_id หนึ่งๆ และอยู่ในช่วงวันที่กำหนด
        $strSQL = "SELECT * FROM trip_tb WHERE user_id = :user_id AND start_date >= :start_date AND end_date <= :end_date";
    
        // ทำความสะอาดข้อมูล
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $start_date = htmlspecialchars(strip_tags($start_date));
        $end_date = htmlspecialchars(strip_tags($end_date));
    
       
        $stmt = $this->connDB->prepare($strSQL);
    
        // ผูกค่า parameter
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
    
        
        $stmt->execute();
    
        // ส่งคืนข้อมูลทั้งหมดในรูปแบบ associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTripByUserIdAndCost($min_cost, $max_cost) {
        // คำสั่ง SQL สำหรับดึงข้อมูลการเดินทางทั้งหมดจาก user_id หนึ่งๆ และค่าใช้จ่ายที่อยู่ในช่วงที่กำหนด
        $strSQL = "SELECT * FROM trip_tb WHERE user_id = :user_id AND cost BETWEEN :min_cost AND :max_cost";
    
        // ทำความสะอาดข้อมูล
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $min_cost = htmlspecialchars(strip_tags($min_cost));
        $max_cost = htmlspecialchars(strip_tags($max_cost));
    
        // เตรียมคำสั่ง SQL
        $stmt = $this->connDB->prepare($strSQL);
    
        // ผูกค่า parameter
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':min_cost', $min_cost);
        $stmt->bindParam(':max_cost', $max_cost);
    
        // ทำการ execute คำสั่ง SQL
        $stmt->execute();
    
        // ส่งคืนข้อมูลทั้งหมดในรูปแบบ associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
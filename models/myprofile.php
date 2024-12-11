<?php

class Myprofile
{
    public $connDB;

    //ตัวแปรที่ทำงานคู่กับคอลัมน์(ฟิวล์)ในตาราง
    public $userID;
    public $username;
    public $password;
    public $email;
    public $created_at;

    // ตัวแปรสารพัดประโยชน์ยังไง
    public $message;

    public function __construct($connDB)
    {
        $this->connDB = $connDB;
    }
    public function checkLogin() {
        $strSQL = "SELECT user_id, username, email FROM myprofile_tb WHERE username = :username AND password = :password";
        
        // ป้องกันการโจมตี SQL Injection
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
    
        $stmt = $this->connDB->prepare($strSQL);
        
        // Binding parameters
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password); // ควรใช้ password ที่เข้ารหัส
        // หากคุณเก็บรหัสผ่านในฐานข้อมูลในรูปแบบที่เข้ารหัส (เช่น bcrypt) ควรใช้ password_verify เพื่อเปรียบเทียบ
    
        $stmt->execute();
        return $stmt;
    }

    public function createUser() {
        $strSQL = "INSERT INTO myprofile_tb (username, password, email) VALUES (:username, :password, :email)";
        
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password)); // ควรเข้ารหัสรหัสผ่านที่นี่
        $this->email = htmlspecialchars(strip_tags($this->email));
    
        $stmt = $this->connDB->prepare($strSQL);
    
        // Binding parameters
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", password_hash($this->password, PASSWORD_BCRYPT)); // เข้ารหัสรหัสผ่าน
        $stmt->bindParam(":email", $this->email);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

}
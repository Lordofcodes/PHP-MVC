<?php

namespace Core;
use \PDO;
use App\Config;

abstract class Model
{

    private static $conn;
    
    private static function getDB()
    {

        if(isset(self::$conn))
        {        
            return self::$conn;
        }
        try{

          self::$conn = new PDO('mysql:host='.Config::DB_HOST.';dbname='.Config::DB_NAME,Config::DB_USER,Config::DB_PASSWORD);
          self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          return self::$conn;
            } catch(PDOException $e)
            {
                 echo "Connection failed: " . $e->getMessage();
            }
        }

    
        public static function all()
        {
           $pdo =   self::getDB();
         
           $table = explode('\\',get_called_class());
           $table = strtolower(end($table)).'s';
         
           $stmt = $pdo->query("SELECT * FROM $table")->fetchAll(PDO::FETCH_OBJ);
           return $stmt;
        }

        public static function find($id)
        {
           $pdo =   self::getDB();
          
           $table = explode('\\',get_called_class());
           $table = strtolower(end($table)).'s';

           if($stmt = $pdo->query("SELECT * FROM $table WHERE id=$id")->fetch(PDO::FETCH_OBJ)){
             return $stmt;
           }
           echo "<i>No post found...";
           exit();

          

        }
}
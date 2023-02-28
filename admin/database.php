<?php

class Database
{
    //quand nous somme das=ns une classe et qu'on veut use une propriete qui est statique, on doit use le mot self

    private static $dbHost="localhost";
    private static $dbName = "burger_code2";
    private static $dbUser = "root";
    private static $dbUserPassword="";
    private static $connection = null;

    public static function connect()//on ne peut pas parler de statique sans preciser si c'est privee ou pas
    {

        
        try
        {
            self::$connection=new PDO("mysql:host=".self::$dbHost.";dbname=".self::$dbName,self::$dbUser, self::$dbUserPassword, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch(PDOException $e)
        {
            die($e->getMessage());
        }

        return self::$connection;

    }

    public static function  disconnect()
    {
        self::$connection=null;
    }
}

   

?>
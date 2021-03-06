<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

class Conexion
{

    private $host = "localhost";
    private $user = "root";
    private $pw = "";
    private $db  = "biblioteca";

    public function Conectar()
    {
        $cnx  = "mysql:host=$this->host;dbname=$this->db";
        $conectar = new PDO($cnx, $this->user, $this->pw);
        $conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conectar;
    }
}


?>
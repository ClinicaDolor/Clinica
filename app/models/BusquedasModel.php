<?php
namespace App\Models;
use App\Config\Database;
class BusquedasModel{

    private $bd;
    public function __construct(){
        $this->bd = Database::getInstance();
    }

    public function getPacientes($query){

        $sql = "SELECT id, nombre_completo AS nombre FROM pc_paciente WHERE nombre_completo LIKE :query LIMIT 20";
        $stmt = $this->bd->prepare($sql);
        $stmt->execute(['query' => "%{$query}%"]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }


}
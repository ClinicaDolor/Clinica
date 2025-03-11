<?php
namespace App\Models;

use App\Config\Database;
class PacienteModel{
    private $bd;
    private $id_paciente;
    private $fecha_alta;
    private $nombre_completo;
    private $fecha_nacimiento;
    private $sexo;
    private $estado_civil;
    private $email;
    private $telefono;
    private $celular;
    private $curp;
    public function __construct($id){
        $this->bd = Database::getInstance();
        $this->id_paciente = $id;

        $query = "SELECT * FROM pc_paciente WHERE id = :id";
        $stmt = $this->bd->prepare($query);
        $stmt->bindParam(':id', $this->id_paciente);
        $stmt->execute();
        $registros = $stmt->fetch(\PDO::FETCH_ASSOC);

        $this->fecha_alta = $registros['fecha_alta'];
        $this->nombre_completo = $registros['nombre_completo'];
        $this->fecha_nacimiento = $registros['fecha_nacimiento'];
        $this->sexo = $registros['sexo'];
        $this->estado_civil = $registros['estado_civil'];
        $this->curp = $registros['curp'];

        $this->email = $registros['email'];
        $this->telefono = $registros['telefono'];
        $this->celular = $registros['celular'];

    }

    public function getFechaAlta(){
        return $this->fecha_alta;
    }

    public function getNombreCompleto(){
        return $this->nombre_completo;
    }

    public function getFechaNacimiento(){
        return $this->fecha_nacimiento;
    }

    public function getSexo(){
        return $this->sexo;
    }

    public function getEstadoCivil(){
        return $this->estado_civil;
    }

    public function getCurp(){
        return $this->curp;
    }

    public function getEmail(){
        return $this->email;
    }
    public function getTelefono(){
        return $this->telefono;
    }
    public function getCelular(){
        return $this->celular;
    }


}
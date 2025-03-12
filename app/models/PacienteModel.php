<?php
namespace App\Models;

use App\Config\Database;
class PacienteModel{
    private $bd;
    private $id_paciente;
    private $fecha_alta;
    private $nombre_completo;
    private $edad;
    private $fecha_nacimiento;
    private $sexo;
    private $estado_civil;
    private $lugar_origen;
    private $lugar_residencia;
    private $ocupacion;
    private $num_hijos;
    private $edad_hijos;
    private $quien_recomienda;
    private $redes_sociales;
    private $motivo_atencion;
    private $calle;
    private $num_interior;
    private $num_exterior;
    private $colonia;
    private $delegacion;
    private $cp;
    private $municipio;
    private $distancia;
    private $cuidador;
    private $cuidador_telefono;
    private $email;
    private $telefono;
    private $celular;
    private $curp;
    private $res_nombre;
    private $res_telefono;

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
        $this->edad = $registros['edad'];
        $this->fecha_nacimiento = $registros['fecha_nacimiento'];
        $this->sexo = $registros['sexo'];
        $this->estado_civil = $registros['estado_civil'];
        $this->curp = $registros['curp'];
        $this->lugar_origen = $registros['lugar_origen'];
        $this->lugar_residencia = $registros['lugar_residencia'];
        $this->ocupacion = $registros['ocupacion'];
        $this->num_hijos = $registros['num_hijos'];
        $this->edad_hijos = $registros['edad_hijos'];
        $this->quien_recomienda = $registros['quien_recomienda'];
        $this->redes_sociales = $registros['redes_sociales'];
        $this->motivo_atencion = $registros['motivo_atencion'];
        $this->calle = $registros['calle'];
        $this->num_interior = $registros['num_interior'];
        $this->num_exterior = $registros['num_exterior'];
        $this->colonia = $registros['colonia'];
        $this->delegacion = $registros['delegacion'];
        $this->cp = $registros['cp'];
        $this->municipio = $registros['municipio'];
        $this->distancia = $registros['distancia'];       
        $this->email = $registros['email'];
        $this->telefono = $registros['telefono'];
        $this->celular = $registros['celular'];
        $this->cuidador = $registros['cuidador'];
        $this->cuidador_telefono = $registros['cuidador_telefono'];
        $this->res_nombre = $registros['res_nombre'];
        $this->res_telefono = $registros['res_telefono'];

    }

    public function getFechaAlta(){
        return $this->fecha_alta;
    }

    public function getNombreCompleto(){
        return $this->nombre_completo;
    }

    public function getEdad(){
        return $this->edad;
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
    
    public function getLugarOrigen(){
        return $this->lugar_origen;
    }

    public function getLugarResidencia(){
        return $this->lugar_residencia;
    }

    public function getOcupacion(){
        return $this->ocupacion;
    }

    public function getNumHijos(){
        return $this->num_hijos;
    }

    public function getEdadHijos(){
        return $this->edad_hijos;
    }

    public function getRecomienda(){
        return $this->quien_recomienda;
    }

    public function getRedesSociales(){
        return $this->redes_sociales;
    }
    public function getMotivoAtencion()
    {
        return $this->motivo_atencion;
    }
    public function getCalle()
    {
        return $this->calle;
    }
    public function getNumInterior()
    {
        return $this->num_interior;
    }

    public function getNumExterior()
    {
        return $this->num_exterior;
    }

    public function getColonia()
    {
        return $this->colonia;
    }

    public function getDelegacion()
    {
        return $this->delegacion;
    }

    public function getCp()
    {
        return $this->cp;
    }
    public function getMunicipio()
    {
        return $this->municipio;
    }

    public function getDistancia()
    {
        return $this->distancia;
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

    public function getCuidador()
    {
        return $this->cuidador;
    }

    public function getCuidadorTelefono()
    {
        return $this->cuidador_telefono;
    }
   
    public function getResNombre()
    {
        return $this->res_nombre;
    }

    public function getResTelefono()
    {
        return $this->res_telefono;
    }
}
<?php
namespace App\Models;
use App\Config\Database;
class ClinicaModel{

    private $bd;
    public function __construct(){
        $this->bd = Database::getInstance();
    }

    public function countPacientes(){

    $stmt = $this->bd->prepare("SELECT COUNT(*) as total FROM pc_paciente");
    $stmt->execute();
    $row = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $row['total'];

    }

    public function insertPaciente($data,$cookie){
        
        $sql = "INSERT INTO pc_paciente (
            id_clinica,
            nombre_completo,
            edad,
            sexo,
            fecha_nacimiento,
            estado_civil,
            curp,
            lugar_origen,    
            lugar_residencia,    
            ocupacion,   
            num_hijos,   
            edad_hijos,  
            medico_tratante, 
            medico_refiere,
            diagnostico_inicial,
            calle,   
            num_interior,    
            num_exterior,  
            colonia, 
            delegacion, 
            cp,  
            municipio,   
            estado,  
            distancia,   
            email,   
            telefono,    
            celular, 
            res_nombre,  
            res_telefono,    
            cuidador,    
            cuidador_telefono,   
            aseguradora, 
            informe_aseguradora, 
            hoja_membretada, 
            formato_aseguradora, 
            honorarios, 
            observaciones,
            motivo_atencion,
            quien_recomienda, 
            redes_sociales,    
            status
        ) VALUES (
            :id_clinica,
            :nombre_completo,
            :edad,
            :sexo,
            :fecha_nacimiento,
            :estado_civil,
            :curp,
            :lugar_origen,    
            :lugar_residencia,    
            :ocupacion,   
            :num_hijos,   
            :edad_hijos,  
            :medico_tratante, 
            :medico_refiere,
            :diagnostico_inicial,
            :calle,   
            :num_interior,    
            :num_exterior,  
            :colonia, 
            :delegacion, 
            :cp,  
            :municipio,   
            :estado,  
            :distancia,   
            :email,   
            :telefono,    
            :celular, 
            :res_nombre,  
            :res_telefono,    
            :cuidador,    
            :cuidador_telefono,   
            :aseguradora, 
            :informe_aseguradora, 
            :hoja_membretada, 
            :formato_aseguradora, 
            :honorarios, 
            :observaciones,
            :motivo_atencion,
            :quien_recomienda,   
            :redes_sociales,   
            :status
        )";

        $stmt = $this->bd->prepare($sql);                    
        
        $datos = [
        ':id_clinica' => $cookie['id_clinica'],
        ':nombre_completo' => $data['NombreCompleto'],
        ':edad' => $data['Edad'],
        ':sexo' => $data['Sexo'],
        ':fecha_nacimiento' => $data['FeNacimiento'],
        ':estado_civil' => $data['EstadoCivil'],
        ':curp' => $data['CURP'],
        ':lugar_origen' => $data['LuOrigen'],    
        ':lugar_residencia' => $data['LuResidencia'],    
        ':ocupacion' => $data['Ocupacion'],   
        ':num_hijos' => $data['NumHijos'],   
        ':edad_hijos' => $data['EdadHijos'],  
        ':medico_tratante' => '', 
        ':medico_refiere' => '',
        ':diagnostico_inicial' => '',
        ':calle' => $data['DACalle'],   
        ':num_interior' => $data['DANI'],    
        ':num_exterior' => $data['DANE'],  
        ':colonia' => $data['DAColonia'], 
        ':delegacion' => $data['DADelegacion'], 
        ':cp' => $data['DACP'],  
        ':municipio' => $data['DAMunicipio'],   
        ':estado' => '',  
        ':distancia' => $data['Distancia'],   
        ':email' => $data['Email'],   
        ':telefono' => $data['Telefono'],    
        ':celular' => $data['Celular'], 
        ':res_nombre' => $data['ResNombre'],  
        ':res_telefono' => $data['ResTelefono'],    
        ':cuidador' => $data['CuiNombre'],    
        ':cuidador_telefono' => $data['CuiTelefono'],   
        ':aseguradora' => '', 
        ':informe_aseguradora' => '', 
        ':hoja_membretada' => '', 
        ':formato_aseguradora' => '', 
        ':honorarios' => '', 
        ':observaciones' => '',
        ':motivo_atencion' => $data['motivoAtencionClinica'],
        ':quien_recomienda' => $data['personaRecomienda'],
        ':redes_sociales' => $data['RedesSociales'],
        ':status' => 1
        ];
    
        if ($stmt->execute($datos)) {
            return array('resultado' => 200,'mensaje' => $this->bd->lastInsertId());

        } else {
            return array('resultado' => 401,'mensaje' => '¡Error al agregar nuevo paciente a la lista!');
        }
        

    }

}
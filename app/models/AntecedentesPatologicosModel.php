<?php
namespace App\Models;
use App\Config\Database;

class AntecedentesPatologicosModel{
private $bd;

public function __construct(){
$this->bd = Database::getInstance();

} 

    //---------- OBTENER DATOS DEL MODULO ----------//
    public function obtenerModulosM5(){
    $stmt = $this->bd->query("SELECT id, tema FROM pac_temas_modulo_5 ORDER BY id ASC");
    $modulos = array();
    while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
    // Se indexa el arreglo por id para facilitar el acceso
    $modulos[$row['id']] = $row['tema'];
    }
    return $modulos;
    }

    //---------- OBTENER DATOS DEL MODULO ----------//
    public function obtenerPreguntasModulos(){
    $stmt = $this->bd->query("SELECT id FROM pac_preguntas_modulo_5 ORDER BY id ASC");
    $idPreguntas = [];
            
    while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
    $idPreguntas[] = $row['id'];
    }
    
    return $idPreguntas;
    }


    //---------- AGREGA PREGUNTAS AL INICIAR ----------//
    public function antecedentesPatologicos($idPaciente, $idPregunta) {
    $sql = "SELECT COUNT(*) FROM pac_respuestas_paciente_modulo_5 WHERE id_paciente = ? AND id_pregunta = ?";
    $stmt = $this->bd->prepare($sql);
    $stmt->execute([$idPaciente, $idPregunta]);
    $numero = $stmt->fetchColumn();
            
    if ($numero == 0) {
    $sql_insert = "INSERT INTO pac_respuestas_paciente_modulo_5 (id_pregunta, id_paciente, respuesta) 
    VALUES (?, ?, '')";
    $stmt_insert = $this->bd->prepare($sql_insert);
    $stmt_insert->execute([$idPregunta, $idPaciente]);
    }
    }


    //---------- OBTENER PREGUNTAS DEL MODULO ----------//
    public function mostrarPreguntasM5V1($idPaciente, $idRol, $idTema){
    $result = '';

    $stmt = $this->bd->query("SELECT 
    pac_respuestas_paciente_modulo_5.id AS idRespuesta, 
    pac_temas_modulo_5.tema,
    pac_preguntas_modulo_5.pregunta, 
    pac_preguntas_modulo_5.tipo, 
    pac_respuestas_paciente_modulo_5.respuesta 
    FROM pac_temas_modulo_5 
    INNER JOIN pac_preguntas_modulo_5 ON pac_preguntas_modulo_5.id_tema = pac_temas_modulo_5.id 
    INNER JOIN pac_respuestas_paciente_modulo_5 ON pac_preguntas_modulo_5.id = pac_respuestas_paciente_modulo_5.id_pregunta 
    WHERE pac_respuestas_paciente_modulo_5.id_paciente = '".$idPaciente."' AND pac_temas_modulo_5.id = '".$idTema."' ORDER BY pac_temas_modulo_5.id ASC");
    $preguntas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
      
    if($idRol == "Paciente"){
    $modulos = $this->obtenerModulosM5();

    if (!empty($preguntas)) {
    $num = 1;
    foreach ($preguntas as $index => $pregunta) :
    $temaModulo = $pregunta['tema'];
    $idRespuesta = $pregunta['idRespuesta'];
    $preguntaPC = $pregunta['pregunta'];
    $respuesta = $pregunta['respuesta'];
    $tipo = $pregunta['tipo'];
    
    // La primera pregunta se muestra activa
    $claseActiva = ($index == 0) ? 'active' : '';      
    $result .= '<div class="pregunta-container '.$claseActiva.'" data-index="'.$index.'" data-id="'.$num.'" data-pregunta="'.$preguntaPC.'" data-rol="'.$idRol.'" data-tema="'.$idTema.'">';
                                    
    $result .= '<h8 class="text-success fw-bold"><b>'.$temaModulo.'</b></h8>';
    $result .= '<div id="seccion'.$idRespuesta.'" data-autoplay="false" class="col-12 col-md-11 d-flex align-items-center sectionQuestion mt-3 mb-1">';
    // $result .= '<img src="'.RUTA_IMAGES.'/iconos/audio.png" class="img-fluid btnLeer pointer" style="max-height: 30px; margin-right: 10px;" data-target="seccion'.$idRespuesta.'">';
    $result .= '<h8 class="text-secondary fw-bold mb-1 texto"><b>'.$preguntaPC.'</b></h8>
    </div>';

        
    // Mostrar el tipo de pregunta (select o input)
    if ($tipo == "select") {
    $result .= '<select class="form-select" onchange="respuestaPreguntaSelect('.$idPaciente.','.$idRespuesta.', this, '.$idTema.', \''.$tipo.'\',\''.$idRol.'\')">
    <option value="" disabled selected>Selecciona una opción...</option>
    <option value="Si" ' . ($respuesta == 'Si' ? 'selected' : '') . '>Sí</option>
    <option value="No" ' . ($respuesta == 'No' ? 'selected' : '') . '>No</option>
    </select>';
    } else {
    $result .= '<input type="text" class="form-control" value="' . ($respuesta == 0 ? '' : $respuesta) . '" placeholder="Ingresa aquí tu respuesta..." onchange="respuestaPreguntaSelect('.$idPaciente.','.$idRespuesta.', this, '.$idTema.', \''.$tipo.'\',\''.$idRol.'\')">';
    }
                    
    //----- Botones de navegación -----
    $result .= '<div class="mt-3 d-flex justify-content-between">';
    // Botón "Anterior"
    if ($index == 0) {
    if($idTema > 1){ 
    // Se obtiene el nombre del módulo anterior desde el array
    $prevNombre = $modulos[$idTema - 1];
    $prevId = $idTema - 1;
    $result .= '<button class="btn btn-success" onclick="anteriorPregunta(' . $idTema . ')"><i data-feather="chevron-left"></i>'.$prevNombre.'</button>';
    } else {
    $result .= '<div></div>';
    }
    } else {
    $result .= '<button class="btn btn-secondary" onclick="anteriorPregunta(' . $idTema . ')"><i data-feather="chevron-left"></i> Anterior</button>';
    }
      
    // Verificar si la respuesta está vacía para preguntas de tipo "select"
    if ($tipo == "select" && empty($respuesta)) {
    // Si la respuesta está vacía, no mostrar los botones "Siguiente" ni "Ir a siguiente sección"
    $result .= '</div>'; // Cierre contenedor de botones
    $result .= '</div>'; // Cierre contenedor de la pregunta
    $num++;
    continue; // Saltar a la siguiente iteración
    }
    
    // Botón "Siguiente" o "Ir a siguiente sección"
    if ($index < count($preguntas) - 1) {
    if($index == 0 && $tipo == "select" && $respuesta == "No"){
    // Botón para ir a la última sección
    if(isset($modulos[$idTema+1])){
    $nextNombre = $modulos[$idTema+1];
    $nextId = $idTema + 1;
    $result .= '<button class="btn btn-success" onclick="irASiguienteSeccion(\''.$nextNombre.'\','.$nextId.')">'.$nextNombre.' <i data-feather="chevron-right"></i></button>';
    } else {
    $result .= '<button class="btn btn-success" onclick="finalizarPreguntas()">Comentarios <i data-feather="message-circle"></i></button>';
    }
    } else {
    // Botón normal para la siguiente pregunta
    $result .= '<button class="btn btn-primary" onclick="siguientePregunta(' . $idTema . ')">Siguiente <i data-feather="chevron-right"></i></button>';
    }
    } else {
    // Al final del módulo, se comprueba si existe un siguiente módulo
    if(isset($modulos[$idTema+1])){
    $nextNombre = $modulos[$idTema+1];
    $nextId = $idTema + 1;
    $result .= '<button class="btn btn-success" onclick="irASiguienteSeccion(\''.$nextNombre.'\','.$nextId.')">'.$nextNombre.' <i data-feather="chevron-right"></i></button>';
    } else {
    $result .= '<button class="btn btn-success" onclick="finalizarPreguntas()">Comentarios <i data-feather="message-circle"></i></button>';
    }
    }

    $result .= '</div>';  // Cierre contenedor de botones
    $result .= '</div>';  // Cierre contenedor de la pregunta
      
    $num++;
    endforeach;
    }

    }else{
    //---------- Apartado del doctor
    $result .= '';
    }

    return $result;
    }


    public function editarCuestionarioDatoV1($idRespuesta,$detalle){

    $sql = "UPDATE pac_respuestas_paciente_modulo_5 SET respuesta = :detalle WHERE id = :id_respuesta";
    $stmt = $this->bd->prepare($sql);                    
                            
    $datos = [
    ':id_respuesta' => $idRespuesta,
    ':detalle' => $detalle
    ];
                        
     if ($stmt->execute($datos)) {
    return array('resultado' => 200,'mensaje' => '¡Se actualizo la respuesta correctamente!');
                        
    } else {
    return array('resultado' => 401,'mensaje' => '¡Error al actualizar la respuesta!');
    }
        
    }
    

    public function editarCuestionarioSelectV1($idPaciente,$idRespuesta,$idTema){

    // Si la respuesta es "NO", actualizamos la respuesta a 'NO' y las demás respuestas a vacío
    $sql1 = "UPDATE pac_respuestas_paciente_modulo_5 SET respuesta = 'No'  WHERE id = :id_respuesta";
    $stmt1 = $this->bd->prepare($sql1);
    $stmt1->bindParam(':id_respuesta', $idRespuesta);
    
    $sql2 = "UPDATE pac_respuestas_paciente_modulo_5 SET respuesta = '' 
    WHERE id_pregunta IN (SELECT id FROM pac_preguntas_modulo_3 WHERE id_tema = :id_tema) AND id_paciente = :id_paciente AND id != :id_respuesta";
    $stmt2 = $this->bd->prepare($sql2);
    $stmt2->bindParam(':id_tema', $idTema);
    $stmt2->bindParam(':id_paciente', $idPaciente);
    $stmt2->bindParam(':id_respuesta', $idRespuesta);
    
    $this->bd->beginTransaction();
    if ($stmt1->execute()) {
    if ($stmt2->execute()) {
    $this->bd->commit(); // Confirmar cambios
    return array('resultado' => 200, 'mensaje' => '¡Respuestas actualizadas exitosamente!');
            
    } else {
    $this->bd->rollback(); // Deshacer cambios
    return array('resultado' => 401, 'mensaje' => '¡Error al actualizar la respuesta en stmt2!');
    }
    
    } else {
    $this->bd->rollback(); // Deshacer cambios
    return array('resultado' => 401, 'mensaje' => '¡Error al actualizar la respuesta en stmt1!');
    }
        
    }

    
    public function editarCuestionarioV1Modulo($data) {
    
    //---------- Verificamos si el tipo es "input" ----------
    if ($data['idTipo'] == 'input') {
    // Llamamos a la función que actualiza el dato y capturamos el resultado
    $resultado = $this->editarCuestionarioDatoV1($data['idRespuesta'], $data['detalle']);   
    return $resultado;
    }
    
    //---------- Verificamos si el tipo es "select" ----------
    if ($data['idTipo'] == 'select') {
    
    if ($data['detalle'] == 'No') {
    $resultado = $this->editarCuestionarioSelectV1($data['idPaciente'],$data['idRespuesta'], $data['idTema']);
    } elseif ($data['detalle'] == 'Si') {
    $resultado = $this->editarCuestionarioDatoV1($data['idRespuesta'], $data['detalle']);
    } else {
    return array('resultado' => 400, 'mensaje' => 'Detalle no válido');
    }
            
    }
        
    return $resultado; 
    }
    
}
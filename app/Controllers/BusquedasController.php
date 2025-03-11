<?php
namespace App\Controllers;

use App\Models\BusquedasModel;

class BusquedasController{

    public function buscarPacientes(){

        $query = $_GET['query'] ?? ''; // Obtén el término de búsqueda
        $model = new BusquedasModel();
        $suggestions = $model->getPacientes($query); // Obtén las sugerencias desde MySQL
        header('Content-Type: application/json');
        echo json_encode($suggestions); // Devuelve las sugerencias en formato JSON

    }
}
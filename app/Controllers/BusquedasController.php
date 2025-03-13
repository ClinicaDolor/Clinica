<?php
namespace App\Controllers;

use App\Models\BusquedasModel;
use App\Models\RecetaModel;

class BusquedasController{

    public function buscarPacientes(){

        $query = $_GET['query'] ?? '';
        $model = new BusquedasModel();
        $suggestions = $model->getPacientes($query);
        header('Content-Type: application/json');
        echo json_encode($suggestions);

    }

    public function buscarReceta($idReceta){
        $model = new RecetaModel();
        echo $model->getReceta($idReceta);

    }
}
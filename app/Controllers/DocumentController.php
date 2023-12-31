<?php
namespace App\Controllers;

use App\Controllers\MainController;
use App\Models\DocumentModel;

class DocumentController extends MainController{




    public function renderDocument(): void
    {
        //  sur la home on à besoin d'afficher 4 articles
        $documentModel = new DocumentModel();
        // on alimente la propriété data de la class parente MainController avec la liste des articles
        $this->data = $documentModel->getDocuments();
        $data=$this->data;
        // var_dump($this->data);
        // on appelle la méthode render du MainController qui construit la page
        $this->render();
    }
}
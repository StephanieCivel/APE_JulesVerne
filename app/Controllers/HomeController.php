<?php

namespace App\Controllers;

use App\Controllers\MainController;
use App\Models\EventModel;

class HomeController extends MainController
{

    public function renderHome(): void
    {
        //  sur la home on à besoin d'afficher 4 articles
        $eventModel = new EventModel();
        // on alimente la propriété data de la class parente MainController avec la liste des articles
        $this->data = $eventModel->getEvents();
        $data=$this->data;
        // var_dump($this->data);
        // on appelle la méthode render du MainController qui construit la page
        $this->render();
    }
}

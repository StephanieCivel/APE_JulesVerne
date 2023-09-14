<?php

namespace App\Controllers;

class ErrorController extends MainController
{
    // le constructeur va se lancer automatiquement,lors de l'appel de ErrorController
    public function renderError(){
        // on modifie la view pour 404
        // on définie le code de réponse http. Ce code sera visible dans l'optin network de la console du navigateur.
        // sans ça, la page demandée renvera status 200
        http_response_code($this->view);
        // on construit la page
        $this->render();
    }

}

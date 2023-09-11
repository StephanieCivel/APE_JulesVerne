<?php

namespace App\Controllers;

use App\Controllers\MainController;
use App\Models\AccountModel;

class AccountController extends MainController
{

    public function renderAccount(): void
    {
        //  sur la home on à besoin d'afficher 4 articles
        $accountModel = new AccountModel();
        // on alimente la propriété data de la class parente MainController avec la liste des articles
        $this->data = $accountModel->getAccounts();
        $data=$this->data;
        // var_dump($this->data);
        // on appelle la méthode render du MainController qui construit la page
        $this->render();
    }
}
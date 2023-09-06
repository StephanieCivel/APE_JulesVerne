<?php

namespace App\Controllers;

use App\Controllers\MainController;
use App\Models\ProductModel;

class OrderController extends MainController
{

    public function renderOrder(): void
    {
        //  sur la home on à besoin d'afficher 4 articles
        $productModel = new ProductModel();
        // on alimente la propriété data de la class parente MainController avec la liste des articles
        $this->data = $productModel->getProducts();
        $data=$this->data;
        // var_dump($this->data);
        // on appelle la méthode render du MainController qui construit la page
        $this->render();
    }
}

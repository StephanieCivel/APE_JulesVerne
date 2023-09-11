<?php
//******CETTE CLASSE NOUS PERMET DE GÉRER L'ADMINISTRATION*******/
namespace App\Controllers;

use App\Controllers\MainController;
use App\Models\DocumentModel;

class DocumentAdminController extends MainController
{
    public function renderDocumentAdmin(): void
    {
        // pour pouvoir accéder à l'admin, il faut avoir le role n°1. L-On lance donc la méthode pour checker le role du user connecté
        //$this->checkUserAuthorization(1);
        // s'il ya un formulaire d'envoyé
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // et si le formulaire est addPostForm
            if (isset($_POST["addDocumentForm"])) {
                //  on lance la méthode d'ajout d'article
                // $this->addPost();
                $this->addDocument();
            
            }
            // si le formulaire est deletePostForm
            if (isset($_POST['deletePostForm'])) {
                //  on lance la méthode de suppression d'article
                $this->removePost();
            }
            // si le formulaire est updatePostForm
            if (isset($_POST['updatePostForm'])) {
                //  on lance la méthode de mise à jour d'article
                $this->updatePost();
            }
        }

        // La vue à rendre est admin. On la passe dans notre propriété viewType du controller parent
        $this->viewType = 'admin';
        // On vérifie si subPage existe
        if (isset($this->subPage)) {
            // si subPage existe, on modifie la propriété viewType du controller parent
            $this->view = $this->subPage;
            // si la view demandée === update
            if ($this->view === 'update') {
                // On doit récupérer l'id de l'article à mettre à jour
                if (isset($_GET['id'])) {
                    // on récupère l'article via son id grâce à la méthode statique getPostById                    
                    $post = DocumentModel::getPostById($_GET['id']);
                    // Si l'article la méthode est l'inverse de true
                    if (!$post) {
                        // on stocke un message d'erreur dans la propriété data du controller parent
                        $this->data['error'] = '<div class="alert alert-danger" role="alert">L\'article n\'existe pas</div>';
                    } else {
                        //sinon on sotcke dans la propriété data du controller parent l'article récupéré
                        $this->data['post'] = $post;
                    }
                }
                // 
            }
        } else {
            // Sinon s'il n'ya pas de sous-page, on stocke dans la propriété data tous les articles pour les afficher dans la vue admin            
            $this->data['documents'] = DocumentModel::getDocuments();
        }

        //  dans tous les cas on appelle la méthode render du controller parent pour construire la page
        $this->render();
    }
    

    //méthode pour ajouter un article
    public function addDocument(): void
    {

         // filter_input est une fonction PHP
        // elle récupère une variable externe d'un champs de formulaire et la filtre
    
        $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
        $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_SPECIAL_CHARS);
        

        // On créé une nouvelle instance de PostModel
        $documentModel = new DocumentModel();
        // puis on utilise les setters pour ajouter les valeurs au propriétés privée du postModel
        
        $documentModel->setType($type);
        $documentModel->setUrl($url);

        // on déclenche l'instertion d'article dans une conditions car PDO va renvoyer true ou false
        if ($documentModel->insertDocument()) {
            // donc si la requête d'insertion s'est bien passée, on renvoie true et on stocke un message de succès dans la propriété data
            $this->data[] = '<div class="alert alert-success" role="alert">Article enregistré avec succès</div>';
        } else {
            // sinon, stocke un message d'erreur
            $this->data[] = '<div class="alert alert-danger" role="alert">Il s\'est produit une erreur</div>';
        }
    }

    // méthode pour mettre à jour un article
    // cette méthode est très similaire à addPost. 
    // On à deux solutions soit faire une seul méthode pour avoir un seul code pour les deux traitements.
    // ou bien justement séparer les traitements pour avoir deux méthodes distinctes quitte à avoir du code similaire
    // j'ai préféré faire ce choix

    public function updateDocument(): void
    {

        $id = filter_input(INPUT_POST, 'documenttid', FILTER_SANITIZE_NUMBER_INT);
        $ag = filter_input(INPUT_POST, 'ag', FILTER_SANITIZE_SPECIAL_CHARS);
        $divers = filter_input(INPUT_POST, 'divers', FILTER_SANITIZE_SPECIAL_CHARS);
        

        $documentModel = new DocumentModel();
        $documentModel->setId($id);
        $documentModel->setType($type);
        $documentModel->setUrl($url);
        
       
 
        if ($documentModel->updateDocument()) {
            $this->data['infos'] = '<div class="alert alert-success" role="alert">Article enregistré avec succès</div>';
        } else {
            $this->data['infos'] = '<div class="alert alert-danger" role="alert">Il s\'est produit une erreur</div>';
        }
    }

    // méthode de suppresion d'un article
    public function removeDocument(): void
    {
        // récupération et filtrage du champs 
        $documentId = filter_input(INPUT_POST, 'documentid', FILTER_SANITIZE_SPECIAL_CHARS);

        if (DocumentModel::deleteDocument($documentId)) {
            $this->data['infos'] = '<div class="alert alert-success d-inline-block mx-4" role="alert">Article supprimé avec succès</div>';
        } else {
            $this->data['infos'] = '<div class="alert alert-danger" role="alert">Il s\'est produit une erreur</div>';
        }
    }
}

<?php
//******CETTE CLASSE NOUS PERMET DE GÉRER L'ADMINISTRATION*******/
namespace App\Controllers;

use App\Controllers\MainController;
use App\Models\EventModel;

class AdminController extends MainController
{
    public function renderAdmin(): void
    {
        // La vue à rendre est admin. On la passe dans notre propriété viewType du controller parent
        $this->viewType = 'admin';
        $this->authUser(1);
        // pour pouvoir accéder à l'admin, il faut avoir le role n°1. L-On lance donc la méthode pour checker le role du user connecté
        //$this->checkUserAuthorization(1);
        // s'il ya un formulaire d'envoyé
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // et si le formulaire est addPostForm
            if (isset($_POST["addEvent"])) {
                //  on lance la méthode d'ajout d'article
                $this->addEvent();
            }
            // si le formulaire est deletePostForm
            // Si le formulaire est deleteEvent
        if (isset($_POST['deleteEvent'])) {
            // On lance la méthode de suppression d'événement
            $this->removeEvent();
            }
            // si le formulaire est updatePostForm
            if (isset($_POST['editEvent'])) {
                //  on lance la méthode de mise à jour d'article
                $this->updateEvent();
            }
            
        
            
        }
       

        
        // On vérifie si subPage existe
        if (isset($this->subPage)) {
            // si subPage existe, on modifie la propriété viewType du controller parent
            $this->view = $this->subPage;
            // si la view demandée === update
            if ($this->view === 'eventEdit') {
                // On doit récupérer l'id de l'article à mettre à jour
                if (isset($_GET['id'])) {
                    // on récupère l'article via son id grâce à la méthode statique getPostById                    
                    $event = EventModel::getPostById($_GET['id']);
                    // Si l'article la méthode est l'inverse de true
                    if (!$event) {
                        // on stocke un message d'erreur dans la propriété data du controller parent
                        $this->data['error'] = '<div class="alert alert-danger" role="alert">L\'article n\'existe pas</div>';
                    } else {
                        //sinon on stocke dans la propriété data du controller parent l'article récupéré
                        $this->data['event'] = $event;
                    }
                }
                // 
            }
        } else {
            // Sinon s'il n'ya pas de sous-page, on stocke dans la propriété data tous les articles pour les afficher dans la vue admin            
            $this->data['events'] = EventModel::getEvents();
        }

        //  dans tous les cas on appelle la méthode render du controller parent pour construire la page
        $this->render();
    }

    //méthode pour ajouter un article
    public function addEvent(): void
    {

         // filter_input est une fonction PHP
        // elle récupère une variable externe d'un champs de formulaire et la filtre
        $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $adress = filter_input(INPUT_POST, 'adress', FILTER_SANITIZE_SPECIAL_CHARS);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
        $voluntary_link = filter_input(INPUT_POST, 'volontary_link', FILTER_SANITIZE_SPECIAL_CHARS);

        // On créé une nouvelle instance de PostModel
        $eventModel = new EventModel();
        // puis on utilise les setters pour ajouter les valeurs au propriétés privée du postModel
        $eventModel->setDate($date);
        $eventModel->setName($name);
        $eventModel->setAdress($adress);
        $eventModel->setDescription($description);
        $eventModel->setVolontary_link($voluntary_link);

        // on déclenche l'instertion d'article dans une conditions car PDO va renvoyer true ou false
        if ($eventModel->insertEvent()) {
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

    public function updateEvent(): void
    {

        $id = filter_input(INPUT_POST, 'eventid', FILTER_SANITIZE_NUMBER_INT);
        $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $adress = filter_input(INPUT_POST, 'adress', FILTER_SANITIZE_SPECIAL_CHARS);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
        $voluntary_link = filter_input(INPUT_POST, 'volontary_link', FILTER_SANITIZE_SPECIAL_CHARS);
        

        $eventModel = new EventModel();
        $eventModel->setId($id);
        $eventModel->setDate($date);
        $eventModel->setName($name);
        $eventModel->setAdress($adress);
        $eventModel->setDescription($description);
        $eventModel->setVolontary_link($voluntary_link);
       
 
        if ($eventModel->updateEvent()) {
            $this->data['infos'] = '<div class="alert alert-success" role="alert">Article enregistré avec succès</div>';
        } else {
            $this->data['infos'] = '<div class="alert alert-danger" role="alert">Il s\'est produit une erreur</div>';
        }
    }

    // Méthode pour supprimer un événement
public function removeEvent(): void
{
    // Récupération et filtrage de l'ID de l'événement à supprimer
    $eventId = filter_input(INPUT_POST, 'eventid', FILTER_SANITIZE_SPECIAL_CHARS);

    // Appel à la méthode de modèle pour supprimer l'événement
    if (EventModel::deleteEvent($eventId)) {
        // Suppression réussie, vous pouvez afficher un message de succès ou rediriger l'utilisateur
        // vers une autre page si nécessaire.
        $this->data['infos'] = '<div class="alert alert-success" role="alert">Événement supprimé avec succès</div>';
    } else {
        // Erreur lors de la suppression
        $this->data['infos'] = '<div class="alert alert-danger" role="alert">Une erreur s\'est produite lors de la suppression</div>';
    }
}
}

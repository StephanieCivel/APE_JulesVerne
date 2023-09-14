<?php 
namespace App\Controllers;
use App\Models\ContactModel;

class ContactController extends MainController{
 public function renderContact(): void
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST["contactForm"])) {
                $this->contact();
            } 
        }
        $this->render();
    }
public function contact()
    {
        $errors = [];
        //filter input permet de faire le if isset sans faire pleins de conditions
        $name = filter_input(INPUT_POST, 'name',FILTER_SANITIZE_SPECIAL_CHARS);
        $first_name = filter_input(INPUT_POST, 'first_name',FILTER_SANITIZE_SPECIAL_CHARS);
        $student_id = filter_input(INPUT_POST, 'student_id',FILTER_SANITIZE_SPECIAL_CHARS);
        $classroom = filter_input(INPUT_POST, 'classroom',FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email',FILTER_SANITIZE_EMAIL);
        $message = filter_input(INPUT_POST, 'message',FILTER_SANITIZE_SPECIAL_CHARS);
        
        // Si un champs vaut false, on ajoute une erreur dans le tableau errors
        if (!$name || !$first_name || !$student_id || !$classroom || !$email || !$message)  {
            $errors = 1;
            $this->data[] = '<div class="alert alert-danger" role="alert">Tous les champs sont obligatoires</div>';
        }
        // filter_var permet de vérifier si la valeur correspond bien au pattern attendu par se champs
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        if ($email === false) {            
            $errors[] = '<div class="alert alert-danger" role="alert">Le format de l\'email n\'est pas valide.</div>';
        }
        if (strlen($message) > 1000) {
            $errors[] = '<div class="alert alert-danger" role="alert">Le message ne doit pas contenir plus de 1000 caractères.</div>';
        }
        if(!empty($errors)){   
            $this->data['errors'] = $errors;       
        }else{            
            // Création de l'objet contact
            $contact = new ContactModel();            
            // Remplissage des propriétés via les setters
            $contact->setName($name);
            $contact->setName($first_name);
            $contact->setName($student_id);
            $contact->setName($classroom);
            $contact->setEmail($email);
            $contact->setMessage($message);
            }
            if(empty($errors)){
                if($contact->Contact()){                   
                    $this->data['success'] =  '<div class="alert alert-success" role="alert">Enregistrement réussi</div>';                
                }else{
                    $this->data['errors'] = '<div class="alert alert-danger" role="alert">Il y a eu une erreur lors de l\enregistrement</div>';
                } 
            }                    
        }
    } 
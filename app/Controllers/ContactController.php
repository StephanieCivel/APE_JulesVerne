<?php 
namespace App\Controllers;
//++
//use App\Controllers\MainController;
require 'MainController.php';


use App\Models\ContactModel;


class ContactController extends MainController{
    public function renderContact(): void
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST["myFormulaire"])) {
                $this->addContact();
        } 
        
    }
        $this->render();
    }
    public static function addContact()
    {
        $errors = [];

        // Utilisation de filter_input pour obtenir les valeurs des champs du formulaire
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $student_id = filter_input(INPUT_POST, 'student', FILTER_SANITIZE_SPECIAL_CHARS); // Utilisation de 'student' au lieu de 'student_id'
        $classroom = filter_input(INPUT_POST, 'classroom', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

        // Vérifications des champs
        if (!$name || !$first_name || !$student_id || !$classroom || !$email || !$message) {
            $errors[] = '<div class="alert alert-danger" role="alert">Tous les champs sont obligatoires</div>';
        }

        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        if ($email === false) {
            $errors[] = '<div class="alert alert-danger" role="alert">Le format de l\'email n\'est pas valide.</div>';
        }

        if (strlen($message) > 1000) {
            $errors[] = '<div class="alert alert-danger" role="alert">Le message ne doit pas contenir plus de 1000 caractères.</div>';
        }

        if (!empty($errors)) {
         $this->data['errors'] = $errors;
        } else {
            
            $contact = new ContactModel();
            $contact->setName($name);
            $contact->setFirstName($first_name); // Utilisation de setFirstName au lieu de setName
            $contact->setStudentName($student_id); // Utilisation de setStudentName au lieu de setName
            $contact->setClassroom($classroom);
            $contact->setEmail($email);
            $contact->setMessage($message);

            if ($contact->contact()) {
                $this->data['success'] = '<div class="alert alert-success" role="alert">Enregistrement réussi</div>';
            } else {
                $this->data['errors'] = '<div class="alert alert-danger" role="alert">Il y a eu une erreur lors de l\'enregistrement</div>';
            }
        }
    }

} 
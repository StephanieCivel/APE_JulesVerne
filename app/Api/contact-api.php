<?php
// contact-api.php

// Vous devez inclure le fichier ContactController.php pour l'utiliser.
include '../Controllers/ContactController.php';
// Créez une instance de la classe ContactController.
$contactController = new ContactController();

// Récupérez les données du formulaire en utilisant filter_input.

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS);
$student_id = filter_input(INPUT_POST, 'student_id', FILTER_SANITIZE_SPECIAL_CHARS); // Utilisation de 'student_id' au lieu de 'student'
$classroom = filter_input(INPUT_POST, 'classroom', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

// Assurez-vous de définir la variable $response avant de l'utiliser dans la condition.
$response = $contactController->addContact();

if ($response == true) {
    // Envoyer une réponse JSON au client
header('Content-Type: application/json');
    echo json_encode('true'); // Utilisez true sans les guillemets pour indiquer une valeur booléenne.
}

?>
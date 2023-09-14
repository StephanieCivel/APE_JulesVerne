<?php
namespace App\Models;
use App\Utility\DataBase;
use \PDO;

// Ce modèle est la représentation "code" de notre table posts
// elle aura donc autant de propriétés qu'il y'a de champs dans la table
// ça nous permettra de manipuler des objets identiques à une entrée de bdd grâce à PDO::FETCH_CLASS
class ContactModel
{
    private $id;
    private $name;
    private $first_name;
    private $student_id;
    private $classroom;
    private $email;
    private $message;
   

    // méthode pour enregistrer un Contact en bdd
    public function contact(): bool
    {

        $pdo = DataBase::connectPDO();

        // création requête avec liaison de param pour éviter les injections sq
        $sql = "INSERT INTO `contact`(`name`, `first_name`, `student_id`, `classroom`, `email`,`message`,`rgpdChecked`) VALUES (:name,:first_name,:student_id,:classroom,:email,:message,:rgpdChecked)";
        // préparation de la requête
        $pdoStatement = $pdo->prepare($sql);
        // liaison des params avec leur valeurs. tableau à passer dans execute
        $params = [
            ':name' => $this->name,
            ':first_name' =>  $this-> first_name,
            ':student_id' =>  $this-> student_id,
            ':classroom' =>  $this-> classroom,
            ':email' => $this->email,
            ':message' => $this->message,
            
        ];
        // récupération de l'état de la requête (renvoie true ou false)
        $queryStatus = $pdoStatement->execute($params);
        var_dump($queryStatus);
        // on retourne le status
        return $queryStatus;
        
    }
    
    public function getMessages(){
    $pdo = DataBase::connectPDO();
    
    $sql = "SELECT * FROM contact";

        $query = $pdo->prepare($sql);
        $query->execute();
        $messages = $query->fetchAll(PDO::FETCH_CLASS,'App\Models\ContactModel');
        return $messages;
}

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

     /**
     * Get the value of name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

   

    /**
     * Get the value of firstName
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    
    /**
     * Set the value of firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }
    
   
    
         /**
     * Get the value of student
     */
    public function getStudentName(): string
    {
        return $this->student_name;
    }

    /**
     * Set the value of student
     */
    public function setStudentName(string $student_id): void
    {
        $this->student_id = $student_id;
    }
    
    
    
    /**
     * Get the value of classroom
     */
    public function getClassroom(): string
    {
        return $this->classroom;
    }

    /**
     * Set the value of classroom
     */
    public function setClassroom(string $classroom): void
    {
        $this->classroom = $classroom;
    }
    
   
    /**
     *  Get the value of Email
     */
    public function getEmail(): string
    {
        return $this->email;
    }
    
     /**
     * Set the value of Email
     */
    public function setEmail(string $email) {
        $this->email = $email;
    }
    
     /**
     *  Get the value of Message
     */
    public function getMessage(): string
    {
        return $this->message;
    }
    
     /**
     * Set the value of Message
     */
    public function setMessage(string $message) {
        $this->message = $message;
    }
    
}
<?php
// On spécifie dans quel namespace se trouve ce modèle
namespace App\Models;

// on spécifie les namespaces requis dans notre code
use App\Utility\DataBase;


// Ce modèle est la représentation "code" de notre table posts
// elle aura donc autant de propriétés qu'il y'a de champs dans la table
// ça nous permettra de manipuler des objets identiques à une entrée de bdd grâce à PDO::FETCH_CLASS
class UserModel
{
    private $id;
    private $name;
    private $first_name;
    private $student_id;
    private $classroom;
    private $tel;
    private $email;
    private $password;
    private $role;
    private $rgpdChecked;
    

    // méthode pour enregistrer un user en bdd
    public function registerUser(): bool
    {

        // connexion pdo
        $pdo = DataBase::connectPDO();

        // création requête avec liaison de param pour éviter les injections sq
        $sql = "INSERT INTO `contact`(`name`, `first_name`, `student_id`, `classroom`, `tel`, `email`, `password`,`rgpdChecked`, `role`) VALUES (:name,:first_name,:student_id,:classroom,:tel,:email,:password,:rgpdChecked,:role)";
        // préparation de la requête
        $pdoStatement = $pdo->prepare($sql);
        // liaison des params avec leur valeurs. tableau à passer dans execute
        $params = [
            ':name' => $this->name,
            ':first_name' =>  $this-> first_name,
            ':student_id' =>  $this-> student_id,
            ':classroom' =>  $this-> classroom,
            ':tel' =>  $this-> tel,
            ':email' => $this->email,
            ':password' => $this->password,
            ':rgpdChecked' => $this ->rgpdChecked,
            // par défaut on force le role à 2 qui est le plus faible
            ':role' => 2,
        ];
        // récupération de l'état de la requête (renvoie true ou false)
        $queryStatus = $pdoStatement->execute($params);

        // on retourne le status
        return $queryStatus;
    }

    // méthode pour vérifier si un email est déjà pris
    public function checkEmail()
    {
        // connexion pdo
        $pdo = DataBase::connectPDO();

        // création requête avec liaison de param pour éviter les injections sq
        $sql = "SELECT COUNT(*) FROM `users` WHERE `email` = :email";
        // préparation de la requête
        $query = $pdo->prepare($sql);
        // pas besoin de faire un tableau, il n'ya qu'un seule entrée, on peut utiliser bindParam        
        $query->bindParam(':email', $this->email);
        // execution de la requete
        $query->execute();
        // on stock le retour. fetchColumn renvoie le nombre d'éléments trouvé
        $isMail = $query->fetchColumn();

        // donc l'instruction $isMail > 0 donnera true s'il y'a déjà l'email présent
        return $isMail > 0;
    }

    // récupérer un utilisateur via son email
    public static function getUserByEmail($email): ?UserModel
    {

        // connexion pdo
        $pdo = DataBase::connectPDO();

        // requête SQL
        $sql = '
        SELECT * 
        FROM users
        WHERE email = :email';
        $pdoStatement = $pdo->prepare($sql);
        // on exécute la requête en donnant à PDO la valeur à utiliser pour remplacer ':email'
        $pdoStatement->execute([':email' => $email]);
        // on récupère le résultat sous la forme d'un objet de la classe AppUser
        $result = $pdoStatement->fetchObject('App\Models\UserModel');

        // on renvoie le résultat
        return $result;
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
    public function getName(): ?string
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
    public function getStudentName(): int
    {
        return $this->student_id;
    }

    /**
     * Set the value of student
     */
    public function setStudentName(int $student_id): void
    {
        $this->student_id = $student_id;
    }
    
         /**
     * Get the value of student
     */
    public function getStudentName(): string
    {
        return $this->student_name;
    }
    
    /**
     * Get the value of student
     */
    public function getClassroom(): int
    {
        return $this->classroom;
    }

    /**
     * Set the value of student
     */
    public function setClassroom(int $classroom): void
    {
        $this->classroom = $classroom;
    }
    
         /**
     * Get the value of student
     */
    public function getClassroom(): string
    {
        return $this->classroom;
    }
    
     /**
     *  Get the value of Tel
     */
    public function getTel() {
        return $this->tel;
    }
    
     /**
     * Set the value of Tel
     */
    public function setTel($tel) {
        $this->tel = $tel;
    }
    
    /**
     *  Get the value of Email
     */
    public function getEmail() {
        return $this->email;
    }
    
     /**
     * Set the value of Email
     */
    public function setEmail($email) {
        $this->email = $email;
    }
    
     /**
     *  Get the value of Password
     */
    public function getPassword() {
        return $this->password;
    }
    
     /**
     * Set the value of Password
     */
    public function setPassword($password) {
        $this->password = $password;
    }
    
     /**
     *  Get the value of RgpdChecked
     */
    public function getRgpdChecked($rgpdChecked) {
        $this->rgpdChecked = $rgpdChecked;
    }
    
    /**
     * Set the value of Role
     */
    public function setRgpdChecked($role) {
        $this->password = $role;
    }
    
     /**
     *  Get the value of RgpdChecked
     */
    public function getRgpdChecked($role) {
        $this->role = $role;
    }
    
}
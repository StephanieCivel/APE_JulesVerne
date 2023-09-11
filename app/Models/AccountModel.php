<?php
// On spécifie dans quel namespace se trouve ce modèle
namespace App\Models;

// on spécifie les namespaces requis dans notre code
use App\Utility\DataBase;


// Ce modèle est la représentation "code" de notre table posts
// elle aura donc autant de propriétés qu'il y'a de champs dans la table
// ça nous permettra de manipuler des objets identiques à une entrée de bdd grâce à PDO::FETCH_CLASS
class AccountModel
{
    private $id;
    private $name;
    private $first_name;
    private $student_id;
    private $tel;
    private $email;
    private $password;
    private $role;
    
    
    // méthode pour récupérer tous les articles, il est possible de spécifier une limite
    public static function getUsers(): array
    {
        // connexion pdo avec le pattern singleton
        $pdo = DataBase::connectPDO();
      

        // On prépare la requete
        $query = $pdo->prepare('SELECT user.*, student.name AS student_name FROM user INNER JOIN student ON student_id = student.id');


        $query->execute();
        // on fetchAll avec l'option FETCH_CLASS afin d'obtenir un tableau d'objet de type PostModel. 
        // On pourra ensuite manipuler les propriétés grâce au getters / setters
        // ne pas oublier de spécifier le namespace App\Models\PostModel !
        $users = $query->fetchAll(PDO::FETCH_CLASS, 'App\Models\AccountModel');
        return $users;
    }


    // récupération d'un article via son id
    // : ?PostModel est le typage de retour de la fonction. Ça signifie quelle peut retourner 
    // soit un objet de type PostModel, soit null
    public static function getPostById(int $id): ?AccountModel
    {
        // connection pdo
        $pdo = DataBase::connectPDO();
        // impératif, :id permet d'éviter les injections SQL
        $query = $pdo->prepare('SELECT * FROM posts WHERE id=:id');
        // Comme il n'y a qu'un seul param, pas besoin de faire un tableau, on peut utiliser bindParam
        $query->bindParam(':id', $id);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_CLASS, 'App\Models\AccountModel');
        // fetch et non fetchAll car on récupère une seule entrée
        $post = $query->fetch();
        return $User;
    }

    // Si on souhaite éviter la duplication de code des méthodes insert et update qui son très similaires
    // on peut regrouper les parties communes dans une méthode
    // ça complexifie le code et sa lecture, est-ce vraiment nécéssaire ?

    // private function executeQuery($sql, $params)
    // {
    //     $pdo = DataBase::connectPDO();
    //     $user_id = $_SESSION['userObject']->getId();

    //     $params['user_id'] = $user_id;        
    //     $query = $pdo->prepare($sql);
    //     $queryStatus = $query->execute($params);
    //     return $queryStatus;
    // }

    public function insertProduct(): bool
    {
        $pdo = DataBase::connectPDO();
        // récupération de l'id de l'utilisateur via la superglobale $_SESSION
        $user_id = $_SESSION['userObject']->getId();
        // requête sql protégée des injections sql 
        $sql = "INSERT INTO `user`(`name`, `first_name`, `student_id`, `tel`,`email`, `password`, `role`) VALUES (:name, :first_name, :student_id, :tel, :email, :password, :role)";
        // associations des bonnes valeurs
        $params = [
            'name' => $this->name,
            'first_name' => $this->first_name,
            'student_id' => $this->student_id,
            'tel' => $this->tel,
            'email' => $this->email,
            'password' => $this->password,
            'role' => $this->role,
            
        ];
        $query = $pdo->prepare($sql);
        // execution de la méthode en passant le tableau de params
        $queryStatus = $query->execute($params);
        return $queryStatus;
    }

    public function updateUser(): bool
    {
        $pdo = DataBase::connectPDO();
        // récupération de l'id de l'utilisateur via la superglobale $_SESSION
        $user_id = $_SESSION['userObject']->getId();
        // requête sql protégée des injections sql 
        $sql = "UPDATE `users` SET `name`= :name, `first_name` = first_name, `student_id` = student_id, `tel` = tel, `email` = email, `password` = password, `role` = role, id` = :id";
        // associations des bonnes valeurs
        $params = [
            'name' => $this->name,
            'first_name' => $this->first_name,
            'student_id' => $this->student_id,
            'tel' => $this->tel,
            'email' => $this->email,
            'password' => $this->password,
            'role' => $this->role,
        ];
        $query = $pdo->prepare($sql);
        // execution de la méthode en passant le tableau de params
        $queryStatus = $query->execute($params);
        return $queryStatus;
    }

    public static function deleteProduct(int $productId): bool
    {
        $pdo = DataBase::connectPDO();
        $sql = 'DELETE FROM `users` WHERE id = :id';
        $query = $pdo->prepare($sql);
        $query->bindParam('id', $productId, PDO::PARAM_INT);
        $queryStatus = $query->execute();
        return $queryStatus;
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
     * Get the value of tel
     */
    public function getTel(): float
    {
        return $this->tel;
    }

    /**
     * Set the value of tel
     */
    public function setTel(int $tel): void
    {
        $this->tel = $tel;
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
     * Get the value of email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Get the value of password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Get the value of role
     */
    public function getRole(): int
    {
        return $this->role;
    }

    /**
     * Set the value of role
     */
    public function setRole(int $role): void
    {
        $this->role = $role;
    }
}

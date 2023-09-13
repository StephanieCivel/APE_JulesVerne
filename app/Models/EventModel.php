<?php
namespace App\Models;

use App\Utility\DataBase;
use \PDO;

class EventModel{
    //a modifier
    private $id;
    private $date;
    private $name;
    private $adress;
    private $description;
    private $volontary_link;
   
 // méthode pour récupérer tous les articles, il est possible de spécifier une limite
    public static function getEvents(): array
    {
        // connexion pdo avec le pattern singleton
        $pdo = DataBase::connectPDO();
      

        // On prépare la requete
        $query = $pdo->prepare('SELECT *  FROM event');


        $query->execute();
        // on fetchAll avec l'option FETCH_CLASS afin d'obtenir un tableau d'objet de type PostModel. 
        // On pourra ensuite manipuler les propriétés grâce au getters / setters
        // ne pas oublier de spécifier le namespace App\Models\PostModel !
        $events = $query->fetchAll(PDO::FETCH_CLASS, 'App\Models\EventModel');
        return $events;
    }

    // récupération d'un article via son id
    // : ?PostModel est le typage de retour de la fonction. Ça signifie quelle peut retourner 
    // soit un objet de type PostModel, soit null
    public static function getPostById(int $id): ?EventModel
    {
        // connection pdo
        $pdo = DataBase::connectPDO();
        // impératif, :id permet d'éviter les injections SQL
        $query = $pdo->prepare('SELECT * FROM event WHERE id=:id');
        // Comme il n'y a qu'un seul param, pas besoin de faire un tableau, on peut utiliser bindParam
        $query->bindParam(':id', $id);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_CLASS, 'App\Models\EventModel');
        // fetch et non fetchAll car on récupère une seule entrée
        $event = $query->fetch();
   
        return $event;
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

    public function insertEvent(): bool
    {
        $pdo = DataBase::connectPDO();
        // requête sql protégée des injections sql 
        $sql = "INSERT INTO `event`(`date`, `name`, `adress`, `description`, `volontary_link`) VALUES (:date, :name, :adress, :description, :volontary_link)";
        // associations des bonnes valeurs
        $params = [
            'date' => $this->date,
            'name' => $this->name,
            'adress' => $this->adress,
            'description' => $this->description,
            'volontary_link' => $this->volontary_link,
        ];
        $query = $pdo->prepare($sql);
        // execution de la méthode en passant le tableau de params
        $queryStatus = $query->execute($params);
        return $queryStatus;
    }

    public function updateEvent(): bool
    {
        var_dump('prgkzpoekg');
        $pdo = DataBase::connectPDO();
        // requête sql protégée des injections sql 
        $sql = "UPDATE `event` SET `date` = :date, `name` = :name, `adress` = :adress,`description` = :description, `volontary_link` = :volontary_link WHERE `id` = :id";
        // associations des bonnes valeurs
        $params = [
            'id' => $this->id,
            'date' => $this->date,
            'name' => $this->name,
            'adress' => $this->adress,
            'description' => $this->description,
            'volontary_link' => $this->volontary_link,
        ];
        $query = $pdo->prepare($sql);
        // execution de la méthode en passant le tableau de params
        $queryStatus = $query->execute($params);
        return $queryStatus;
    }

    public static function deleteEvent(int $eventId): bool
    {
        $pdo = DataBase::connectPDO();
        $sql = 'DELETE FROM `event` WHERE id = :id';
        $query = $pdo->prepare($sql);
        $query->bindParam('id', $eventId, PDO::PARAM_INT);
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
     * Get the value of date
     */
    public function getDate(): string
    {
        return $this->date;
    }

  

    /**
     * Set the value of date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
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
     * Get the value of adress
     */
    public function getAdress(): string
    {
        return $this->adress;
    }

    /**
     * Set the value of adress
     */
    public function setAdress(string $adress): void
    {
        $this->adress = $adress;
    }

   

    /**
     * Get the value of description
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Get the value of voluntary_link
     */
    public function getVolontary_link(): ?string
    {
        return $this->volontary_link;
    }

    /**
     * Set the value of voluntary_link
     */
    public function setVolontary_link(string $volontary_link): void
    {
        $this->volontary_link = $volontary_link;
    }
}

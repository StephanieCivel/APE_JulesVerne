<?php
namespace App\Models;

use App\Utility\DataBase;
use \PDO;

class DocumentModel{
    //a modifier
    private $id;
    private $type;
    private $url;
    
   
 // méthode pour récupérer tous les articles, il est possible de spécifier une limite
    public static function getDocuments(): array
    {
        // connexion pdo avec le pattern singleton
        $pdo = DataBase::connectPDO();
      

        // On prépare la requete
        $query = $pdo->prepare('SELECT * FROM document');


        $query->execute();
        // on fetchAll avec l'option FETCH_CLASS afin d'obtenir un tableau d'objet de type PostModel. 
        // On pourra ensuite manipuler les propriétés grâce au getters / setters
        // ne pas oublier de spécifier le namespace App\Models\PostModel !
        $documents = $query->fetchAll(PDO::FETCH_CLASS, 'App\Models\DocumentModel');
        return $documents;
    }

    // récupération d'un article via son id
    // : ?PostModel est le typage de retour de la fonction. Ça signifie quelle peut retourner 
    // soit un objet de type PostModel, soit null
    public static function getPostById(int $id): ?DocumentModel
    {
        // connection pdo
        $pdo = DataBase::connectPDO();
        // impératif, :id permet d'éviter les injections SQL
        $query = $pdo->prepare('SELECT * FROM documents WHERE id=:id');
        // Comme il n'y a qu'un seul param, pas besoin de faire un tableau, on peut utiliser bindParam
        $query->bindParam(':id', $id);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_CLASS, 'App\Models\DocumentModel');
        // fetch et non fetchAll car on récupère une seule entrée
        $post = $query->fetch();
        return $Event;
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

    public function insertDocument(): bool
    {
        $pdo = DataBase::connectPDO();
        // récupération de l'id de l'utilisateur via la superglobale $_SESSION
       // $user_id = $_SESSION['userObject']->getId();
        // requête sql protégée des injections sql 
        $sql = "INSERT INTO `document`(`type`, `url`) VALUES (:type, :url)";
        // associations des bonnes valeurs
        $params = [
            'type' => $this->type,
            'url' => $this->url,
            
        ];
        $query = $pdo->prepare($sql);
        // execution de la méthode en passant le tableau de params
        $queryStatus = $query->execute($params);
        return $queryStatus;
    }

    public function updateDocument(): bool
    {
        $pdo = DataBase::connectPDO();
        // récupération de l'id de l'utilisateur via la superglobale $_SESSION
        $user_id = $_SESSION['userObject']->getId();
        // requête sql protégée des injections sql 
        $sql = "UPDATE `documents` SET `ag` = :ag, `divers`= :divers, `id` = :id";
        // associations des bonnes valeurs
        $params = [
            'ag' => $this->ag,
            'divers' => $this->divers,
        ];
        $query = $pdo->prepare($sql);
        // execution de la méthode en passant le tableau de params
        $queryStatus = $query->execute($params);
        return $queryStatus;
    }

    public static function deleteDocument(int $documentId): bool
    {
        $pdo = DataBase::connectPDO();
        $sql = 'DELETE FROM `documents` WHERE id = :id';
        $query = $pdo->prepare($sql);
        $query->bindParam('id', $documentId, PDO::PARAM_INT);
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
     * Get the value of ag
     */
    public function getType(): string
    {
        return $this->type;
    }

  

    /**
     * Set the value of ag
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * Get the value of divers
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * Set the value of divers
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

   
}




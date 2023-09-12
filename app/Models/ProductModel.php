<?php
namespace App\Models;

use App\Utility\DataBase;
use \PDO;

class ProductModel{
    //a modifier
    private $id;
    private $name;
    private $description;
    private $price;
    private $img_id;
    private $img_url;
   
 // méthode pour récupérer tous les articles, il est possible de spécifier une limite
    public static function getProducts(): array
    {
        // connexion pdo avec le pattern singleton
        $pdo = DataBase::connectPDO();
      

        // On prépare la requete
        $query = $pdo->prepare('SELECT product.*, img.url AS img_url FROM product INNER JOIN img ON img_id = img.id');


        $query->execute();
        // on fetchAll avec l'option FETCH_CLASS afin d'obtenir un tableau d'objet de type PostModel. 
        // On pourra ensuite manipuler les propriétés grâce au getters / setters
        // ne pas oublier de spécifier le namespace App\Models\PostModel !
        $product = $query->fetchAll(PDO::FETCH_CLASS, 'App\Models\ProductModel');
        return $product;
    }

    // récupération d'un article via son id
    // : ?PostModel est le typage de retour de la fonction. Ça signifie quelle peut retourner 
    // soit un objet de type PostModel, soit null
    public static function getPostById(int $id): ?ProductModel
    {
        // connection pdo
        $pdo = DataBase::connectPDO();
        // impératif, :id permet d'éviter les injections SQL
        $query = $pdo->prepare('SELECT * FROM posts WHERE id=:id');
        // Comme il n'y a qu'un seul param, pas besoin de faire un tableau, on peut utiliser bindParam
        $query->bindParam(':id', $id);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_CLASS, 'App\Models\ProductModel');
        // fetch et non fetchAll car on récupère une seule entrée
        $post = $query->fetch();
        return $Product;
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
        $sql = "INSERT INTO `product`(`name`, `description`, `price`, `img_id`) VALUES (:name, :description, :price, :img_id)";
        // associations des bonnes valeurs
        $params = [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'img_id' => $this->img_id,
            
        ];
        $query = $pdo->prepare($sql);
        // execution de la méthode en passant le tableau de params
        $queryStatus = $query->execute($params);
        return $queryStatus;
    }

    public function updateProduct(): bool
    {
        $pdo = DataBase::connectPDO();
        // récupération de l'id de l'utilisateur via la superglobale $_SESSION
        $product_id = $_SESSION['product']->getId();
        // requête sql protégée des injections sql 
        $sql = "UPDATE `products` SET `id` = :id, `name`= :name, `description` = :description, `price` = :price, `img_id` = :img, id` = :id";
        // associations des bonnes valeurs
        $params = [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'img_id' => $this->img_id,
        ];
        $query = $pdo->prepare($sql);
        // execution de la méthode en passant le tableau de params
        $queryStatus = $query->execute($params);
        return $queryStatus;
    }

    public static function deleteProduct(int $productId): bool
    {
        $pdo = DataBase::connectPDO();
        $sql = 'DELETE FROM `products` WHERE id = :id';
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
     * Get the value of description
     */
    public function getDescription(): string
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
     * Get the value of price
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Set the value of price
     */
    public function setPrice(string $price): void
    {
        $this->price = $price;
    }
    
     /**
     * Get the value of img
     */
    public function getImgId(): string
    {
        return $this->img_id;
    }
    


    /**
     * Set the value of img
     */
    public function setImg(string $img_id): void
    {
        $this->img_id = $img_id;
    }
    
         /**
     * Get the value of img
     */
    public function getImgUrl(): string
    {
        return $this->img_url;
    }
}
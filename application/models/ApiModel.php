<?php
namespace application\models;
use PDO;

class ApiModel extends Model {
    public function getCategoryList() {
        $sql = "SELECT * FROM t_category";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function productInsert() {
        $sql = "INSERT INTO t_prodcut
                SET product_name = :product_name,
                    product_price = :product_price,
                    delivery_price = :delivery_price,
                    add_delivery_price = :add_delivery_price,
                    tags = :tags,
                    outbound_days = :outbound_days,
                    seller_id = :seller_id,
                    category_id = :category_id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue();
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
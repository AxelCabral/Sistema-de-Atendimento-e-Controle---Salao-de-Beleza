<?php
    class product_DAO{
        public function insert_product($product, $connection){
            
            include_once ("classes/product.php");

            try{
                $stmt = $connection->prepare("INSERT INTO produtos(nome, quantidade, min) 
                VALUES(:nome, :quantidade, :min)");
                $stmt->bindValue(":nome", $product->getName());
                $stmt->bindValue(":quantidade", $product->getQuantity());
                $stmt->bindValue(":min", $product->getMin());
            
                $stmt->execute();
                
                return true;
            }
            catch(PDOException $e){
                echo $e->getMessage();

                return $e;
            }
        }
        public function product_list($connection){
            try{
                $stmt = $connection->query("SELECT * FROM produtos ORDER BY id DESC")->fetchAll(PDO::FETCH_OBJ);
    
                return $stmt;
            }
            catch(PDOException $e){
                echo $e->getMessage();

                return null;
            }
        }
        public function product_delete($id, $connection){
            try{
                $stmt = $connection->prepare("DELETE FROM produtos WHERE id = :id");
                $stmt->bindValue(":id", $id);
    
                $stmt->execute();
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
        public function edit_product_info($id, $connection){
            try{
                $stmt = $connection->query("SELECT * FROM produtos WHERE id = '$id'")->fetchAll(PDO::FETCH_OBJ);
    
                return $stmt;
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
        public function edit_product($id, $product, $connection){

            include_once ("classes/product.php");
    
            try{
                $stmt = $connection->prepare("UPDATE produtos SET nome = ?, quantidade = ?, min = ? WHERE id = ?");
    
                $stmt->bindValue(1, $product->getName());
                $stmt->bindValue(2, $product->getQuantity());
                $stmt->bindValue(3, $product->getMin());
                $stmt->bindValue(4, $id);
    
                $stmt->execute();
    
                return true;
            }
            catch(PDOException $e){
                echo $e->getMessage();
    
                return false;
            }
        }
        public function edit_product_unitys($id, $product, $connection){

            include_once ("classes/product.php");
    
            try{
                $stmt = $connection->prepare("UPDATE produtos SET quantidade = ? WHERE id = ?");
    
                $stmt->bindValue(1, $product->getQuantity());
                $stmt->bindValue(2, $id);
    
                $stmt->execute();
    
                return true;
            }
            catch(PDOException $e){
                echo $e->getMessage();
    
                return false;
            }
        }
        public function get_product_problems($connection){
            try{
                $stmt = $connection->query("SELECT * FROM produtos WHERE quantidade < min
                ORDER BY id DESC")->fetchAll(PDO::FETCH_OBJ);
    
                return $stmt;
            }
            catch(PDOException $e){
                echo $e->getMessage();

                return null;
            }
        }
        public function decrease_product_unity($connection, $id){

            include_once ("classes/product.php");
    
            try{
                $stmt = $connection->prepare("UPDATE produtos SET quantidade = quantidade-1 WHERE id = ?");
    
                $stmt->bindValue(1, $id);
    
                $stmt->execute();
    
                return true;
            }
            catch(PDOException $e){
                echo $e->getMessage();
    
                return false;
            }
        }
        public function product_data($id, $connection){
            try{
                $stmt = $connection->query("SELECT * FROM produtos WHERE id = '$id'")->fetchAll(PDO::FETCH_OBJ);
    
                return $stmt;
            }
            catch(PDOException $e){
                echo $e->getMessage();

                return null;
            }
        }
    }

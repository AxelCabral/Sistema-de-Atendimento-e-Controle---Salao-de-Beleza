<?php
    class costumer_DAO{
        public function insert_costumer($costumer, $connection){
            
            include_once ("classes/costumer.php");

            try{
                $stmt = $connection->prepare("INSERT INTO clientes(nome, tel, data_nasc) 
                VALUES(:nome, :tel, :data_nasc)");
                $stmt->bindValue(":nome", $costumer->getName());
                $stmt->bindValue(":tel", $costumer->getNumber());
                $stmt->bindValue(":data_nasc", $costumer->getBDate());
            
                $stmt->execute();
                
                return true;
            }
            catch(PDOException $e){
                echo $e->getMessage();

                return $e;
            }
        }
        public function costumers_list($connection){
            try{
                $stmt = $connection->query("SELECT * FROM clientes ORDER BY id DESC")->fetchAll(PDO::FETCH_OBJ);
    
                return $stmt;
            }
            catch(PDOException $e){
                echo $e->getMessage();

                return null;
            }
        }
        public function costumer_delete($id, $connection){
            try{
                $stmt = $connection->prepare("DELETE FROM clientes WHERE id = :id");
                $stmt->bindValue(":id", $id);
    
                $stmt->execute();
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
        public function edit_costumer_info($id, $connection){
            try{
                $stmt = $connection->query("SELECT * FROM clientes WHERE id = '$id'")->fetchAll(PDO::FETCH_OBJ);
    
                return $stmt;
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
        public function edit_costumer($id, $costumer, $connection){

            include_once ("classes/costumer.php");
    
            try{
                $stmt = $connection->prepare("UPDATE clientes SET nome = ?, tel = ?, data_nasc = ? WHERE id = ?");
    
                $stmt->bindValue(1, $costumer->getName());
                $stmt->bindValue(2, $costumer->getNumber());
                $stmt->bindValue(3, $costumer->getBDate());
                $stmt->bindValue(4, $id);
    
                $stmt->execute();
    
                return true;
            }
            catch(PDOException $e){
                echo $e->getMessage();
    
                return false;
            }
        }
        public function get_last_id($connection){
            try{
                $stmt = $connection->query("SELECT id FROM clientes ORDER BY id DESC LIMIT 1")->fetchAll(PDO::FETCH_OBJ);
    
                return $stmt;
            }
            catch(PDOException $e){
                echo $e->getMessage();

                return null;
            }
        }
        public function get_costumer_name($connection, $id){
            try{
                $stmt = $connection->query("SELECT nome FROM clientes WHERE id = '$id'")->fetchAll(PDO::FETCH_OBJ);
    
                return $stmt;
            }
            catch(PDOException $e){
                echo $e->getMessage();

                return null;
            }
        }
    }

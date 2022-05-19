<?php
    class service_DAO{
        public function insert_service($service, $connection){
            
            include_once ("classes/service.php");

            try{
                $stmt = $connection->prepare("INSERT INTO servicos(servico, valor)VALUES(:servico, :valor)");
                $stmt->bindValue(":servico", $service->getService());
                $stmt->bindValue(":valor", $service->getPrice());
            
                $stmt->execute();
                
                return true;
            }
            catch(PDOException $e){
                echo $e->getMessage();

                return $e;
            }
        }
        public function services_list($connection){
            try{
                $stmt = $connection->query("SELECT * FROM servicos ORDER BY id DESC")->fetchAll(PDO::FETCH_OBJ);
    
                return $stmt;
            }
            catch(PDOException $e){
                echo $e->getMessage();

                return null;
            }
        }
        public function service_delete($id, $connection){
            try{
                $stmt = $connection->prepare("DELETE FROM servicos WHERE id = :id");
                $stmt->bindValue(":id", $id);
    
                $stmt->execute();
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
        public function edit_service_info($id, $connection){
            try{
                $stmt = $connection->query("SELECT * FROM servicos WHERE id = '$id'")->fetchAll(PDO::FETCH_OBJ);
    
                return $stmt;
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
        public function edit_service($id, $service, $connection){

            include_once ("classes/service.php");
    
            try{
                $stmt = $connection->prepare("UPDATE servicos SET servico = ?, valor = ? WHERE id = ?");
    
                $stmt->bindValue(1, $service->getService());
                $stmt->bindValue(2, $service->getPrice());
                $stmt->bindValue(3, $id);
    
                $stmt->execute();
    
                return true;
            }
            catch(PDOException $e){
                echo $e->getMessage();
    
                return false;
            }
        }
        public function service_data($id, $connection){
            try{
                $stmt = $connection->query("SELECT * FROM servicos WHERE id = '$id'")->fetchAll(PDO::FETCH_OBJ);
    
                return $stmt;
            }
            catch(PDOException $e){
                echo $e->getMessage();

                return null;
            }
        }
    }

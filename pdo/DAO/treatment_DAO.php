<?php
    class treatment_DAO{
        public function treatments_list($connection){
            try{
                $stmt = $connection->query("SELECT * FROM atendimentos ORDER BY id 
                DESC LIMIT 100")->fetchAll(PDO::FETCH_OBJ);
    
                return $stmt;
            }
            catch(PDOException $e){
                echo $e->getMessage();

                return null;
            }
        }
        public function insert_treatment($treatment, $connection){
            
            include_once ("classes/treatment.php");

            try{
                $stmt = $connection->prepare("INSERT INTO atendimentos(id_cliente, nome_cliente, d_assiduidade,
                d_aniversario, promocao_percent, promocao_valor, metodo, valor_atendimento, data_atendimento) 
                VALUES(:id_cliente, :nome_cliente, :d_assiduidade, :d_aniversario, :promocao_percent,
                :promocao_valor, :metodo, :valor_atendimento, :data_atendimento)");
                $stmt->bindValue(":id_cliente", $treatment->getCostumerId());
                $stmt->bindValue(":nome_cliente", $treatment->getCostumerName());
                $stmt->bindValue(":d_assiduidade", $treatment->getAssiduity());
                $stmt->bindValue(":d_aniversario", $treatment->getBirthday());
                $stmt->bindValue(":promocao_percent", $treatment->getPercentPromotion());
                $stmt->bindValue(":promocao_valor", $treatment->getValuePromotion());
                $stmt->bindValue(":metodo", $treatment->getPaymentMethod());
                $stmt->bindValue(":valor_atendimento", $treatment->getTreatmentPrice());
                $stmt->bindValue(":data_atendimento", $treatment->getTreatmentDate());
            
                $stmt->execute();
                
                return true;
            }
            catch(PDOException $e){
                echo $e->getMessage();

                return $e;
            }
        }
        public function get_last_id($connection){
            try{
                $stmt = $connection->query("SELECT id FROM atendimentos ORDER BY id DESC LIMIT 1")->fetchAll(PDO::FETCH_OBJ);
    
                return $stmt;
            }
            catch(PDOException $e){
                echo $e->getMessage();

                return null;
            }
        }
        public function insert_treatment_products($product_id, $treatment_id, $connection){
            try{
                $stmt = $connection->prepare("INSERT INTO produtos_atendimento(id_produto, id_atendimento) 
                VALUES(:id_produto, :id_atendimento)");
                $stmt->bindValue(":id_produto", $product_id);
                $stmt->bindValue(":id_atendimento", $treatment_id);
            
                $stmt->execute();
                
                return true;
            }
            catch(PDOException $e){
                echo $e->getMessage();

                return $e;
            }
        }
        public function insert_treatment_services($service_id, $treatment_id, $connection){
            try{
                $stmt = $connection->prepare("INSERT INTO servicos_atendimento(id_servico, id_atendimento) 
                VALUES(:id_servico, :id_atendimento)");
                $stmt->bindValue(":id_servico", $service_id);
                $stmt->bindValue(":id_atendimento", $treatment_id);
            
                $stmt->execute();
                
                return true;
            }
            catch(PDOException $e){
                echo $e->getMessage();

                return $e;
            }
        }
        public function insert_treatment_sales($sale_id, $treatment_id, $connection){
            try{
                $stmt = $connection->prepare("INSERT INTO venda_atendimento(id_venda, id_atendimento) 
                VALUES(:id_venda, :id_atendimento)");
                $stmt->bindValue(":id_venda", $sale_id);
                $stmt->bindValue(":id_atendimento", $treatment_id);
            
                $stmt->execute();
                
                return true;
            }
            catch(PDOException $e){
                echo $e->getMessage();

                return $e;
            }
        }
        public function treatment_delete($id, $connection){
            try{
                $stmt = $connection->prepare("DELETE FROM atendimentos WHERE id = :id");
                $stmt->bindValue(":id", $id);
    
                $stmt->execute();
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
        public function treatment_services_list($id, $connection){
            try{
                $stmt = $connection->query("SELECT * FROM servicos_atendimento WHERE id_atendimento =
                '$id'")->fetchAll(PDO::FETCH_OBJ);
    
                return $stmt;
            }
            catch(PDOException $e){
                echo $e->getMessage();

                return null;
            }
        }
        public function treatment_products_list($id, $connection){
            try{
                $stmt = $connection->query("SELECT * FROM produtos_atendimento WHERE id_atendimento =
                '$id'")->fetchAll(PDO::FETCH_OBJ);
    
                return $stmt;
            }
            catch(PDOException $e){
                echo $e->getMessage();

                return null;
            }
        }
        public function get_treatment_sale($id, $connection){
            try{
                $stmt = $connection->query("SELECT * FROM venda_atendimento WHERE id_atendimento =
                '$id'")->fetchAll(PDO::FETCH_OBJ);
    
                return $stmt;
            }
            catch(PDOException $e){
                echo $e->getMessage();

                return null;
            }
        }
        public function total_treatments($connection, $m, $y){
            try{
                $stmt = $connection->query("SELECT * FROM atendimentos WHERE month(data_atendimento) = $m 
                AND year(data_atendimento) = $y")->fetchAll(PDO::FETCH_OBJ);
    
                return $stmt;
            }
            catch(PDOException $e){
                echo $e->getMessage();

                return null;
            }
        }
    }

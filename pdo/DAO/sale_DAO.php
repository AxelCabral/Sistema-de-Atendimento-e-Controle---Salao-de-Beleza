<?php
    class sale_DAO{
        public function insert_sale($sale, $connection){
            
            include_once ("classes/sale.php");

            try{
                $stmt = $connection->prepare("INSERT INTO vendas(origem, valor, data_venda)
                VALUES(:origem, :valor, :data_venda)");
                $stmt->bindValue(":origem", $sale->getOrigin());
                $stmt->bindValue(":valor", $sale->getValue());
                $stmt->bindValue(":data_venda", $sale->getSaleDate());
            
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
                $stmt = $connection->query("SELECT id FROM vendas ORDER BY id DESC LIMIT 1")->fetchAll(PDO::FETCH_OBJ);
    
                return $stmt;
            }
            catch(PDOException $e){
                echo $e->getMessage();

                return null;
            }
        }
        public function sale_data($id, $connection){
            try{
                $stmt = $connection->query("SELECT * FROM vendas WHERE id = '$id'")->fetchAll(PDO::FETCH_OBJ);
    
                return $stmt;
            }
            catch(PDOException $e){
                echo $e->getMessage();

                return null;
            }
        }
        public function total_sales($connection, $m, $y){
            try{
                $stmt = $connection->query("SELECT * FROM vendas WHERE month(data_venda) = $m 
                AND year(data_venda) = $y")->fetchAll(PDO::FETCH_OBJ);
    
                return $stmt;
            }
            catch(PDOException $e){
                echo $e->getMessage();

                return null;
            }
        }
    }

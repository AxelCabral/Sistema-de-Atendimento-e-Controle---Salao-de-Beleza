<?php
    class financial_DAO{
        public function get_financial_data($connection){
            try{
                $stmt = $connection->query("SELECT * FROM financeiro WHERE id = 1")->fetchAll(PDO::FETCH_OBJ);
    
                return $stmt;
            }
            catch(PDOException $e){
                echo $e->getMessage();

                return null;
            }
        }
        public function edit_goal($financial, $connection){

            include_once ("classes/financial.php");
    
            try{
                $stmt = $connection->prepare("UPDATE financeiro SET meta_semanal = ? WHERE id = ?");
    
                $stmt->bindValue(1, $financial->getWeeklyGoal());
                $stmt->bindValue(2, 1);
    
                $stmt->execute();
    
                return true;
            }
            catch(PDOException $e){
                echo $e->getMessage();
    
                return false;
            }
        }
        public function reset_information($financial, $connection){

            include_once ("pdo/classes/financial.php");
    
            try{
                $stmt = $connection->prepare("UPDATE financeiro SET entrada_semanal = ?, saida_semanal = ?,
                ultimo_dia = ? WHERE id = ?");
    
                $stmt->bindValue(1, $financial->getCashIncome());
                $stmt->bindValue(2, $financial->getCashOutflow());
                $stmt->bindValue(3, $financial->getLastDate());
                $stmt->bindValue(4, 1);
    
                $stmt->execute();
    
                return true;
            }
            catch(PDOException $e){
                echo $e->getMessage();
    
                return false;
            }
        }
        public function edit_cash_outflow($financial, $connection){

            include_once ("classes/financial.php");
    
            try{
                $stmt = $connection->prepare("UPDATE financeiro SET saida_semanal = ? WHERE id = ?");
    
                $stmt->bindValue(1, $financial->getCashOutflow());
                $stmt->bindValue(2, 1);
    
                $stmt->execute();
    
                return true;
            }
            catch(PDOException $e){
                echo $e->getMessage();
    
                return false;
            }
        }
        public function edit_cash_income($financial, $connection){

            include_once ("classes/financial.php");
    
            try{
                $stmt = $connection->prepare("UPDATE financeiro SET entrada_semanal = ? WHERE id = ?");
    
                $stmt->bindValue(1, $financial->getCashIncome());
                $stmt->bindValue(2, 1);
    
                $stmt->execute();
    
                return true;
            }
            catch(PDOException $e){
                echo $e->getMessage();
    
                return false;
            }
        }
    }

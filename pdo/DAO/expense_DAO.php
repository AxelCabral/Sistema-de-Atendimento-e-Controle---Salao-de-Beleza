<?php
    class expense_DAO{
        public function insert_expense($expense, $connection){
            
            include_once ("classes/expense.php");

            try{
                $stmt = $connection->prepare("INSERT INTO despesas(valor, descricao, data_despesa)
                VALUES(:valor, :descricao, :data_despesa)");
                $stmt->bindValue(":valor", $expense->getCash());
                $stmt->bindValue(":descricao", $expense->getDescription());
                $stmt->bindValue(":data_despesa", $expense->getExpenseDate());
            
                $stmt->execute();
                
                return true;
            }
            catch(PDOException $e){
                echo $e->getMessage();

                return $e;
            }
        }
        public function total_expense($connection, $m, $y){
            try{
                $stmt = $connection->query("SELECT * FROM despesas WHERE month(data_despesa) = $m 
                AND year(data_despesa) = $y")->fetchAll(PDO::FETCH_OBJ);
    
                return $stmt;
            }
            catch(PDOException $e){
                echo $e->getMessage();

                return false;
            }
        }
    }

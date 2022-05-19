<?php
    include_once ('pdo/connection.php');
    include_once ('pdo/DAO/treatment_DAO.php');
    include_once ('pdo/DAO/expense_DAO.php');
    include_once ('pdo/DAO/sale_DAO.php');
    include_once ('month_number.php');

    if(isset($_POST['month'], $_POST['year'])&& $_POST['month'] != "" && $_POST['year'] != ""){

        $selected_month = $_POST['month'];
        $selected_year = $_POST['year'];

        $month_number = monthNumber($selected_month);

        $c = new connection();
        $conn = $c->connect();

        // Despesas 

        $sum = new expense_DAO();
        $stmt_expense = $sum->total_expense($conn, $month_number, $selected_year);

        $expense_value = 0; //Valor das despesas totais do mês

        foreach($stmt_expense as $exp){
            $expense_value += $exp->valor;
        }

        // Atendimentos
        $sum = new treatment_DAO();
        $stmt_treatments = $sum->total_treatments($conn, $month_number, $selected_year);

        $treatment_value = 0; //Valor da renda gerada através de atendimentos

        foreach($stmt_treatments as $tre){
            $inicial_value = $tre->valor_atendimento;
            $payment = $tre->metodo;
            
            if($payment == "Pix" || $payment == "Débito"){
                $tax = 1;
            }
            else if($payment == "Crédito 1x"){
                $tax = 4;
            }
            else if($payment == "Dinheiro"){
                $tax = 0;
            }
            else{
                $tax = 5;
            }

            $treatment_value += ($inicial_value - $inicial_value*($tax/100));
        }

        // Vendas
        $sum = new sale_DAO();
        $stmt_sales = $sum->total_sales($conn, $month_number, $selected_year);

        $sale_value = 0; //Valor da renda gerada pelas vendas do mês

        foreach($stmt_sales as $sal){
            $sale_value += $sal->valor;
        }

        //Caixa do mês

        $final_value = $sale_value+$treatment_value-$expense_value;
    }
    else{
        header('Location:financial_data.php');
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/fonts.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet" />
    <script src="js/lord-icon.js"></script>
    <link rel="icon" href="img/logo.png">
    <title>Lucia Reis | Relatório</title>
</head>
<body class="list-main-section">
    <header>
        <div class="return">
            <a href="financial_data.php" title="Voltar" target="_self" rel="prev">
                <lord-icon src="css/icons/return.json"
                    trigger="hover"
                    delay="1000"
                    colors="primary:#000,secondary:#ffffff"
                    style="width:30px;height:auto;padding-bottom:10px;padding-left:5px;">
                </lord-icon>
            </a>
        </div>
        <div class="title" id="product-title">
            <div class="main-text-title">
                <h1>Relatório Mensal - <?=$selected_month;?> de <?=$selected_year;?></h1>
            </div>
        </div>
    </header>
    <main style="margin-top: 20px;">
        <div class="title" id="product-title">
            <div class="main-text-title">
                <h1>Dados Financeiros</h1>
            </div>
        </div>
        <section class="list-out">
            <div class="financial-final-data">
                <div class="data-table" id="data-table-product">
                    <table>
                        <tr>
                            <th>Total de Despesas Mensais</th><td>R$
                            <?= number_format($expense_value, 2, ',', '.'); ?></td>   
                        </tr>
                        <tr>
                            <th>Total de Atendimentos do mês</th><td>R$
                            <?= number_format($treatment_value, 2, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <th>Total em Vendas do mês</th><td>R$
                            <?= number_format($sale_value , 2, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <th>Caixa do mês</th><td>R$
                            <?= number_format($final_value, 2, ',', '.'); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </section>
        <div class="title" id="product-title">
            <div class="main-text-title">
                <h1>Despesas do mês</h1>
            </div>
        </div>
        <section class="list-out">
            <div class="expense-final-data">
                <div class="data-table" id="data-table-product">
                    <table>
                        <tr>
                            <th>Valor</th><th>Descrição</th><th>Data</th>
                        </tr>
                        <?php
                            if($stmt_expense == null){
                        ?>
                            <tr>
                                <td>-</td><td>-</td><td>-</td>
                            </tr>
                        <?php
                            }
                            else{
                                foreach($stmt_expense as $exp){
                        ?>
                            <tr>
                                <td> R$ <?= number_format($exp->valor, 2, ',', '.'); ?></td>
                                <td><?= $exp->descricao; ?></td>
                                <td><?= date('d/m/Y', strtotime($exp->data_despesa)); ?></td>
                            </tr>
                        <?php
                                }
                            }
                        ?>
                    </table>
                </div>
            </div>
        </section>
        <div class="title" id="product-title">
            <div class="main-text-title">
                <h1>Vendas do mês</h1>
            </div>
        </div>
        <section class="list-out">
            <div class="sales-final-data">
                <div class="data-table" id="data-table-product">
                    <table>
                        <tr>
                            <th>Origem</th><th>Valor</th><th>Data</th>
                        </tr>
                        <?php
                            if($stmt_sales == null){
                        ?>
                            <tr>
                                <td>-</td><td>-</td><td>-</td>
                            </tr>
                        <?php
                            }
                            else{
                                foreach($stmt_sales as $sal){
                        ?>
                            <tr>
                                <td><?= $sal->origem; ?></td>
                                <td>R$ <?= number_format($sal->valor, 2, ',', '.'); ?></td>
                                <td><?= date('d/m/Y', strtotime($sal->data_venda)); ?></td>
                            </tr>
                        <?php
                                }
                            }
                        ?>
                    </table>
                </div>
            </div>
        </section>
        <div class="title" id="product-title">
            <div class="main-text-title">
                <h1>Atendimentos do mês</h1>
            </div>
        </div>
        <section class="list-out">
            <div class="treatments-final-data">
                <div class="data-table-large" id="data-table-product">
                    <table>
                        <tr>
                        <th>Cliente</th><th>Desconto de assiduidade</th>
                        <th>Desconto de aniversário</th><th>Promoção</th><th>Método de pagamento</th>
                        <th>Valor Final</th><th>Data do atendimento</th>
                        </tr>
                        <?php
                            if($stmt_treatments == null){
                        ?>
                            <tr>
                                <td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>
                            </tr>
                        <?php
                            }
                            else{
                                foreach($stmt_treatments as $t){
                                    if($t->promocao_percent != 0){
                                        $promocao = $t->promocao_percent."%";
                                    }
                                    else if($t->promocao_valor != 0){
                                        $promocao = "R$".number_format($t->promocao_valor, 2, ',', '.')." OFF";
                                    }
                                    else{
                                        $promocao = "Não";
                                    }
                        ?>
                            <tr>
                                <td><?= $t->nome_cliente; ?></td>
                                <td><?= $t->d_assiduidade; ?></td>
                                <td><?= $t->d_aniversario; ?></td>
                                <td><?= $promocao; ?></td>
                                <td><?= $t->metodo; ?></td>
                                <td>R$ <?=number_format($t->valor_atendimento, 2, ',', '.');?></td>
                                <td><?=date('d/m/Y', strtotime($t->data_atendimento));?></td>
                            </tr>
                        <?php
                                }
                            }
                        ?>
                    </table>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>Espaço da Beleza Lucia Reis - Santana do Livramento, RS 
        <lord-icon src="css/icons/local.json"
                    trigger="loop"
                    delay="1000"
                    colors="primary:#ffffff,secondary:#ffffff"
                    style="width:30px;height:auto;padding-bottom:10px;">
        </lord-icon>
        | &copy; 2021 Todos os direitos reservados.</p>
    </footer>
</body>
</html>
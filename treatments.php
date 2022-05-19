<?php
    include_once ('pdo/connection.php');
    include_once ('pdo/DAO/treatment_DAO.php');
    include_once ('pdo/DAO/service_DAO.php');
    include_once ('pdo/DAO/sale_DAO.php');
    include_once ('pdo/DAO/product_DAO.php');

    $c = new connection();
    $conn = $c->connect();

    $select = new treatment_DAO();
    $stmt = $select->treatments_list($conn);
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
    <script src="js/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <link rel="icon" href="img/logo.png">
    <title>Lucia Reis | Atendimentos</title>
</head>
<body class="list-main-section">
    <section>
        <?php
            foreach($stmt as $t){

                $select = new treatment_DAO();
                $stmt2 = $select->treatment_services_list($t->id, $conn);
        ?>
            <div id="popup-<?=$t->id;?>" class="popup">
                <div class="popup-area">
                    <p class="close-popup" id="close-popup-<?=$t->id;?>">X</p>
                    
                    <h3>Serviços do atendimento</h3>
                    <div class="data-table-popup">
                        <table border='0'>
                        <?php
                                $select = new service_DAO();

                                foreach($stmt2 as $services){
                                    $stmt3 = $select->service_data($services->id_servico, $conn);

                                    foreach($stmt3 as $data_obj){
                        ?>
                                        <tr><td><?=$data_obj->servico;?>:</td>
                                        <td>R$ <?=number_format($data_obj->valor, 2, ',', '');?></td></tr>
                        <?php
                                    }
                                }
                                if($stmt2 == null){
                        ?>
                                    <p>Nenhum serviço foi encontrado neste atendimento.</p>
                                    <br/>
                        <?php
                                }
                        ?>
                        </table>
                        <br/>
                    </div>
                    <h3>Produtos do atendimento</h3>
                    <div class="data-table-popup-2">
                        <table border='0'>
                        <?php
                                $select = new treatment_DAO();
                                $stmt2 = $select->treatment_products_list($t->id, $conn);

                                $select = new product_DAO();

                                foreach($stmt2 as $product){
                                    $stmt3 = $select->product_data($product->id_produto, $conn);

                                    foreach($stmt3 as $data_obj){
                        ?>
                                        <tr><td><?=$data_obj->nome;?></td></tr>
                        <?php
                                    }
                                }
                                if($stmt2 == null){
                        ?>
                                    <p>Nenhum Produto foi utilizado neste atendimento.</p>
                                    <br/>
                        <?php
                                }
                        ?>
                            </table>
                            <br/>
                </div>
                <h3>Venda do atendimento</h3>
                <div class="data-table-popup">
                    <table border='0'>
                    <?php
                        $select = new treatment_DAO();
                        $stmt2 = $select->get_treatment_sale($t->id, $conn);

                        $select = new sale_DAO();

                        foreach($stmt2 as $sale){
                            $stmt3 = $select->sale_data($sale->id_venda, $conn);

                            foreach($stmt3 as $data_obj){
                    ?>
                                <tr>
                                <td><?=$data_obj->origem;?>:</td>
                                <td>R$ <?=number_format($data_obj->valor, 2, ',', '');?></td>
                                </tr>
                    <?php
                                }
                            }
                            if($stmt2 == null){
                    ?>
                                <p>Nenhuma Venda foi realizada neste atendimento.</p>
                                <br/>
                    <?php
                            }
                    ?>
                    </table>
                </div>
            </div>
        </div>
        <?php
            }
        ?>
    </section>
    <header>
        <div class="return">
            <a href="index.php" title="Voltar" target="_self" rel="prev">
                <lord-icon src="css/icons/return.json"
                    trigger="hover"
                    delay="1000"
                    colors="primary:#000,secondary:#ffffff"
                    style="width:30px;height:auto;padding-bottom:10px;padding-left:5px;">
                </lord-icon>
            </a>
        </div>
        <div class="title" id="treatment-title">
            <div class="main-text-title">
                <h1>Atendimentos</h1>
            </div>
            <div class="new-item">
                <a href="new_treatment.php" title="Novo Atendimento" target="_self" rel="next">
                    <lord-icon src="css/icons/plus.json"
                    trigger="none"
                    colors="primary:#ffffff,secondary:#ffffff"
                    style="width:50px;height:auto">
                    </lord-icon>
                </a>
            </div>
        </div>
    </header>
    <main>
        <section class="list-out">
            <div class="data-table-large" id="data-table-treatment">
                <table border='0'>
                    <tr><th>Cliente</th><th>Data do atendimento</th><th>Desconto de assiduidade</th>
                    <th>Desconto de aniversário</th><th>Promoção</th><th>Método de pagamento</th>
                    <th>Valor Final</th><th>Opções</th></tr>
                
                    <?php
                        if($stmt == null){
                    ?>
                            </table>
                            <p>Nenhum atendimento foi encontrado.</p>
                    <?php
                        }
                        else{
                            foreach($stmt as $t){
                                if($t->promocao_percent != 0){
                                    $promocao = $t->promocao_percent."%";
                                }
                                else if($t->promocao_valor != 0){
                                    $promocao = "R$".number_format($t->promocao_valor, 2, ',')." OFF";
                                }
                                else{
                                    $promocao = "Não";
                                }
                    ?>
                                <tr>
                                    <td><?=$t->nome_cliente;?></td>
                                    <td><?=date('d/m/Y', strtotime($t->data_atendimento));?></td>
                                    <td><?=$t->d_assiduidade;?></td>
                                    <td><?=$t->d_aniversario;?></td>
                                    <td><?=$promocao;?></td>
                                    <td><?=$t->metodo;?></td>
                                    <td>R$ <?=number_format($t->valor_atendimento, 2, ',', '');?></td>
                                    <td>
                                        <a class="open-popup" id="open-popup-<?=$t->id;?>" title='Mais Detalhes'>
                                            <lord-icon id="open-anim-<?=$t->id;?>" src="css/icons/book.json"
                                            trigger="hover"
                                            colors="primary:#000,secondary:#000"
                                            style="width:40px;height:auto">
                                            </lord-icon>
                                        </a>|
                                        <a id="delete-<?=$t->id;?>" href="pdo/delete_treatment.php?id=<?=$t->id;?>" title='Deletar'>
                                            <lord-icon id="delete-anim-<?=$t->id;?>" src="css/icons/delete.json"
                                            trigger="none"
                                            colors="primary:#000,secondary:#000"
                                            style="width:40px;height:auto">
                                            </lord-icon>
                                        </a>
                                        <script>
                                            $(document).ready(function() {
                                                $('#open-popup-<?=$t->id;?>').mouseover(function(){
                                                    $('#open-anim-<?=$t->id;?>').attr("trigger", "loop");
                                                });
                                                $('#open-popup-<?=$t->id;?>').mouseleave(function(){
                                                    $('#open-anim-<?=$t->id;?>').attr("trigger", "hover");
                                                });
                                                $('#delete-<?=$t->id;?>').mouseover(function(){
                                                    $('#delete-anim-<?=$t->id;?>').attr("trigger", "loop");
                                                });
                                                $('#delete-<?=$t->id;?>').mouseleave(function(){
                                                    $('#delete-anim-<?=$t->id;?>').attr("trigger", "none");
                                                });
                                                $('#open-popup-<?=$t->id;?>').click(function(){
                                                    $('#popup-<?=$t->id;?>').css("display", "inherit");
                                                });
                                                $('#close-popup-<?=$t->id;?>').click(function(){
                                                    $('#popup-<?=$t->id;?>').css("display", "none");
                                                });
                                            });
                                        </script>
                                    </td>
                                </tr>
                    <?php
                            }
                        }
                    ?>
                </table>
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
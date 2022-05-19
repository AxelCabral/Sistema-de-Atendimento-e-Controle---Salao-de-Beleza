<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/fonts.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet" />
    <script src="js/lord-icon.js"></script>
    <script src="js/jquery-3.5.1.min.js"></script>
    <link rel="icon" href="img/logo.png">
    <title>Lucia Reis | Serviços</title>
</head>
<body class="list-main-section">
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
        <div class="title" id="service-title">
            <div class="main-text-title">
                <h1>Serviços</h1>
            </div>
            <div class="new-item">
                <a href="new_service.php" title="Novo Serviço" target="_self" rel="next">
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
            <div class="data-table" id="data-table-service">
                <table border='0'>
                    <tr><th>Serviço</th><th>Valor</th><th>Opções</th></tr>
                    
                    <?php
                        include_once ('pdo/connection.php');
                        include_once ('pdo/DAO/service_DAO.php');
            
                        $c = new connection();
                        $conn = $c->connect();
            
                        $select = new service_DAO();
                        $stmt = $select->services_list($conn);
            
                        if($stmt == null){
                    ?>
                            </table>
                            <p>Nenhum serviço foi encontrado.</p>
                    <?php
                        }
                        else{
                            foreach($stmt as $s){
                    ?>
                                <tr>
                                    <td><?=$s->servico;?></td>
                                    <td>R$ <?=number_format($s->valor, 2, ',');?></td>
                                    <td>
                                        <a id="edit-<?=$s->id;?>" href="pdo/edit_service.php?id=<?=$s->id;?>" title='Editar'>
                                            <lord-icon id="edit-anim-<?=$s->id;?>" src="css/icons/edit.json"
                                            trigger="none"
                                            colors="primary:#000,secondary:#000"
                                            style="width:40px;height:auto">
                                            </lord-icon>
                                        </a>|
                                        <a id="delete-<?=$s->id;?>" href="pdo/delete_service.php?id=<?=$s->id;?>" title='Deletar'>
                                            <lord-icon id="delete-anim-<?=$s->id;?>" src="css/icons/delete.json"
                                            trigger="none"
                                            colors="primary:#000,secondary:#000"
                                            style="width:40px;height:auto">
                                            </lord-icon>
                                        </a>
                                        <script>
                                            $(document).ready(function(){
                                                $('#edit-<?=$s->id;?>').mouseover(function(){
                                                    $('#edit-anim-<?=$s->id;?>').attr("trigger", "loop");
                                                });
                                                $('#edit-<?=$s->id;?>').mouseleave(function(){
                                                    $('#edit-anim-<?=$s->id;?>').attr("trigger", "none");
                                                });
                                                $('#delete-<?=$s->id;?>').mouseover(function(){
                                                    $('#delete-anim-<?=$s->id;?>').attr("trigger", "loop");
                                                });
                                                $('#delete-<?=$s->id;?>').mouseleave(function(){
                                                    $('#delete-anim-<?=$s->id;?>').attr("trigger", "none");
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
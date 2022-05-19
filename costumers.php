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
    <title>Lucia Reis | Clientes</title>
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
        <div class="title" id="costumer-title">
            <div class="main-text-title">
                <h1>Clientes</h1>
            </div>
            <div class="new-item">
                <a href="new_costumer.php" title="Novo Cliente" target="_self" rel="next">
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
            <div class="data-table" id="data-table-costumer">
                <table border='0'>
                    <tr><th>Nome</th><th>Celular</th><th>Data de Nascimento</th><th>Opções</th></tr>
                    
                    <?php
                        include_once ('pdo/connection.php');
                        include_once ('pdo/DAO/costumer_DAO.php');
            
                        $c = new connection();
                        $conn = $c->connect();
            
                        $select = new costumer_DAO();
                        $stmt = $select->costumers_list($conn);
            
                        if($stmt == null){
                    ?>
                            </table>
                            <p>Nenhum cliente foi encontrado.</p>
                    <?php
                        }
                        else{
                            foreach($stmt as $cos){
                    ?>
                                <tr>
                                    <td><?=$cos->nome;?></td>
                                    <td><?=$cos->tel;?></td>
                                    <td><?=date('d/m/Y', strtotime($cos->data_nasc));?></td>
                                    <td>
                                        <a id="edit-<?=$cos->id;?>" href="pdo/edit_costumer.php?id=<?=$cos->id;?>" title='Editar'>
                                            <lord-icon id="edit-anim-<?=$cos->id;?>" src="css/icons/edit.json"
                                            trigger="none"
                                            colors="primary:#000,secondary:#000"
                                            style="width:40px;height:auto">
                                            </lord-icon>
                                        </a>|
                                        <a id="delete-<?=$cos->id;?>" href="pdo/delete_costumer.php?id=<?=$cos->id;?>" title='Deletar'>
                                            <lord-icon id="delete-anim-<?=$cos->id;?>" src="css/icons/delete.json"
                                            trigger="none"
                                            colors="primary:#000,secondary:#000"
                                            style="width:40px;height:auto">
                                            </lord-icon>
                                        </a>
                                        <script>
                                            $(document).ready(function(){
                                                $('#edit-<?=$cos->id;?>').mouseover(function(){
                                                    $('#edit-anim-<?=$cos->id;?>').attr("trigger", "loop");
                                                });
                                                $('#edit-<?=$cos->id;?>').mouseleave(function(){
                                                    $('#edit-anim-<?=$cos->id;?>').attr("trigger", "none");
                                                });
                                                $('#delete-<?=$cos->id;?>').mouseover(function(){
                                                    $('#delete-anim-<?=$cos->id;?>').attr("trigger", "loop");
                                                });
                                                $('#delete-<?=$cos->id;?>').mouseleave(function(){
                                                    $('#delete-anim-<?=$cos->id;?>').attr("trigger", "none");
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
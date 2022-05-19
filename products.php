<?php
    include_once ('pdo/connection.php');
    include_once ('pdo/DAO/product_DAO.php');

    $c = new connection();
    $conn = $c->connect();

    $select = new product_DAO();
    $stmt = $select->product_list($conn);
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
    <title>Lucia Reis | Estoque</title>
</head>
<body class="list-main-section">
    <section>
        <?php
            foreach($stmt as $p){
        ?>
            <div id="popup-<?=$p->id;?>" class="popup">
                <div class="popup-area">
                    <p class="close-popup" id="close-popup-<?=$p->id;?>">X</p>
                    <form action="pdo/add_products.php" method="post">
                        <h3>Adicionar Unidades</h3>
                        
                        <label for="unitys">Unidades: </label>
                        <input type="number" name="unitys">

                        <input type="hidden" name="id" value="<?=$p->id;?>">
                        <input type="hidden" name="current_unitys" value="<?=$p->quantidade;?>">

                        <input type="submit" value="Confirmar">
                    </form>
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
        <div class="title" id="product-title">
            <div class="main-text-title">
                <h1>Produtos em Estoque</h1>
            </div>
            <div class="new-item">
                <a href="new_product.php" title="Novo Produto" target="_self" rel="next">
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
            <div class="data-table" id="data-table-product">
                <table border='0'>
                    <tr><th>Nome</th><th>Quantidade</th><th>Mínimo de unidades</th><th>Opções</th></tr>
                    
                    <?php
                        if($stmt == null){
                    ?>
                            </table>
                            <p>Nenhum produto foi encontrado.</p>
                    <?php
                        }
                        else{
                            foreach($stmt as $p){
                    ?>
                                <tr>
                                    <td><?=$p->nome;?></td>
                                    <td><?=$p->quantidade;?> Unid.</td>
                                    <td><?=$p->min;?> Unid.</td>
                                    <td>
                                        <a class="open-popup" id="open-popup-<?=$p->id;?>" title='Adicionar'>
                                            <lord-icon src="css/icons/plus.json"
                                            trigger="none"
                                            colors="primary:#000,secondary:#000"
                                            style="width:40px;height:auto">
                                            </lord-icon>
                                        </a>|
                                        <a id="edit-<?=$p->id;?>" href="pdo/edit_product.php?id=<?=$p->id;?>" title='Editar'>
                                            <lord-icon id="edit-anim-<?=$p->id;?>" src="css/icons/edit.json"
                                            trigger="none"
                                            colors="primary:#000,secondary:#000"
                                            style="width:40px;height:auto">
                                            </lord-icon>
                                        </a>|
                                        <a id="delete-<?=$p->id;?>" href="pdo/delete_product.php?id=<?=$p->id;?>" title='Deletar'>
                                            <lord-icon id="delete-anim-<?=$p->id;?>" src="css/icons/delete.json"
                                            trigger="none"
                                            colors="primary:#000,secondary:#000"
                                            style="width:40px;height:auto">
                                            </lord-icon>
                                        </a>
                                        <script>
                                            $(document).ready(function() {
                                                $('#edit-<?=$p->id;?>').mouseover(function(){
                                                    $('#edit-anim-<?=$p->id;?>').attr("trigger", "loop");
                                                });
                                                $('#edit-<?=$p->id;?>').mouseleave(function(){
                                                    $('#edit-anim-<?=$p->id;?>').attr("trigger", "none");
                                                });
                                                $('#delete-<?=$p->id;?>').mouseover(function(){
                                                    $('#delete-anim-<?=$p->id;?>').attr("trigger", "loop");
                                                });
                                                $('#delete-<?=$p->id;?>').mouseleave(function(){
                                                    $('#delete-anim-<?=$p->id;?>').attr("trigger", "none");
                                                });
                                                $('#open-popup-<?=$p->id;?>').click(function(){
                                                    $('#popup-<?=$p->id;?>').css("display", "inherit");
                                                });
                                                $('#close-popup-<?=$p->id;?>').click(function(){
                                                    $('#popup-<?=$p->id;?>').css("display", "none");
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
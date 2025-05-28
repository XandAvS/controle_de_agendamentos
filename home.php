<?php
//include("cabecalho.php"); // se tiver erro apresenta o erro, e roda o resto que não deu erro
require_once("cabecalho.php"); //se der erro não execulta mais nada, mais seguro
//require_onde verifica se o conteudo ja foi incuido e não repete
function retornaServicos()
{
    require("conexao.php");
    try {
        $sql = "SELECT * FROM procedimentos";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        die("Erro ao consultar os Serviços Disponíveis: " . $e->getMessage());
    }
}
$procedimentos = retornaServicos();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <title>Serviços com Snap</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./src/css/estilos.css">
    <link rel="stylesheet" href="./src/css/cartao.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>

<body>

    <div class="container">
        <h4 class="mb-3 nomenclaturas">SELECIONE OS SERVIÇOS:</h4>

        <div class="snap-container" id="listaServicos">
             <?php
        foreach ($procedimentos as $pp): //vai percorrer as catecorias e a cada laço adiciona recebe o valor da variavel pp
        ?>
            <div class="snap-item" onclick="selecionar(this, '<?= $pp['nome']; ?>')">
                <img src="src/img/slotly logo.png?text=Corte" alt="<?= $pp['nome']; ?>">
                <div><?= $pp['nome']; ?></div>
                <div class="servico-info">
                    <span><?= $pp['preco']; ?></span><span><?= $pp['tempo']; ?></span>
                </div>
            </div> 
            <?php endforeach; ?>
        </div>
       

        <div class="dica">ARRASTE PARA O LADO PARA VER MAIS</div>
        <div class="col-5 mx-auto mt-4 d-block gap-2">
            <a href="novo_servicos.php" class="btn novo"><i class="bi bi-plus-lg"></i> Novo</a>
            <a href="servicos.php" class="btn editar"><i class="bi bi-pencil-fill"></i> Editar</a>
            <!--aqui vou criar uma pagina que vai aparecer todos os procedimentos cadsatrados e 
            cada um dele vai ter a parte de editar-->
        </div>

        <h4 class="mb-3 nomenclaturas">SELECIONE UM PROFISSIONAL:</h4>

        <div class="snap-container" id="listaServicos">
            <div class="snap-item" onclick="selecionar(this, 'Alexandre Alves')">
                <img src="src/img/prestador_alexandre.jpg" alt="Alexandre Alves">
                <div>Alexandre Alves</div>
                <div class="servico-info">
                    <span>Cortes & Barba</span>
                </div>
            </div>
        </div>

        <div class="dica">ARRASTE PARA O LADO PARA VER MAIS</div>
        <div class="col-5 mx-auto mt-4 d-block gap-2">
             <a href="novo_profissional.php" class="btn novo"><i class="bi bi-plus-lg"></i> Novo</a>
            <a href="profissional.php" class="btn editar"><i class="bi bi-pencil-fill"></i> Editar</a>
            
            <!--aqui vou criar uma pagina que vai aparecer todos os profissionais cadsatrados e 
            cada um dele vai ter a parte de editar-->
        </div>
        <div class="col-5 mt-5 mx-auto">
            <form method="post">
                <div class="mb-3">
                    <label for="data" class="form-label">Selecione o dia para o procedimento</label>
                    <input type="date" id="data" name="data" class="form-control" required="">
                </div>
            </form>
        </div>
        <button id="enviar" class="btn btn-secondary col-5 mx-auto mt-4 d-block" onclick="enviarServicos()">Enviar</button>

    </div>

    <script>
        function selecionar(element, nome) {
            element.classList.toggle('selecionado');
            if (selecionados.includes(nome)) {
                selecionados.splice(selecionados.indexOf(nome), 1);
            } else {
                selecionados.push(nome);
            }
        }
    </script>

</body>

</html>


<?php
require_once("rodape.php"); // acaba com o copia e cola quando preciso de comandos repitidos
?>
<?php
//include("cabecalho.php"); // se tiver erro apresenta o erro, e roda o resto que não deu erro
require_once("cabecalho.php"); //se der erro não execulta mais nada, mais seguro
//require_onde verifica se o conteudo ja foi incuido e não repete
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
        <h2 class="mb-3 nomenclaturas">SELECIONE OS SERVIÇOS:</h2>

        <div class="snap-container" id="listaServicos">
            <div class="snap-item" onclick="selecionar(this, 'Corte')">
                <img src="src/img/slotly logo.png?text=Corte" alt="Corte">
                <div>Corte</div>
                <div class="servico-info">
                    <span>R$30,00</span><span>40min</span>
                </div>
            </div>

            <div class="snap-item" onclick="selecionar(this, 'Barba')">
                <img src="src/img/slotly logo.png?text=Barba" alt="Barba">
                <div>Barba</div>
                <div class="servico-info">
                    <span>R$30,00</span><span>40min</span>
                </div>
            </div>

            <div class="snap-item" onclick="selecionar(this, 'Corte & Barba')">
                <img src="src/img/slotly logo.png?text=Corte+e+Barba" alt="Corte & Barba">
                <div>Corte & Barba</div>
                <div class="servico-info">
                    <span>R$60,00</span><span>40min</span>
                </div>
            </div>
            <div class="snap-item" onclick="selecionar(this, 'Sobrancelha')">
                <img src="src/img/slotly logo.png?text=Corte+e+Barba" alt="Sobrancelha">
                <div>Sobrancelha</div>
                <div class="servico-info">
                    <span>R$15,00</span><span>20min</span>
                </div>
            </div>
            <div class="snap-item" onclick="selecionar(this, 'Hidratação')">
                <img src="src/img/slotly logo.png?text=Corte+e+Barba" alt="Hidratação">
                <div>Hidratação</div>
                <div class="servico-info">
                    <span>R$10,00</span><span>20min</span>
                </div>
            </div>
        </div>

        <div class="dica">ARRASTE PARA O LADO PARA VER MAIS</div>
        <div class="col-5 mx-auto mt-4 d-block gap-2">
            <button class="btn novo"><i class="bi bi-plus-lg"></i> Novo</button>
            <button class="btn editar"><i class="bi bi-pencil-fill"></i> Editar</button>
        </div>

            <h2 class="mb-3 nomenclaturas">SELECIONE UM PROFISSIONAL:</h2>

        <div class="snap-container" id="listaServicos">
            <div class="snap-item" onclick="selecionar(this, 'Corte')">
                <img src="src/img/prestador_alexandre.jpg" alt="Alexandre Alves">
                <div>Alexandre Alves</div>
                <div class="servico-info">
                </div>
            </div>
        </div>

        <div class="dica">ARRASTE PARA O LADO PARA VER MAIS</div>
        <div class="col-5 mx-auto mt-4 d-block gap-2">
            <button class="btn novo"><i class="bi bi-plus-lg"></i> Novo</button>
            <button class="btn editar"><i class="bi bi-pencil-fill"></i> Editar</button>
        </div>
        <button id="enviar" class="btn btn-secondary col-5 mx-auto mt-4 d-block" onclick="enviarServicos()">Enviar</button>

    </div>

    <script>
        const selecionados = [];

        function selecionar(element, nome) {
            element.classList.toggle('selecionado');
            if (selecionados.includes(nome)) {
                selecionados.splice(selecionados.indexOf(nome), 1);
            } else {
                selecionados.push(nome);
            }
        }

        function enviarServicos() {
            if (selecionados.length === 0) {
                alert('Selecione pelo menos um serviço.');
                return;
            }

            alert('Serviços selecionados:\n' + selecionados.join(', '));
            // Aqui você pode enviar via AJAX ou fetch se quiser
        }
    </script>

</body>

</html>


<?php
require_once("rodape.php"); // acaba com o copia e cola quando preciso de comandos repitidos
?>
<?php 
// Inicia a sessão apenas se ainda não estiver ativa
$clienteNome = $_SESSION['nome'] ?? 'Cliente';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o usuário está autenticado
if (!isset($_SESSION['acesso']) || $_SESSION['acesso'] !== true) {
    header("location: index.php?mensagem=acesso_negado");
    exit;
}
?>

<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Slotly</title>

    <!-- Estilos e fontes -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="./src/css/estilos.css">
    <link rel="stylesheet" href="./src/css/cartao.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100..900&family=Raleway:wght@100..900&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Navegação -->
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #428ce2;">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03"
                aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="navbar-brand" href="home.php">
                <img width="125" src="src/img/slotly logo.png" alt="Logo Slotly">
            </a>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link text-light" href="servicos.php">SERVIÇOS</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="agendamentos.php">AGENDAMENTO</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="profissionais.php">PROFISSIONAIS</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="profissional_procedimentos.php">PROFISSIONAIS/SERVIÇOS</a></li>
                    <li class="nav-item"> <a class="nav-link text-light" href="dashboard.php">DASHBOARD</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="contato.php">CONTATO</a></li>
                </ul>
                </ul>

                <!-- Menu do usuário -->
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= htmlspecialchars($_SESSION['usuario']) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="alterar_dados.php">Alterar Dados</a></li>
                            <li><a class="dropdown-item text-danger" href="sair.php">Sair</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container-fluid">

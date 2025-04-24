<?php
//session_start();
//if (!$_SESSION['acesso']) {
    header("location: index.php?mensagem=acesso_negado");
//}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agendamento de Procedimentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #428ce2;">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03"
            aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="index.html"><img width="125" src="src/img/slotly logo.png" alt=""></a>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active text-light" href="pins.html">SERVIÇOS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="meias.html">AGENDAMENTO</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="contato.html">PROFISSIONAIS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="contato.html">CONTATO</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container">
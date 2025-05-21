<?php
//include("cabecalho.php"); // se tiver erro apresenta o erro, e roda o resto que não deu erro
require_once("cabecalho.php"); //se der erro não execulta mais nada, mais seguro
//require_onde verifica se o conteudo ja foi incuido e não repete
?>
<div class="col-5 mt-5 mx-auto">
<h4>Novo Profissional</h4>
<form method="post">
<div class="mb-3">
              <label for="profissional" class="form-label">Informe o Nome do Profissional</label>
              <input type="text" id="profissional" name="profissional" class="form-control">
            </div><div class="mb-3">
              <label for="foto" class="form-label">Inserir Foto do Profissional</label>
              <input type="file" id="foto" name="foto" class="form-control">
            </div><div class="mb-3">
              <label for="especialidades" class="form-label">Especialidades</label>
              <textarea id="especialidades" name="especialidades" class="form-control" rows="4"></textarea>
            </div>
<button type="submit" class="btn btn-primary">Enviar</button>
</form>
</div>
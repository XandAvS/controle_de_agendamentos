<?php
require_once('cabecalho.php');

function retornaDadosUsuario()
{
    require("conexao.php");
    try {

        $sql = "SELECT * FROM usuarios WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['id']]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$usuario) {
            die("Erro ao Consultar Usuário");
        } else {
            return $usuario;
        }
    } catch (Exception $e) {
        die("Erro ao Consultar Usuário" . $e->getMessage());
    }
}

function alterarDadosUsuario($nome, $email)
{
    require("conexao.php");
    try {
        $sql = "UPDATE usuarios SET nome = ?, email = ? WHERE id =?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$nome, $email, $_SESSION['id']]))
            echo "<p class='text-succes'>Dados Alterados Com Sucesso! </p>";
        else
            echo "<p class='text-denger'>Erro ao Alterar Dados! </p>";
    } catch (Exception $e) {
        die("Erro ao Alterar Usuário." . $e->getMessage());
    }
}
function alterarSenha($senhaAntiga, $novaSenha, $novaSenhaConfirm)
{
    require("conexao.php");
    try {
        if ($novaSenha == $novaSenhaConfirm) {
            $usuario = retornaDadosUsuario();
            if (password_verify($senhaAntiga, $usuario['senha'])) {
                $sql = "UPDATE usuarios SET senha = ? WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $novaSenha = password_hash($novaSenha, PASSWORD_BCRYPT);
                if ($stmt->execute([$novaSenha, $_SESSION['id']])) {
                    require("sair.php");
                } else {
                    echo "<p class='text-danger'> Erro ao alterar senha!</p>";
                }
            } else {
                echo "<p class='text-danger'> Senhas não confere</p>";
            }
        }
    } catch (Exception $e) {
        die("Erro ao alterar senha: " . $e->getMessage());
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nome']) && isset($_POST['email'])) {
        alterarDadosUsuario($_POST['nome'], $_POST['email']);
    } else if (isset($_POST['nova_senha'])) {
        alterarSenha($_POST['senha_antiga'], $_POST['nova_senha'], $_POST['nova_senha_confirm']);
    }
}

$usuario = retornaDadosUsuario();
?>
<div class="row">
    <div class="col-5 mt-5 mx-auto">
        <h3>Alteração dos Dados Pessoais</h3>

        <form method="post">

            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Usuário</label>
                <input value="<?= $usuario['nome'] ?>" type="text" id="nome" name="nome" class="form-control">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail do Usuário</label>
                <input value="<?= $usuario['email'] ?>" type="email" id="email" name="email" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>
    <div class="col-5 mt-5 mx-auto">
        <form method="post">
            <div class="mb-3">
                <label for="senha_antiga" class="form-label">Informe a Senha Antiga</label>
                <input type="password" id="senha_antiga" name="senha_antiga" class="form-control">
            </div>

            <div class="mb-3">
                <label for="nova_senha" class="form-label">Informe Nova Senha</label>
                <input type="password" id="nova_senha" name="nova_senha" class="form-control">
            </div>

            <div class="mb-3">
                <label for="nova_senha_confirm" class="form-label">Confirme a Nova Senha</label>
                <input type="password" id="nova_senha_confirm" name="nova_senha_confirm" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>


    </div>
</div>
<?php
require_once('rodape.php');
?>
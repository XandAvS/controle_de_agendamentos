<?php // se o arquivo for só php não se fecha o codigo
declare(strict_types=1);

$dominio = 'mysql:host=localhost;dbname=agendamentophp';
//escrita padrão o que muda é o tipo de banco, e o host, onde ele esta hospedado
$usuario = 'root';
$senha = '';

try{
    $pdo = new PDO($dominio, $usuario, $senha);

} catch(PDOException $e){
    //die corta o resto da pagina se o erro houver
    die("Erro ao conectar com o banco!".$e->getMessage());
}
// no banco de dados
//http://localhost/phpmyadmin/
//vamos em Banco de Dados ou Base de dados
// criamos o banco de dados
// criaremos a nova tabela
// primeiro atributo
// id e marcar o auto incremento
// atributo nome var255
// atributo email var255
// atributo senha var255
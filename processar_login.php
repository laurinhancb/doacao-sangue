<?php 
session_start();
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php?erro=acesso');
    exit();
}

$email = $_POST['email'];
$senha = $_POST['senha'];

try {
    $stmt = $conn->prepare("SELECT * FROM doadores WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() === 1) {
        $doador = $stmt->fetch();

        if (password_verify($senha, $doador['senha'])) {
            // Calcula próxima doação baseada no sexo
            $dias_intervalo = ($doador['sexo'] == 'M') ? 60 : 90;
            $proximaDoacao = date('Y-m-d', strtotime($doador['ultima_doacao'] . " + $dias_intervalo days"));

            // Verifica se pode doar
            // Garanta que está calculando corretamente:
            $podeDoar = (strtotime($doador['proxima_doacao']) <= time());
            $_SESSION['doador']['pode_doar'] = $podeDoar; // Deve ser true/false

            // Armazena dados na sessão
            $_SESSION['doador'] = [
                'id' => $doador['id'],
                'nome' => $doador['nome'],
                'cpf' => $doador['cpf'],
                'sexo' => $doador['sexo'],
                'tipo_sanguineo' => $doador['tiposangue'],
                'data_nascimento' => $doador['data_nasc'],
                'ultima_doacao' => $doador['ultima_doacao'],
                'proxima_doacao' => $proximaDoacao,
                'pode_doar' => $podeDoar,
                'email' => $doador['email'],
                'telefone' => $doador['telefone'],
                'data_cadastro' => $doador['created_at']
            ];

            header('Location: dashboard.php');
            exit();
        }
    }

    header('Location: login.php?erro=credenciais');
    exit();

} catch (PDOException $e) {
    die("Erro ao processar login: " . $e->getMessage());
}
?>
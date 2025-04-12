<?php 
session_start();
require_once 'verifica_login.php';
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Recebe e valida a data do formulário
        $data_agendada = $_POST['data_agendamento'];
        
        // Verifica se a data é válida e futura
        $hoje = new DateTime();
        $dataDoacao = new DateTime($data_agendada);
        
        if ($dataDoacao < $hoje) {
            throw new Exception("A data de doação deve ser futura!");
        }

        // Calcula próxima doação permitida
        $dias_intervalo = ($_SESSION['doador']['sexo'] == 'M') ? 60 : 90;
        $proximaDoacao = clone $dataDoacao;
        $proximaDoacao->add(new DateInterval("P{$dias_intervalo}D"));

        // Atualiza banco de dados
        $stmt = $conn->prepare("UPDATE doadores SET
                              ultima_doacao = :ultima_doacao,
                              proxima_doacao = :proxima_doacao
                              WHERE id = :id");
        
        $stmt->execute([
            ':ultima_doacao' => $dataDoacao->format('Y-m-d'),
            ':proxima_doacao' => $proximaDoacao->format('Y-m-d'),
            ':id' => $_SESSION['doador']['id']
        ]);

        // Atualiza sessão
        $_SESSION['doador']['ultima_doacao'] = $dataDoacao->format('Y-m-d');
        $_SESSION['doador']['proxima_doacao'] = $proximaDoacao->format('Y-m-d');
        $_SESSION['doador']['pode_doar'] = false;

        header('Location: dashboard.php?sucesso=doacao_agendada');
        exit();

    } catch (Exception $e) {
        $erro = $e->getMessage();
    } catch (PDOException $e) {
        $erro = "Erro no banco de dados: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Doação</title>
    <link rel="stylesheet" href="agendar_doacao.css">
</head>
<body>
    <div class="container">
        <h1>Agendar Nova Doação</h1>
        
        <?php if (isset($erro)): ?>
            <div class="error"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>
        
        <form method="post">
            <div class="form-group">
                <label for="data_agendamento">Data desejada para doação:</label>
                <input type="date" 
                    name="data_agendamento" 
                    id="data_agendamento" 
                    min="<?= date('Y-m-d') ?>" 
                    required>
                <small>Selecione uma data futura</small>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn">Confirmar Agendamento</button>
                <a href="dashboard.php" class="btn" style="background-color: #95a5a6;">Cancelar</a>
            </div>
        </form>
    </div>
</body>
<script src="ValidarData.js"></script>
</html>
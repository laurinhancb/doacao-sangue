<?php 
session_start();
require_once 'verifica_login.php';

$doador = $_SESSION['doador'];
$intervalo = ($doador['sexo'] == 'M') ? '60 dias' : '90 dias';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?= htmlspecialchars($doador['nome']) ?></title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="container">
        <h1>Bem-vindo(a), <?= htmlspecialchars($doador['nome']) ?>!</h1>

        <div class="card">
            <h2>Informações Pessoais</h2>
            <div class="info">
                <p><strong>Sexo:</strong> <?= ($doador['sexo'] == 'M') ? 'Masculino' : 'Feminino' ?></p>
                <p><strong>Tipo sanguíneo:</strong> <?= htmlspecialchars($doador['tipo_sanguineo']) ?></p>
                <p><strong>CPF:</strong> <?= htmlspecialchars($doador['cpf']) ?></p>
                <p><strong>Data de nascimento:</strong> <?= date('d/m/Y', strtotime($doador['data_nascimento'])) ?></p>
                <p><strong>Telefone:</strong> <?= htmlspecialchars($doador['telefone']) ?></p>
            </div>
        </div>

        <div class="card">
            <h2>Histórico de Doações</h2>
            <div class="info">
                <?php if (!empty($doador['ultima_doacao'])): ?>
                    <p><strong>Última doação:</strong> <?= date('d/m/Y', strtotime($doador['ultima_doacao'])) ?></p>
                    <p><strong>Intervalo necessário:</strong> <?= $intervalo ?></p>
                    <p><strong>Próxima doação possível:</strong> <?= date('d/m/Y', strtotime($doador['proxima_doacao'])) ?></p>
                    
                    <?php 
                    $dataProxima = new DateTime($doador['proxima_doacao']);
                    $hoje = new DateTime();
                    $podeDoarAgora = $dataProxima <= $hoje;
                    ?>
                    
                    <?php if ($podeDoarAgora): ?>
                        <a href="agendar_doacao.php" class="btn" style="display: inline-block; margin-top: 10px;">
                            Agendar Nova Doação
                        </a>
                    <?php else: ?>
                        <p class="aviso" style="color: #666; font-style: italic;">
                            Você poderá doar novamente após <?= date('d/m/Y', strtotime($doador['proxima_doacao'])) ?>
                        </p>
                    <?php endif; ?>
                    
                <?php else: ?>
                    <p>Você ainda não realizou doações</p>
                    <a href="agendar_doacao.php" class="btn" style="display: inline-block; margin-top: 10px;">
                        Agendar Primeira Doação
                    </a>
                <?php endif; ?>
            </div>
        </div><br>

        <a href="logout.php" class="btn btn-sair">Sair do Sistema</a>
    </div>
</body>
</html>
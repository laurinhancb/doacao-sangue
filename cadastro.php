<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Doador</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include_once('conexao.php') ?>
    <div class="container">
    <h1>Faça seu cadastro</h1>
    <?php include_once('processar_cadastro.php') ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-layout">
        <div class="input-row">
        <div class="form-group double-line">
            <div>
                <label for="nome">Nome Completo</label>
                <input type="text" id="nome" name="name" placeholder="Digite seu nome" required>
            </div>
            <div>
                <label for="sexo">Sexo</label>
                <select id="sexo" name="sexo" required>
                    <option value="">Selecione seu sexo</option>
                    <option value="M">Masculino</option>
                    <option value="F">Feminino</option>
                </select>
            </div>
        </div>

    <!-- DATA NASCIMENTO + SEXO (mesma linha) -->
    <div class="form-group double-line">
        <div>
            <label for="nascimento">Data de Nascimento</label>
            <input type="date" id="nascimento" name="data_nasc" required>
        </div>
        <div>
            <label for="tipo-sanguineo">Tipo Sanguíneo</label>
            <select id="tipo-sanguineo" name="tiposangue" required>
                <option value="">Selecione seu tipo sanguíneo</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>
        </div>
    </div>

    <!-- CPF + TELEFONE (mesma linha) -->
    <div class="form-group double-line">
        <div>
            <label for="cpf">CPF</label>
            <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" required>
        </div>
        <div>
            <label for="telefone">Telefone</label>
            <input type="tel" id="telefone" name="tel" placeholder="(00) 00000-0000" required>
        </div>
    </div>

    <!-- EMAIL (linha única) -->
    <div class="form-group single-line">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" placeholder="nome@email.com" required>
    </div>

    <!-- SENHA + CONFIRMAR SENHA (mesma linha) -->
    <div class="form-group double-line">
        <div>
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" placeholder="Crie uma senha" required>
        </div>
        <div>
            <label for="confirmar-senha">Confirmar Senha</label>
            <input type="password" id="confirmar-senha" name="confirmarsenha" placeholder="Confirme sua senha" required>
        </div>
    </div>

    <p>Faça seu <a href="login.php">login!</a></p>

    <button type="submit">Cadastrar</button>
    </form>
    </div>

</body>
<script src="FormatarCPF.js"></script>
<script src="FormatarTel.js"></script>
</html>
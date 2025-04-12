<?php 
// Processar formulário quando enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Coletar e sanitizar dados do formulário
        $nome = htmlspecialchars($_POST['name']);
        $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf']); // Remove formatação do CPF (só números)
        $data_nasc = htmlspecialchars($_POST['data_nasc']);
        $telefone = htmlspecialchars($_POST['tel']);
        $tiposangue = htmlspecialchars($_POST['tiposangue']);
        $email = htmlspecialchars($_POST['email']);
        $sexo = htmlspecialchars($_POST['sexo']);
        
        // Verificar se as senhas coincidem
        if ($_POST['senha'] !== $_POST['confirmarsenha']) {
            throw new Exception("As senhas não coincidem!");
        }
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        // VERIFICAÇÃO CORRIGIDA DO CPF
        $verifica_cpf = $conn->prepare("SELECT id FROM doadores WHERE cpf = :cpf");
        $verifica_cpf->bindParam(':cpf', $cpf);
        $verifica_cpf->execute();
        
        if ($verifica_cpf->rowCount() > 0) {
            throw new Exception("CPF já cadastrado em nosso sistema!");
        }

        // Inserção corrigida
        $sql = "INSERT INTO doadores (nome, cpf, data_nasc, telefone, tiposangue, email, senha, sexo, ultima_doacao, proxima_doacao, created_at)
                VALUES (:nome, :cpf, :data_nasc, :telefone, :tiposangue, :email, :senha, :sexo, NULL, NULL, NOW())";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':nome' => $nome, 
            ':cpf' => $cpf,
            ':data_nasc' => $data_nasc,
            ':telefone' => $telefone,
            ':tiposangue' => $tiposangue,
            ':email' => $email,
            ':senha' => $senha,
            ':sexo' => $sexo
        ]);
        
        if ($stmt->rowCount() > 0) {
            header("Location: ".$_SERVER['PHP_SELF']."?success=1");
            exit();
        } else {
            throw new Exception("Erro ao cadastrar. Por favor, tente novamente.");
        }
        
    } catch (PDOException $e) {
        // Mensagem mais detalhada para debug
        $erro = "Erro no banco de dados: " . $e->getMessage();
        if ($e->errorInfo[1] == 1062) { // Erro de duplicidade
            $erro = "Este CPF já está cadastrado em nosso sistema!";
        }
        echo "<div class='error-message'>$erro</div>";
        // Adicione para debug (remova depois)
        echo "<div class='error-message'>CPF submetido: $cpf</div>";
    } catch (Exception $e) {
        echo "<div class='error-message'>".$e->getMessage()."</div>";
    } finally {
            $conn = null;
        }
    }

    // Mostrar mensagem de sucesso após redirecionamento
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo "<div class='success-message' id='success-msg'>Cadastro realizado com sucesso!</div>";
        echo "<script>
                setTimeout(function() {
                    document.getElementById('success-msg').style.display = 'none';
                }, 3000);
              </script>";
    }
    ?>
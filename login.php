<?php
session_start(); 
include 'conexao.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $email = $_POST["email"]; 
    $senha = $_POST["senha"]; 
    $erros = []; 

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = "e-mail inválido!"; 
    }

    if (empty($senha)) {
        $erros[] = "a senha não pode estar vazia!"; 
    }

    if (empty($erros)) {
        $stmt = $conn->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email); 
        $stmt->execute(); 
        $stmt->store_result(); 

        if ($stmt->num_rows > 0) { 
            $stmt->bind_result($id, $nome, $senha_hash); 
            $stmt->fetch(); 

            if (password_verify($senha, $senha_hash)) {
                $_SESSION['usuario_id'] = $id;
                $_SESSION['usuario_nome'] = $nome;
                header("Location: principal.php"); 
                exit; 
            } else {
                echo "<p style='color: red;'>senha incorreta!</p>";
            }
        } else {
            echo "<p style='color: red;'>usuário não encontrado!</p>"; 
        }

        $stmt->close(); 
    } else {
        foreach ($erros as $erro) {
            echo "<p style='color: red;'>$erro</p>";
        }
    }
}
?>
<!-- formulário de login -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="CSS/style.css">
<form method="POST">
<h1>login</h1>
    <input type="email" name="email" placeholder="e-mail" required><br>
<div class="input-container">
    <input type="password" name="senha" id="senha" placeholder="senha" required>
    <i class="fas fa-eye toggle-eye" onclick="toggleSenha('senha', this)"></i> 
</div>

<script>
// mostrar e esconder a senha
function toggleSenha(id, icon) {
    const input = document.getElementById(id); 
    if (input.type === "password") {
        input.type = "text"; 
        icon.classList.remove("fa-eye"); 
        icon.classList.add("fa-eye-slash");
    } else { 
        input.type = "password"; 
        icon.classList.remove("fa-eye-slash"); 
        icon.classList.add("fa-eye");
    }
}
</script>

    <input type="submit" value="entrar"><br><br>
    <a href="cadastro.php"><button type="button">fazer cadastro</button></a> 
</form>

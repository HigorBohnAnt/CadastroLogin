<?php
include 'conexao.php'; 

function validar_cpf($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', $cpf); // remove caracteres 
    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) return false; // verifica se o cpf é válido
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) $d += $cpf[$c] * (($t + 1) - $c); // calcula os dígitos de verificação
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) return false; 
    }
    return true; 
}

$erros = []; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // obtém os dados do formulário
    $nome     = $_POST["nome"];
    $email    = $_POST["email"];
    $cpf      = $_POST["cpf"];
    $rg       = $_POST["rg"];
    $celular  = $_POST["celular"];
    $senha    = $_POST["senha"];
    $confirmar= $_POST["confirmar"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = "email inválido!";
    }

    if (!validar_cpf($cpf)) {
        $erros[] = "cpf inválido!";
    }
    // verifica se o rg é válido
    if (!preg_match("/^[0-9]{7,}$/", preg_replace('/[^0-9]/', '', $rg))) {
        $erros[] = "rg inválido!";
    }
    // verifica se o celular é válido
    if (!preg_match("/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/", $celular)) {
        $erros[] = "celular inválido!";
    }

    if (strlen($senha) < 8) {
        $erros[] = "a senha deve ter no mínimo 8 caracteres!";
    }

    if ($senha != $confirmar) {
        $erros[] = "senhas não coincidem!";
    }

    if (empty($erros)) {
        $verifica = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $verifica->bind_param("s", $email);
        $verifica->execute();
        $verifica->store_result();

        if ($verifica->num_rows > 0) {
            $erros[] = "este e-mail já está cadastrado!";
        } else {

            $hash = password_hash($senha, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, cpf, rg, celular, senha) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $nome, $email, $cpf, $rg, $celular, $hash);
            if ($stmt->execute()) {
                echo "<script>alert('cadastro realizado com sucesso! redirecionando para o login.'); window.location.href='login.php';</script>";
                exit;
            } else {
                $erros[] = "erro no cadastro: " . $stmt->error;
            }
            $stmt->close(); 
        }
        $verifica->close(); 
    }

    foreach ($erros as $erro) {
        echo "<p style='color: red;'>$erro</p>";
    }
}
?>

<!-- formulário de cadastro -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="CSS/style.css">
<form method="POST">
<h1>cadastrar</h1>
    <!-- campos do formulário -->
    <input type="text" name="nome" placeholder="nome" required><br>
    <input type="email" name="email" placeholder="e-mail" required><br>
    <input type="text" name="cpf" placeholder="cpf" required id="cpf"><br>
    <input type="text" name="rg" placeholder="rg" required id="rg"><br>
    <input type="text" name="celular" placeholder="(00)00000-0000" required id="celular"><br>
    
    <!-- campos de senha e confirmação -->
    <div class="input-container">
    <input type="password" id="senha" name="senha" placeholder="senha (mínimo 8 caracteres)" required>
    <i class="fas fa-eye toggle-eye" onclick="toggleSenha('senha', this)"></i>
</div>

<div class="input-container">
    <input type="password" id="confirmar" name="confirmar" placeholder="confirmar senha" required>
    <i class="fas fa-eye toggle-eye" onclick="toggleSenha('confirmar', this)"></i>
</div>

<script>
// função para mostrar ocultar as senhas
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

    <input type="submit" value="cadastrar"><br><br>

    <a href="login.php"><button type="button">já tenho uma conta</button></a>
</form>

<script>
//  formatar os campos de cpf, rg e celular
function formatCPF(value) {
    value = value.replace(/\D/g, "").slice(0, 11);
    return value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
}
function formatRG(value) {
    return value.replace(/\D/g, "").slice(0, 10);
}
function formatPhone(value) {
    value = value.replace(/\D/g, "").slice(0, 11);
    return value.replace(/(\d{2})(\d{5})(\d{4})/, "($1) $2-$3");
}
// adiciona os eventos de formatação
document.getElementById('cpf').addEventListener('input', function () {
    this.value = formatCPF(this.value);
});
document.getElementById('rg').addEventListener('input', function () {
    this.value = formatRG(this.value);
});
document.getElementById('celular').addEventListener('input', function () {
    this.value = formatPhone(this.value);
});
</script>
                <!-- não mexa, não sei como isso está funcionando, se mexer = 💀 -->
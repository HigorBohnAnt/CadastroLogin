<?php
session_start();

// verifica se o usuário é real
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$nome = $_SESSION['usuario_nome']; 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Bem-vindo</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #2fdfeb, #590c8d);
            padding: 30px;
            color: #333;
        }

        .container {
            max-width: 800px;
            background-color: #ffffff;
            border: 3px solid #5b86e5;
            padding: 30px;
            margin: auto;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #222;
            margin-bottom: 20px;
        }

        h2 i {
            margin-right: 10px;
            color: #6c63ff;
        }

        p {
            margin-bottom: 10px;
            line-height: 1.6;
        }

        .tech-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }

        .tech-box {
            flex: 1 1 45%;
            background-color: #f9f9f9;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 20px;
            cursor: pointer;
            transition: 0.3s;
            position: relative;
        }

        .tech-box:hover {
            background-color: #f1f1f1;
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .tech-box i {
            font-size: 24px;
            margin-right: 10px;
        }

        .icon-php {
            color: #8892be;
        }

        .icon-mysql {
            color: #00758f;
        }

        .icon-html {
            color: #e34c26;
        }

        .icon-css {
            color: #264de4;
        }

        .icon-js {
            color: #f7df1e;
        }

        .tech-description {
            overflow: hidden;
            max-height: 0;
            opacity: 0;
            transition: max-height 0.5s ease, opacity 0.5s ease;
            font-size: 14px;
            margin-top: 10px;
            color: #444;
            text-align: justify; 
        }

        .tech-description.show {
            max-height: 200px;
            opacity: 1;
        }

        .logout-btn {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 20px;
            background-color:#590c8d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background-color:#590c8d;
        }

        .logout-btn i {
            margin-right: 5px;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2><i class="fas fa-user"></i> Bem-vindo, <?php echo htmlspecialchars($nome); ?>!</h2>

        <p>Este sistema foi desenvolvido como parte do meu portfólio, com o objetivo de demonstrar minhas habilidades em desenvolvimento web.</p>
        <p>Clique em uma tecnologia para saber mais:</p>

        <div class="tech-container">
            <div class="tech-box" onclick="toggleDesc('php')">
                <i class="fab fa-php icon-php"></i> <strong>PHP</strong>
                <div id="desc-php" class="tech-description">
                No projeto, o PHP é utilizado para gerenciar o backend, realizando login seguro com verificação de credenciais e hash de senhas. Ele também manipula sessões para proteger páginas restritas e exibe informações personalizadas, como o nome do usuário logado, além de redirecionar usuários não autenticados para a página de login.</div>
            </div>

            <div class="tech-box" onclick="toggleDesc('mysql')">
                <i class="fas fa-database icon-mysql"></i> <strong>MySQL</strong>
                <div id="desc-mysql" class="tech-description">
                O MySQL foi usado para armazenar os dados dos usuários, como nome, e-mail, CPF, RG, celular e senha. Ele gerencia o processo de login, verificando as credenciais dos usuários no banco de dados para autenticação.</div>
            </div>

            <div class="tech-box" onclick="toggleDesc('html')">
                <i class="fab fa-html5 icon-html"></i> <strong>HTML</strong>
                <div id="desc-html" class="tech-description">
                O HTML foi usado para estruturar o conteúdo e os elementos do site, como formulários de cadastro e login, botões, campos de entrada e seções de texto.</div>
            </div>

            <div class="tech-box" onclick="toggleDesc('css')">
                <i class="fab fa-css3-alt icon-css"></i> <strong>CSS</strong>
                <div id="desc-css" class="tech-description">
                O CSS foi usado para estilizar o layout das páginas, definindo cores, fontes, margens, alinhamentos e tornando o site responsivo para diferentes dispositivos. Além disso, utilizou-se a biblioteca <strong>Tailwind CSS</strong> para facilitar a criação de estilos responsivos e modernos com utilitários prontos, além de garantir a flexibilidade e agilidade no design do site.</div>
                </div>

            <div class="tech-box" onclick="toggleDesc('js')">
                <i class="fab fa-js-square icon-js"></i> <strong>JavaScript</strong>
                <div id="desc-js" class="tech-description">
                O JavaScript foi usado para adicionar interatividade no site, como a exibição dinâmica de informações e validação de formulários. Ele também foi responsável por efeitos visuais e funcionalidades como a alternância de visibilidade das senhas no login e cadastro.</div>
            </div>
        </div>

        <p style="margin-top: 20px;">Este é um exemplo funcional de sistema com cadastro, login, segurança com hash de senhas e sessões protegidas.</p>

        <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Sair</a>
    </div>

    <script>
        // visibilidade das tecnologias
        function toggleDesc(tech) {
            const desc = document.getElementById('desc-' + tech); 
            const isVisible = desc.classList.contains('show'); 

            document.querySelectorAll('.tech-description').forEach(el => el.classList.remove('show'));

            if (!isVisible) {
                desc.classList.add('show'); 
            }
        }
    </script>
</body>
</html>

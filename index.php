<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
$conn = new mysqli('localhost', 'root', '', 'meu_banco_de_dados');

// Excluir tokens expirados
$sqlExcluir = "DELETE FROM logins WHERE expiracao < NOW()";
$conn->query($sqlExcluir);

// Verificar se o usuário está logado
if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
    $email = $_SESSION['email'];
    $token = $_SESSION['token'];

    // Verifica se o token ainda é válido
    $sql = "SELECT expiracao FROM logins WHERE user_name = '$email' AND token = '$token'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $expiracao = $row['expiracao'];

        // Verifica se o token expirou
        if (strtotime($expiracao) < time()) {
            
            $sqlAlter = "UPDATE usuarios SET status_ativo = 0, ultima_vez_visto = NOW() WHERE email = ?";
            $conn->query($sqlAlter);

            if ($conn->query($sqlAlter) === TRUE) {
                 session_destroy();
                 header("Location: ../LOGIN/login.html?mensagem=Sua-sessão-expirou,-faça--LOGIN--novamente.");
                  exit();
            }
        } else {
            // Token ainda é válido, então renovar o tempo de expiração
            $novaExpiracao = date('Y-m-d H:i:s', strtotime('+10 minutes'));
            $sqlRenovar = "UPDATE logins SET expiracao = '$novaExpiracao' WHERE user_name = '$email' AND token = '$token'";
            $conn->query($sqlRenovar);
            
            // Teste seesion
            $Bemvindo = "Bem-vindo, " . $_SESSION['nome'] . "!" . $_SESSION['cpf'] . "," . $_SESSION['fotoperfil'];
        }
    } else {
        // Token inválido, deslogar
        session_destroy();
        header("Location: ../LOGIN/login.html?mensagem=Token inválido, faça login novamente.");
        exit();
    }
} else {
    // Usuário VisitanZXte, Deslogado
    $okfe5 = 'Modo Visitante';
    
}
?>





<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>PetZone - Clínica Veterinária</title>
    <link rel="stylesheet" href="style.css">
   
    <script defer src="script.js"></script>
</head>
<body>

    <header class="cabecalho">
        
         <button id="button-barra">
                 <i class="bi bi-list"></i>
         </button>

         <div class="logo">
         <img src="IMAGENS/logoborda.png" alt="Logo PetZone" title="logo da empresa">
         </div>

        <nav class="menu">
            <ul>
                <li><a href="#home">HOME</a></li>
                <li><a href="#sobre">QUEM SOMOS</a></li>
                <li><a href="#servicos">NOSSOS SERVIÇOS</a></li>
                <li><a href="#contato">CONTATO</a></li>
                <li><a href="#faq">FAQ</a></li>
            </ul>
        </nav>
        <div class="login-usuario">
        
    <?php
    
    // Verifica se a sessão do perfil do usuário está definida (usuário logado)
    if (isset($_SESSION['fotoperfil'])) {
        $imagem = $_SESSION['fotoperfil'];
        echo "<img class='img-logado' src='../CADASTRO/$imagem' alt='Imagem de perfil do usuário' height='300'>";
    } else {
        // Exibe uma imagem padrão caso o usuário não esteja logado
        echo "<img src='IMAGENS/login.jpg' alt='Logo PetZone' title='Logo usuario deslogado!'>";
    }
    ?>


            <div id="user-info">
                <?php if(isset($_SESSION['nome']) && isset($_SESSION['email'])): ?>
                    <?php if ($_SESSION['perfil'] === 'master'): ?>
                      <p>Olá, Admin!</p>
                      <button onclick="location.href='../MASTER/AREA DO ADM/master.php'">Tela de Log</button>
                    <?php else: ?>
                        <p>Bem-vindo, </p>
                    <?php endif; ?>
                    <p><span><?php echo htmlspecialchars($_SESSION['nome']); ?></span>!</p>
                    <!-- <p>Email: <?php /* echo htmlspecialchars($_SESSION['email']); */ ?></p> -->
                    <button onclick='window.location.href="../PERFIL/perfil.php"'> Ver perfil </button>
                    <form action="backend-sitecompleto/logout.php" method="POST">
                        <button type="submit" style="width: 120px; margin-top: 10px;">Sair</button>
                    </form>
                <?php else: ?>
                    <p class="bn-v">Bem-vindo, Visitante!</p>
                    <button><a href="../LOGIN/login.html">Faça login</button> <p>ou</p> <button> <a href="../CADASTRO/cadastro.html">Cadastre-se</a></button>
                <?php endif; ?>
            </div>
        </div>
       
        </div>
        </div>
        <div class="acessibilidade">
            <button id="botao-tema"><i class="bi bi-brightness-high"></i></button>
            <button id="aumentar-fonte">A+</button>
            <button id="diminuir-fonte">A-</button>
        </div>
    </header>

    <nav class="cabecalho-r">
   
         <div class="r-home">
          <div class="logo">
              <figure>
                <img src="IMAGENS/logoborda.png" alt="Logo PetZone" height="20">
              </figure>
           </div>
           <div class="r-hometext">
                    <p><a href="../PERFIL/perfil.php">Ver Perfil</a></p>
                    <form action="backend-sitecompleto/logout.php" method="POST">
                        <button type="submit">Sair <i class="bi bi-person-dash"></i></button>
                    </form>
            </div>
       </div>
        <nav class="menu">
            <ul>
                <li><a href="#home">HOME</a></li>
                <li><a href="#sobre">QUEM SOMOS</a></li>
                <li><a href="#servicos">NOSSOS SERVIÇOS</a></li>
                <li><a href="../AGENDAMENTO/agendamento.php" target="_blank" rel="noopener noreferrer">AGENDAR AGORA</a></li>
                <li><a href="#contato">CONTATO</a></li>
                <li><a href="#faq">FAQ</a></li>
            </ul>
        </nav>
        
        <p style="font-size: 11px;">PetZone &copy 2024 e todos os direitos reservados</p>
    
        <a href="#servicos" class="botao-sobre">Conheça</a>
    
    </nav>

    <div class="conteudo-principal" id="home">
        <div class="carrossel">
            <div class="slide ativo" style="background-image: url('IMAGENS/carrossel1.jpg');"></div>
            <div class="slide" style="background-image: url('IMAGENS/carrossel2.jpg');"></div>
            <div class="slide" style="background-image: url('IMAGENS/carrossel3.jpg')"></div>
        </div>
        <div class="bem-vindo">
            <br><br><br>
            <h1>Bem-vindo à PetZone</h1>
            <p>A melhor clínica veterinária para o seu pet.</p>
            <br><br><br>
            <a href="#servicos" class="botao-confira">Confira nossos serviços</a>
        </div>
    </div>
    
    <div class="quem-somos" id="sobre">
        <div class="imagem-sobre">
            <img src="IMAGENS/sobrenos.jpg" alt="Imagem da Clínica Veterinária">
        </div>
        <div class="texto-sobre">
            <h2>Quem Somos</h2>
            <p>
                A <strong>PetZone</strong> é uma clínica veterinária dedicada ao bem-estar e saúde dos seus pets. Fundada em 2024, nossa missão é proporcionar o melhor atendimento e cuidado, utilizando tecnologias avançadas e uma equipe altamente qualificada.
            </p>
            <p>
                Nossos valores incluem o respeito, a ética e o compromisso com a vida animal. Cada pet que atendemos é tratado com carinho e atenção, porque acreditamos que eles merecem o melhor cuidado possível.
            </p>
            <p>
                Conheça nossa equipe de veterinários especializados, prontos para cuidar de seu pet com toda a dedicação que ele merece.
            </p>
            <a href="#" class="botao-sobre">Saiba Mais</a>
        </div>
    </div>
    
    <div id="servicos" class="nossos-servicos">
        <h2>Nossos Serviços</h2>
        <p>Na PetZone, oferecemos uma ampla gama de serviços para garantir a saúde e o bem-estar do seu pet.</p>
        
        <div class="lista-servicos">
            <div class="servico">
                <h3>Consultas </h3>
                <p>Oferecemos consultas gerais e especializadas com veterinários experientes.</p>
            </div>
            <div class="servico">
                <h3>Vacinação</h3>
                <p>Mantenha o seu pet protegido com nosso serviço completo de vacinação.</p>
            </div>
            <div class="servico">
                <h3>Cirurgias</h3>
                <p>Realizamos cirurgias com técnicas avançadas e cuidados pré e pós-operatórios.</p>
            </div>
            <div class="servico">
                <h3>Exames Laboratoriais</h3>
                <p>Diagnóstico preciso com exames laboratoriais de alta qualidade.</p>
            </div>
        </div>
    
        <div class="call-to-action">
            <a href="../AGENDAMENTO/agendamento.php" class="botao-agende">Agende Agora</a>
        </div>
    </div>
    
    <div id="contato" class="contato">
        <h2>Contato</h2>
        <p>Entre em contato com a PetZone para esclarecer suas dúvidas. Estamos aqui para ajudar!</p>
    
        <!-- Mapa em um retângulo no topo -->
        <div class="mapa-contato">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3675.8001915632554!2d-43.20650298493746!3d-22.91230838500461!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x997fd5981773c1%3A0x57f29770fd6fa64b!2sPra%C3%A7a%20Marechal%20%C3%82ncora%20-%20Centro%2C%20Rio%20de%20Janeiro%20-%20RJ%2C%2020090-070%2C%20Brasil!5e0!3m2!1spt-BR!2sus!4v1646124588890!5m2!1spt-BR!2sus" 
                    width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    
        <div class="informacoes-contato">
            <!-- Coluna da esquerda: Informações de Contato -->
            <div class="detalhes-contato">
                <h3>Informações de Contato</h3>
                <p><strong>Telefone:</strong> (21) 98762-7653</p>
                <p><strong>E-mail:</strong> contato@petzone.com</p>
                <p><strong>Endereço:</strong> Praça Marechal Âncora - Centro, Rio de Janeiro - RJ</p>
                <p><strong>Horário de Funcionamento:</strong></p>
                <p>Segunda a Sexta: 8h - 20h</p>
                <p>Sábado: 9h - 17h</p>
            </div>
    
            <!-- Coluna da direita: Formulário de Contato -->
            <div class="formulario-contato">
                <h3>Envie uma mensagem</h3>
                <form action="#" method="post">
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" name="nome" required>
                    
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" required>
                    
                    <label for="telefone">Telefone</label>
                    <input type="tel" id="telefone" name="telefone" required>
                    
                    <label for="mensagem">Mensagem</label>
                    <textarea id="mensagem" name="mensagem" rows="3" required></textarea>
                    
                    <button type="submit" class="botao-enviar">Enviar</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="faq" id="faq">
        <h1>FAQ - Perguntas Frequentes</h1>
    
        <div class="perguntas-container">
            <div class="pergunta" onclick="toggleResposta(this)">
                <span>Quais serviços a clínica oferece?</span>
                <span class="seta">▼</span>
            </div>
            <div class="resposta">
                Oferecemos consultas, vacinação, exames e cirurgias.
            </div>
    
            <hr>
    
            <div class="pergunta" onclick="toggleResposta(this)">
                <span>Qual o horário de funcionamento?</span>
                <span class="seta">▼</span>
            </div>
            <div class="resposta">
                Funcionamos de segunda a sexta, das 8h às 20h, e aos sábados, das 9h às 17h.
            </div>
    
            <hr>
    
            <div class="pergunta" onclick="toggleResposta(this)">
                <span>É necessário agendar consultas com antecedência?</span>
                <span class="seta">▼</span>
            </div>
            <div class="resposta">
                Sim, recomendamos agendar com antecedência para garantir atendimento rápido e eficiente.
            </div>
    
            <hr>
    
            <div class="pergunta" onclick="toggleResposta(this)">
                <span>Como funciona o pagamento?</span>
                <span class="seta">▼</span>
            </div>
            <div class="resposta">
                Feito somente presencialmente. 
            </div>
    
            <hr>
    
            <div class="pergunta" onclick="toggleResposta(this)">
                <span>Quais formas de pagamento são aceitas?</span>
                <span class="seta">▼</span>
            </div>
            <div class="resposta">
                Aceitamos dinheiro, cartões de crédito, débito, transferências bancárias e pagamentos via Pix.
            </div>
    
            <hr>
    
            <div class="pergunta" onclick="toggleResposta(this)">
                <span>A clínica oferece atendimento a domicílio?</span>
                <span class="seta">▼</span>
            </div>
            <div class="resposta">
                Sim, realizamos visitas a domicílio para casos específicos. Por favor, entre em contato para mais informações.
            </div>
        </div>
    </div>
    
    

    <footer class="rodape">
        <p>&copy; 2024 PetZone. Todos os direitos reservados.</p>
        <h3>Redes Sociais</h3>
        <div class="redes-sociais">
            <a href="#"><img src="IMAGENS/facebook-icon.png" alt="Facebook"></a>
            <a href="#"><img src="IMAGENS/instagram-icon.jpg" alt="Instagram"></a>
        </div>
    </footer>

    <script>

window.addEventListener('unload', function() {
    
    navigator.sendBeacon('backend-sitecompleto/atualizar_status.php', JSON.stringify({status: 0}));
});

window.addEventListener('load', function() {
    
    navigator.sendBeacon('backend-sitecompleto/atualizar_status_load.php', JSON.stringify({status: 0}));
});
</script>

</body>
</html>

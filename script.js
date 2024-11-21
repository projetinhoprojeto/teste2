

let fontSize = 16; // Tamanho de fonte padrão

document.getElementById('aumentar-fonte').addEventListener('click', function() {
    if (fontSize < 30) {
    fontSize += 2;
    document.body.style.fontSize = fontSize + 'px';
    }
});

document.getElementById('diminuir-fonte').addEventListener('click', function() {
    if (fontSize > 10) { // Limite mínimo para evitar texto muito pequeno
        fontSize -= 2;
        document.body.style.fontSize = fontSize + 'px';
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.slide');
    let currentSlide = 0;
    const slideInterval = setInterval(nextSlide, 5000); // Troca a cada 5 segundos

    function nextSlide() {
        slides[currentSlide].classList.remove('ativo');
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.add('ativo');
    }
});


function toggleResposta(perguntaElement) {
    const respostaElement = perguntaElement.nextElementSibling;
    const setaElement = perguntaElement.querySelector('.seta');

    if (respostaElement.style.display === "block") {
        respostaElement.style.display = "none";
        setaElement.style.transform = "rotate(0deg)";
    } else {
        respostaElement.style.display = "block";
        setaElement.style.transform = "rotate(180deg)";
    }
}

// Seleciona o botão de tema e o corpo do documento
let tema = document.getElementById('botao-tema');

// Função para aplicar o tema com base no localStorage
function aplicarTema() {
    if (localStorage.getItem('tema') === 'escuro') {
        document.body.classList.add('tema-escuro');
        tema.innerHTML = '<i class="bi bi-moon-stars"></i>';
    } else {
        document.body.classList.remove('tema-escuro');
        tema.innerHTML = '<i class="bi bi-brightness-high"></i>';
    }
}


aplicarTema();


tema.addEventListener('click', function () {
    document.body.classList.toggle('tema-escuro');
    
    
    if (document.body.classList.contains('tema-escuro')) {
        tema.innerHTML = '<i class="bi bi-moon-stars"></i>';
        localStorage.setItem('tema', 'escuro');  // Salva o tema escuro no localStorage
    } else {
        tema.innerHTML = '<i class="bi bi-brightness-high"></i>';
        localStorage.setItem('tema', 'claro');  // Salva o tema claro no localStorage
    }
});



let buttonR = document.getElementById('button-barra');
let cabecalhoR = document.getElementsByClassName('cabecalho-r')[0];

buttonR.addEventListener('click', function () {

 cabecalhoR.classList.toggle('ativar');


if (cabecalhoR.classList.contains('ativar')) {
      buttonR.innerHTML = '<i class="bi bi-x" style="color: red;"></i>';
} else {
     buttonR.innerHTML = '<i class="bi bi-list"></i>';
}
}); 



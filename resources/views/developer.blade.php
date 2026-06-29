<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Developer</title>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body { background:#1b2838; color:white; }
    .navbar { background:#171a21; }
    .nav-actions { margin-left:auto; display:flex; align-items:center; gap:.5rem; flex-wrap:wrap; }
    .banner { padding:70px 20px; text-align:center; }
    .card { background:#2a475e; color:white; border:0; transition:.25s; height:100%; }
    .card:hover { transform:scale(1.02); }
    .game-img { width:100%; height:320px; object-fit:cover; background:#111827; }
    .box { background:#2a475e; padding:30px; border-radius:10px; margin-top:30px; }
    .form-control, .form-select { background:#f8f9fa; }
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="/">🎮 GameStore</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarGameStore">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarGameStore">
            <div class="nav-actions">
                <a href="/" class="btn btn-outline-light btn-sm">Home</a>
                <a href="/carrinho" class="btn btn-outline-light btn-sm">Carrinho</a>
                <a href="/biblioteca" class="btn btn-outline-light btn-sm">Biblioteca</a>
                <a href="/developer" class="btn btn-outline-light btn-sm">Developer</a>
                <span id="authArea"></span>
            </div>
        </div>
    </div>
</nav>

<main class="container pb-5">
    <div class="box">
        <h1>Painel do Desenvolvedor</h1>
        <p>Cadastre um jogo aqui para ele aparecer automaticamente na página inicial.</p>

        <form id="formDeveloper" onsubmit="publicarJogo(event)">
            <div class="mb-3">
                <label class="form-label">Nome do jogo</label>
                <input id="nome" class="form-control" placeholder="Ex: Space Adventure" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Categoria</label>
                <select id="categoria" class="form-select" required>
                    <option>Ação</option>
                    <option>Aventura</option>
                    <option>RPG</option>
                    <option>Terror</option>
                    <option>Estratégia</option>
                    <option>Esporte</option>
                    <option>Simulação</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">URL da imagem</label>
                <input id="imagem" class="form-control" placeholder="https://site.com/imagem.jpg" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Preço</label>
                <input id="preco" class="form-control" placeholder="59,90" required>
            </div>

            <button class="btn btn-success">Publicar Jogo</button>
            <a href="/" class="btn btn-outline-light ms-2">Ver na Home</a>
        </form>
    </div>

    <section class="mt-5">
        <h2>Jogos publicados pelo Developer</h2>
        <div class="row" id="listaDeveloper"></div>
    </section>
</main>

<script>
function jogosDeveloper(){
    return JSON.parse(localStorage.getItem('jogos')) || [];
}

function salvarJogosDeveloper(jogos){
    localStorage.setItem('jogos', JSON.stringify(jogos));
}

function publicarJogo(event){
    event.preventDefault();

    const novoJogo = {
        nome: document.getElementById('nome').value.trim(),
        categoria: document.getElementById('categoria').value.trim(),
        imagem: document.getElementById('imagem').value.trim(),
        preco: precoNumero(document.getElementById('preco').value)
    };

    if(!novoJogo.nome || !novoJogo.imagem){
        alert('Preencha o nome e a URL da imagem.');
        return;
    }

    const jogos = jogosDeveloper();
    jogos.push(novoJogo);
    salvarJogosDeveloper(jogos);

    document.getElementById('formDeveloper').reset();
    renderDeveloper();
    alert('Jogo publicado com sucesso! Ele já aparecerá na página inicial.');
}

function excluirJogoDeveloper(indice){
    if(!confirm('Deseja realmente excluir este jogo?')) return;

    const jogos = jogosDeveloper();
    jogos.splice(indice, 1);
    salvarJogosDeveloper(jogos);
    renderDeveloper();
}

function renderDeveloper(){
    const lista = document.getElementById('listaDeveloper');
    const jogos = jogosDeveloper();
    lista.innerHTML = '';

    if(jogos.length === 0){
        lista.innerHTML = '<div class="alert alert-info">Nenhum jogo publicado pelo Developer ainda.</div>';
        return;
    }

    jogos.forEach((jogo, indice) => {
        const col = document.createElement('div');
        col.className = 'col-md-4 mb-4';
        col.innerHTML = `
            <div class="card">
                <img src="${escaparHTML(jogo.imagem)}" class="card-img-top game-img" alt="${escaparHTML(jogo.nome)}" onerror="this.src='https://placehold.co/600x400?text=Imagem+indisponivel'">
                <div class="card-body">
                    <h5>${escaparHTML(jogo.nome)}</h5>
                    <p>Categoria: ${escaparHTML(jogo.categoria)}</p>
                    <p class="fw-bold">${precoTexto(jogo.preco)}</p>
                    <button class="btn btn-danger w-100" onclick="excluirJogoDeveloper(${indice})">Excluir jogo</button>
                </div>
            </div>
        `;
        lista.appendChild(col);
    });
}

document.addEventListener('DOMContentLoaded', renderDeveloper);
</script>
<script>
function renderAuthArea(){
    const area = document.getElementById('authArea');
    if(!area) return;

    const usuario = localStorage.getItem('usuarioLogado');

    if(usuario){
        area.innerHTML = `
            <div class="dropdown">
                <button class="btn btn-outline-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Olá, ${usuario}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><button class="dropdown-item" type="button" onclick="sairLogin()">Sair</button></li>
                </ul>
            </div>
        `;
    } else {
        area.innerHTML = `<a href="/login" class="btn btn-outline-light btn-sm">Login</a>`;
    }
}

function sairLogin(){
    localStorage.removeItem('usuarioLogado');
    renderAuthArea();
    alert('Você saiu da conta.');
}

function escaparHTML(texto){
    return String(texto ?? '').replace(/[&<>'"]/g, function(c){
        return {'&':'&amp;','<':'&lt;','>':'&gt;',"'":'&#39;','"':'&quot;'}[c];
    });
}

function precoNumero(preco){
    return Number(String(preco ?? '0').replace(',', '.')) || 0;
}

function precoTexto(preco){
    return precoNumero(preco).toLocaleString('pt-BR', {style:'currency', currency:'BRL'});
}

document.addEventListener('DOMContentLoaded', renderAuthArea);
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

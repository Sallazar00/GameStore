<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Login</title>
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

<main class="container">
    <div class="box mx-auto" style="max-width:520px">
        <h1>Login</h1>

        <div class="mb-3">
            <label class="form-label">Usuário</label>
            <input id="usuario" class="form-control" placeholder="Digite seu usuário">
        </div>

        <div class="mb-3">
            <label class="form-label">Senha</label>
            <input id="senha" type="password" class="form-control" placeholder="Digite sua senha">
        </div>

        <button class="btn btn-primary me-2" onclick="fazerLogin()">Entrar</button>
        <button class="btn btn-success" onclick="cadastrarUsuario()">Cadastrar</button>
    </div>
</main>

<script>
function usuariosSalvos(){
    return JSON.parse(localStorage.getItem('usuarios')) || [];
}

function salvarUsuarios(usuarios){
    localStorage.setItem('usuarios', JSON.stringify(usuarios));
}

function cadastrarUsuario(){
    const nome = document.getElementById('usuario').value.trim();
    const senha = document.getElementById('senha').value.trim();

    if(!nome || !senha){
        alert('Preencha usuário e senha.');
        return;
    }

    const usuarios = usuariosSalvos();

    if(usuarios.some(usuario => usuario.nome === nome)){
        alert('Esse usuário já existe. Escolha outro nome.');
        return;
    }

    usuarios.push({ nome, senha });
    salvarUsuarios(usuarios);
    alert('Cadastro realizado! Agora clique em Entrar.');
}

function fazerLogin(){
    const nome = document.getElementById('usuario').value.trim();
    const senha = document.getElementById('senha').value.trim();
    const usuarios = usuariosSalvos();

    const usuarioEncontrado = usuarios.find(usuario => usuario.nome === nome && usuario.senha === senha);

    if(usuarioEncontrado){
        localStorage.setItem('usuarioLogado', nome);
        alert('Login realizado!');
        location.href = '/';
    } else {
        alert('Usuário ou senha inválidos.');
    }
}
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

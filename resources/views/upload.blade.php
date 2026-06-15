<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Upload</title>
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
    <div class="box">
        <h1>Upload de Jogo</h1>
        <p>Esta página foi substituída pelo painel <strong>Developer</strong>.</p>
        <a href="/developer" class="btn btn-success">Ir para Developer</a>
    </div>
</main>
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

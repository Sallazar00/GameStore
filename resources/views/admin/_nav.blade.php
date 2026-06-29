<nav class="admin-nav" aria-label="Navegação administrativa">
    <a href="{{ route('admin') }}" class="{{ request()->routeIs('admin') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i>Visão geral</a>
    <a href="{{ route('admin.produtos') }}" class="{{ request()->routeIs('admin.produtos') ? 'active' : '' }}"><i class="bi bi-box-seam"></i>Produtos</a>
    <a href="{{ route('admin.categorias') }}" class="{{ request()->routeIs('admin.categorias') ? 'active' : '' }}"><i class="bi bi-tags"></i>Categorias</a>
    <a href="{{ route('admin.plataformas') }}" class="{{ request()->routeIs('admin.plataformas') ? 'active' : '' }}"><i class="bi bi-display"></i>Plataformas</a>
    <a href="{{ route('home') }}" class="ms-lg-auto"><i class="bi bi-shop"></i>Ver loja</a>
</nav>

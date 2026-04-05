<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Prevale</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Inter', sans-serif;
    }

    body, html {
        width: 100%;
        height: 100%;
        background-color: #f4f7f6; /* Fondo gris muy claro para el contenido */
    }

    /* Contenedor principal que divide Sidebar de Contenido */
    .dashboard-container {
        display: flex;
        width: 100%;
        height: 100vh;
    }

    /* La Barra Lateral (Tu clase .barra mejorada) */
    .barra {
        width: 280px;
        background: #111827; /* Un azul casi negro, mucho más elegante que el rojo puro */
        color: white;
        display: flex;
        flex-direction: column;
        padding: 20px;
        box-shadow: 2px 0 10px rgba(0,0,0,0.1);
    }

    .logo {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid #374151;
        text-align: center;
    }

    /* Estilo del Botón de Nueva Distribuidora */
    .btn-nueva {
        background-color: #2563eb; /* Azul brillante */
        color: white;
        border: none;
        padding: 12px 15px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: background 0.3s ease;
        margin-bottom: 25px;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .btn-nueva:hover {
        background-color: #1d4ed8;
    }

    .btn-nueva span {
        font-size: 1.2rem;
    }

    /* Menú de navegación */
    .menu-nav {
        list-style: none;
    }

    .menu-nav li {
        margin-bottom: 10px;
    }

    .menu-nav a {
        color: #9ca3af;
        text-decoration: none;
        display: block;
        padding: 10px;
        border-radius: 6px;
        transition: all 0.2s;
    }

    .menu-nav a:hover {
        background: #1f2937;
        color: white;
    }

    /* Área de Contenido Principal */
    .contenido {
        flex-1;
        width: 100%;
        padding: 40px;
    }

    h1 {
        color: #111827;
        font-size: 1.8rem;
    }
    .role{
        font-size: 15px;
        color: #5d6169 ;
    }
</style>
<body>
    <div class="dashboard-container">
        <aside class="barra">
            <div class="logo">Prestamo Fácil
                <p class="role">{{ auth()->user()->role->role }}</p>                   
            </div>
            @if(auth()->check() && auth()->user()->role_id == 1)
                <a href="{{ route('distribuidoras.create') }}" class="btn-nueva" style="display: block; position: relative; z-index: 999;">
                    <span>+</span> Nueva Distribuidora
                </a>
            @endif
            <nav>
                <ul class="menu-nav">
                    <li><a href="#">Distribuidoras</a></li>
                    <li><a href="#">Préstamos</a></li>
                    <li><a href="#">Configuración</a></li>
                    <li><a href="3">Memin</a></li>
                    <li><a href="3">Memin</a></li>
                    <li><a href="3">Memin</a></li>
                    <li><a href="3">Memin</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: none;">
                            @csrf
                        </form>
                        <a href="{{ route('logout') }}" 
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        style="color: #ef4444; font-weight: bold;">
                            Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="contenido">
            <h1>
                Bienvenido al Panel  
                <span style="text-transform: capitalize;">
                    {{ auth()->user()->persona->nombre }}!!
                </span>
            </h1>
            <p style="margin-top: 20px; color: #6b7280;">
                Aquí aparecerá el listado y la gestión de tus distribuidoras.
            </p>
            <div>
                <div>
                    <div>1</div>
                    <div>2</div>
                    <div>3</div>
                </div>
                <div>
                    <div>4</div>
                    <div>5</div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
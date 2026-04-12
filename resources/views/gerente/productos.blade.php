<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
        background-color: #f4f7f6;
    }
    .dashboard-container {
        display: flex;
        width: 100%;
        height: 100vh;
    }
    .contenido {
        flex: 1;
        width: 100%;
        padding: 40px;
        overflow-y: auto;
    }

    h1 {
        color: #111827;
        font-size: 1.8rem;
        margin-bottom: 20px;
    }
    /* Panel de contenido dinámico */
    .panel {
        background: white;
        border-radius: 12px;
        padding: 24px;
        height: 90%;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        overflow-y: auto;
    }  
    .loading {
        text-align: center;
        padding: 40px;
        color: #9ca3af;
    }
</style>
<body>
    <div class="dashboard-container">
        <x-aside-bar/>
        <main class="contenido">
            <h1>
                Bienvenido al Panel
                <span style="text-transform: capitalize;">
                    {{ auth()->user()->persona->nombre }}!!
                </span>
            </h1>

            <div class="panel" id="panel-contenido">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                    <h2 style="font-size:1.2rem; font-weight:700; color:#111827;">Productos</h2>
                    <button style="padding:8px 16px; background:#2563eb; color:white; border:none; border-radius:8px; cursor:pointer; font-weight:600;">
                        + Nuevo Producto
                    </button>
                </div>

                <table style="width:100%; border-collapse:collapse; font-size:0.9rem;">
                    <thead>
                        <tr style="background:#f9fafb; border-bottom:2px solid #e5e7eb;">
                            <th style="text-align:left; padding:12px 16px; color:#6b7280; font-weight:600; text-transform:uppercase; font-size:0.75rem;">#</th>
                            <th style="text-align:left; padding:12px 16px; color:#6b7280; font-weight:600; text-transform:uppercase; font-size:0.75rem;">Monto</th>
                            <th style="text-align:left; padding:12px 16px; color:#6b7280; font-weight:600; text-transform:uppercase; font-size:0.75rem;">Quincenas</th>
                            <th style="text-align:left; padding:12px 16px; color:#6b7280; font-weight:600; text-transform:uppercase; font-size:0.75rem;">Interés Quincenal</th>
                            <th style="text-align:left; padding:12px 16px; color:#6b7280; font-weight:600; text-transform:uppercase; font-size:0.75rem;">Seguro</th>
                            <th style="text-align:left; padding:12px 16px; color:#6b7280; font-weight:600; text-transform:uppercase; font-size:0.75rem;">Comisión Apertura</th>
                            <th style="text-align:left; padding:12px 16px; color:#6b7280; font-weight:600; text-transform:uppercase; font-size:0.75rem;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productos as $producto)
                        <tr style="border-bottom:1px solid #f3f4f6;">
                            <td style="padding:12px 16px; color:#374151;">{{ $producto->id }}</td>
                            <td style="padding:12px 16px; color:#374151; font-weight:700;">${{ number_format($producto->monto, 2) }}</td>
                            <td style="padding:12px 16px; color:#374151;">{{ $producto->quincenas }}</td>
                            <td style="padding:12px 16px; color:#374151;">{{ $producto->interes_quincenal }}%</td>
                            <td style="padding:12px 16px; color:#374151;">${{ number_format($producto->seguro, 2) }}</td>
                            <td style="padding:12px 16px; color:#374151;">{{ $producto->porcentaje_comision }}%</td>
                            <td style="padding:12px 16px;">
                                <div style="display:flex; gap:8px;">
                                    <button onclick="editarProducto({{ $producto->id }})"
                                        style="padding:6px 12px; background:#2563eb; color:white; border:none; border-radius:6px; cursor:pointer; font-size:0.8rem; font-weight:600;">
                                        Editar
                                    </button>
                                    <button onclick="eliminarProducto({{ $producto->id }})"
                                        style="padding:6px 12px; background:#dc2626; color:white; border:none; border-radius:6px; cursor:pointer; font-size:0.8rem; font-weight:600;">
                                        Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="text-align:center; padding:40px; color:#9ca3af;">
                                No hay productos registrados.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
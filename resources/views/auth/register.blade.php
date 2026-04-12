<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Distribuidora - Préstamo Fácil</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #305be3;
            --dark: #111827;
            --bg: #f4f7f6;
            --border: #e5e7eb;
            --text-main: #374151;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--bg); color: var(--text-main); }

        .barra {
            padding: 10px 30px;
            display: flex;
            align-items: center;
            background: var(--dark);
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .pf-logo { display: flex; align-items: center; gap: 12px; font-weight: 800; font-size: 1.2rem; color: white; }
        .pf-logo-box { background: var(--primary); color: white; padding: 6px 12px; border-radius: 8px; }

        .container { max-width: 1000px; margin: 30px auto; padding: 0 20px; }
        
        form {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 20px;
            padding-bottom: 8px;
            border-bottom: 2px solid var(--primary);
            display: inline-block;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .form-group { display: flex; flex-direction: column; gap: 8px; }
        label { font-size: 0.85rem; font-weight: 600; color: #6b7280; }
        
        input, select {
            padding: 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.2s;
        }

        input:focus { outline: none; border-color: var(--primary); ring: 2px solid #305be333; }

        .btn-submit {
            background: var(--primary);
            color: white;
            padding: 16px;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            transition: background 0.2s;
        }

        .btn-submit:hover { background: #2548b8; }
    </style>
</head>
<body>
    <div class="barra">
        <div class="pf-logo">
            <div class="pf-logo-box">PF</div>
            Préstamo Fácil
        </div>
        <a href="{{ route('dashboard') }}" style="color: #9ca3af; text-decoration: none; font-size: 0.95rem;">
            ← Volver al Dashboard
        </a>
    </div>

    <div class="container">
        <form action="{{ route('distribuidoras.create') }}" method="POST">
            @csrf

            <h3 class="section-title">Datos del Titular</h3>
            <div class="grid">
                <div class="form-group">
                    <label>Nombre(s)</label>
                    <input type="text" name="persona[nombre]" required placeholder="Ej: Kory">
                </div>
                <div class="form-group">
                    <label>Apellido(s)</label>
                    <input type="text" name="persona[apellido]" required placeholder="Ej: Panzona">
                </div>
                <div class="form-group">
                    <label>Sexo</label>
                    <select name="persona[sexo]" required>
                        <option value="F">Femenino</option>
                        <option value="M">Masculino</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Fecha de Nacimiento</label>
                    <input type="date" name="persona[fecha_nacimiento]" required>
                </div>
                <div class="form-group">
                    <label>CURP</label>
                    <input type="text" name="persona[CURP]" required maxlength="18">
                </div>
                <div class="form-group">
                    <label>RFC</label>
                    <input type="text" name="persona[RFC]" maxlength="13">
                </div>
                <div class="form-group">
                    <label>Celular</label>
                    <input type="text" name="persona[celular]" required>
                </div>
            </div>

            <h3 class="section-title">Configuración de Cuenta</h3>
            <div class="grid">
                <div class="form-group">
                    <label>Email Access</label>
                    <input type="email" name="usuario[email]" required placeholder="correo@ejemplo.com">
                </div>
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="usuario[password]" required>
                </div>
                <div class="form-group">
                    <label>Línea de Crédito</label>
                    <input type="number" step="0.01" name="distribuidora[linea_credito]" required>
                </div>
                <input type="hidden" name="usuario[sucursal_id]" value="1">
                <input type="hidden" name="usuario[role_id]" value="4">
                <input type="hidden" name="distribuidora[categoria_id]" value="1">
                <input type="hidden" name="distribuidora[estado]" value="activo">
                <input type="hidden" name="distribuidora[puntos]" value="0">
                <input type="hidden" name="distribuidora[geolocalizacion_lat]" value="25.5438">
                <input type="hidden" name="distribuidora[geolocalizacion_lng]" value="-103.4189">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
                <div>
                    <h3 class="section-title">Datos del Familiar</h3>
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label>Nombre Familiar</label>
                        <input type="text" name="familiar[nombre]" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label>Parentesco</label>
                        <input type="text" name="familiar[parentesco]" required placeholder="Ej: Esposo">
                    </div>
                    <input type="hidden" name="familiar[apellido]" value="Cambiame">
                    <input type="hidden" name="familiar[sexo]" value="M">
                    <input type="hidden" name="familiar[fecha_nacimiento]" value="1990-01-01">
                    <input type="hidden" name="familiar[CURP]" value="TEMP123456HDFRRN01">
                    <input type="hidden" name="familiar[celular]" value="0000000000">
                </div>

                <div>
                    <h3 class="section-title">Datos del Vehículo</h3>
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label>Marca</label>
                        <input type="text" name="vehiculo[marca]" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label>Placas</label>
                        <input type="text" name="vehiculo[numero_placas]" required>
                    </div>
                    <input type="hidden" name="vehiculo[modelo]" value="Pendiente">
                    <input type="hidden" name="vehiculo[color]" value="Pendiente">
                </div>
            </div>

            <h3 class="section-title">Datos de la Filial</h3>
            <div class="grid">
                <div class="form-group">
                    <label>Nombre Filial</label>
                    <input type="text" name="afilial[nombre]" required>
                </div>
                <div class="form-group">
                    <label>Antigüedad (Años)</label>
                    <input type="number" name="afilial[antiguedad]" required>
                </div>
                <div class="form-group">
                    <label>Línea Filial</label>
                    <input type="number" step="0.01" name="afilial[linea_credito]" required>
                </div>
            </div>

            <button type="submit" class="btn-submit">Registrar Nueva Distribuidora</button>
        </form>
    </div>
</body>
</html>
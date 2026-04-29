<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de seguridad</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --bg: #f8fafc;
            --white: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --accent: #3b82f6;
            --border: #e2e8f0;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }

        body {
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background: var(--white);
            border-radius: 24px;
            border: 1px solid var(--border);
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
            padding: 40px;
            width: 420px;
            max-width: 95vw;
        }

        /* ── Progreso ── */
        .steps {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 32px;
        }

        .step-dot {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 2px solid var(--border);
            background: var(--bg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 800;
            color: var(--text-muted);
        }

        .step-dot.done { background: #dcfce7; border-color: #86efac; color: #166534; }
        .step-dot.active { background: var(--accent); border-color: var(--accent); color: #fff; box-shadow: 0 0 0 4px #bfdbfe; }

        .step-line { flex: 1; height: 2px; background: var(--border); max-width: 48px; }
        .step-line.done { background: #86efac; }

        /* ── Ícono ── */
        .icon-wrap {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .icon-wrap.email { background: #eff6ff; color: var(--accent); }
        .icon-wrap.pin   { background: #fef3c7; color: #b45309; }

        h1 { font-size: 1.4rem; font-weight: 800; color: var(--text-main); text-align: center; margin-bottom: 8px; }

        .subtitle { font-size: 0.88rem; color: var(--text-muted); text-align: center; line-height: 1.6; margin-bottom: 28px; }

        /* ── Inputs dígitos (email) ── */
        .codigo-wrap {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 24px;
        }

        .codigo-digit {
            width: 48px;
            height: 56px;
            border: 2px solid var(--border);
            border-radius: 12px;
            font-size: 1.5rem;
            font-weight: 800;
            text-align: center;
            color: var(--text-main);
            outline: none;
            transition: border-color 0.2s;
            font-family: 'Courier New', monospace;
        }

        .codigo-digit:focus { border-color: var(--accent); box-shadow: 0 0 0 3px #bfdbfe; }

        /* ── Input PIN ── */
        .pin-wrap { margin-bottom: 24px; }

        .pin-input {
            width: 100%;
            padding: 16px;
            border: 2px solid var(--border);
            border-radius: 12px;
            font-size: 1.8rem;
            font-weight: 800;
            text-align: center;
            letter-spacing: 0.3em;
            font-family: 'Courier New', monospace;
            color: var(--text-main);
            outline: none;
            transition: border-color 0.2s;
        }

        .pin-input:focus { border-color: #f59e0b; box-shadow: 0 0 0 3px #fde68a; }

        #codigo-hidden { display: none; }

        .btn-verificar {
            width: 100%;
            padding: 14px;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: background 0.2s;
            margin-bottom: 14px;
        }

        .btn-verificar:hover { background: #2563eb; }

        .btn-reenviar {
            width: 100%;
            padding: 11px;
            background: transparent;
            color: var(--text-muted);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            font-size: 0.88rem;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .btn-reenviar:hover { background: var(--bg); color: var(--text-main); }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.85rem;
            color: #b91c1c;
            margin-bottom: 18px;
            text-align: center;
        }

        .alert-info {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.85rem;
            color: #1d4ed8;
            margin-bottom: 18px;
            text-align: center;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 18px;
            font-size: 0.83rem;
            color: var(--text-muted);
            text-decoration: none;
        }

        .back-link:hover { color: var(--text-main); }
    </style>
</head>
<body>
    <div class="card">

        {{-- Progreso --}}
        <div class="steps">
            @for($i = 1; $i <= $pasosTotal; $i++)
                @if($i > 1)
                    <div class="step-line {{ $i <= $paso ? 'done' : '' }}"></div>
                @endif
                <div class="step-dot {{ $i < $paso ? 'done' : ($i == $paso ? 'active' : '') }}">
                    @if($i < $paso)
                        <i data-lucide="check" style="width:14px;"></i>
                    @else
                        {{ $i }}
                    @endif
                </div>
            @endfor
        </div>

        {{-- Ícono y título --}}
        @if($esPIN)
            <div class="icon-wrap pin">
                <i data-lucide="lock" style="width:28px; height:28px;"></i>
            </div>
            <h1>Ingresa tu PIN</h1>
            <p class="subtitle">Introduce el PIN de 4 dígitos para completar el acceso.</p>
        @else
            <div class="icon-wrap email">
                <i data-lucide="mail" style="width:28px; height:28px;"></i>
            </div>
            <h1>Verificación por correo</h1>
            <p class="subtitle">
                Ingresa el código de 6 dígitos que enviamos a tu correo.<br>
                Expira en <strong>10 minutos</strong>.
            </p>
        @endif

        {{-- Alertas --}}
        @if(session('info'))
            <div class="alert-info">{{ session('info') }}</div>
        @endif

        @if($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        {{-- Formulario --}}
        <form method="POST" action="{{ route('mfa.verificar.post') }}" id="mfa-form">
            @csrf

            @if($esPIN)
                {{-- Input PIN ── 4 dígitos ── --}}
                <div class="pin-wrap">
                    <input type="password"
                           name="codigo"
                           class="pin-input"
                           maxlength="4"
                           inputmode="numeric"
                           placeholder="••••"
                           autocomplete="off"
                           autofocus>
                </div>

                <button type="submit" class="btn-verificar">
                    Confirmar PIN
                </button>

            @else
                {{-- 6 cajas para código email ── --}}
                <div class="codigo-wrap" id="digits-wrap">
                    @for($i = 0; $i < 6; $i++)
                        <input type="text"
                               class="codigo-digit"
                               maxlength="1"
                               inputmode="numeric"
                               pattern="[0-9]"
                               autocomplete="off">
                    @endfor
                </div>

                <input type="hidden" name="codigo" id="codigo-hidden">

                <button type="submit" class="btn-verificar" onclick="return juntarCodigo()">
                    Verificar código
                </button>

                {{-- Reenviar solo en paso de email --}}
                <form method="POST" action="{{ route('mfa.reenviar') }}">
                    @csrf
                    <button type="submit" class="btn-reenviar">
                        <i data-lucide="refresh-cw" style="width:14px;"></i>
                        Reenviar código
                    </button>
                </form>
            @endif
        </form>

        <a href="{{ route('login') }}" class="back-link">← Volver al inicio de sesión</a>
    </div>

    <script>
        var digits = document.querySelectorAll('.codigo-digit');

        digits.forEach(function(input, index) {
            input.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, '');
                if (this.value.length === 1 && index < digits.length - 1) {
                    digits[index + 1].focus();
                }
            });

            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && this.value === '' && index > 0) {
                    digits[index - 1].focus();
                }
            });

            input.addEventListener('paste', function(e) {
                e.preventDefault();
                var pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
                for (var i = 0; i < Math.min(pasted.length, 6); i++) {
                    digits[i].value = pasted[i];
                }
                digits[Math.min(pasted.length, 5)].focus();
            });
        });

        function juntarCodigo() {
            var codigo = '';
            digits.forEach(function(d) { codigo += d.value; });

            if (codigo.length < 6) {
                alert('Ingresa los 6 dígitos del código.');
                return false;
            }

            document.getElementById('codigo-hidden').value = codigo;
            return true;
        }

        lucide.createIcons();
    </script>
</body>
</html>
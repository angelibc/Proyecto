<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\MfaCodigo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    // PIN fijo para Administracion (role_id 1)
    private const PIN_ADMIN = '2209';

    private function factoresPorRol(int $roleId): int
    {
        return match($roleId) {
            1 => 2, // Administracion: código email + PIN
            2 => 1, // Supervisor: solo código email
            3 => 0, // Guest: solo contraseña
            default => 0,
        };
    }

    // ── LOGIN ──────────────────────────────────────

    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $user = $request->user();
        $factoresExtra = $this->factoresPorRol($user->role_id);

        if ($factoresExtra === 0) {
            $request->session()->regenerate();
            return $this->redirigirPorRol($user->role_id);
        }

        Auth::guard('web')->logout();

        $request->session()->put('mfa_usuario_id', $user->id);
        $request->session()->put('mfa_role_id', $user->role_id);
        $request->session()->put('mfa_paso', 1);
        $request->session()->put('mfa_pasos_total', $factoresExtra);

        $this->enviarCodigo($user->id, $user->email);

        return redirect()->route('mfa.verificar');
    }

    // ── MOSTRAR VERIFICACIÓN ───────────────────────

    public function mostrarVerificacion(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('mfa_usuario_id')) {
            return redirect()->route('login');
        }

        $paso       = $request->session()->get('mfa_paso');
        $pasosTotal = $request->session()->get('mfa_pasos_total');
        $esPIN      = ($paso === 2);

        return view('auth.mfa-verificar', compact('paso', 'pasosTotal', 'esPIN'));
    }

    // ── VERIFICAR ──────────────────────────────────

    public function verificarCodigo(Request $request): RedirectResponse
    {
        $request->validate(['codigo' => 'required|string']);

        $usuarioId  = $request->session()->get('mfa_usuario_id');
        $roleId     = $request->session()->get('mfa_role_id');
        $paso       = $request->session()->get('mfa_paso');
        $pasosTotal = $request->session()->get('mfa_pasos_total');

        if (! $usuarioId) {
            return redirect()->route('login')
                ->withErrors(['codigo' => 'Sesión expirada. Inicia sesión de nuevo.']);
        }

        // Paso 1 — código por email
        if ($paso === 1) {
            $mfa = MfaCodigo::where('usuario_id', $usuarioId)
                ->where('codigo', $request->codigo)
                ->where('usado', false)
                ->first();

            if (! $mfa) {
                return back()->withErrors(['codigo' => 'Código incorrecto.']);
            }

            if ($mfa->estaExpirado()) {
                $mfa->update(['usado' => true]);
                return back()->withErrors(['codigo' => 'El código expiró. Solicita uno nuevo.']);
            }

            $mfa->update(['usado' => true]);

            if ($pasosTotal >= 2) {
                $request->session()->put('mfa_paso', 2);
                return redirect()->route('mfa.verificar')
                    ->with('info', 'Código verificado. Ahora ingresa tu PIN.');
            }
        }

        // Paso 2 — PIN fijo
        if ($paso === 2) {
            if ($request->codigo !== self::PIN_ADMIN) {
                return back()->withErrors(['codigo' => 'PIN incorrecto.']);
            }
        }

        // ── Todos los pasos superados ──
        $request->session()->forget([
            'mfa_usuario_id', 'mfa_role_id', 'mfa_paso', 'mfa_pasos_total',
        ]);

        $user = \App\Models\User::find($usuarioId);
        Auth::login($user);
        $request->session()->regenerate();

        return $this->redirigirPorRol($user->role_id);
    }

    // ── REENVIAR ───────────────────────────────────

    public function reenviarCodigo(Request $request): RedirectResponse
    {
        $usuarioId = $request->session()->get('mfa_usuario_id');
        $paso      = $request->session()->get('mfa_paso');

        if (! $usuarioId || $paso !== 1) {
            return redirect()->route('login');
        }

        $user = \App\Models\User::find($usuarioId);
        $this->enviarCodigo($usuarioId, $user->email);

        return back()->with('info', 'Se envió un nuevo código a tu correo.');
    }

    // ── LOGOUT ─────────────────────────────────────

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // ── HELPERS ────────────────────────────────────

    private function enviarCodigo(int $usuarioId, string $email): void
    {
        MfaCodigo::where('usuario_id', $usuarioId)
            ->where('usado', false)
            ->update(['usado' => true]);

        $codigo = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        MfaCodigo::create([
            'usuario_id' => $usuarioId,
            'codigo'     => $codigo,
            'factor'     => 1,
            'usado'      => false,
            'expira_at'  => now()->addMinutes(10),
        ]);

        Mail::raw(
            "Tu código de verificación es: {$codigo}\n\nExpira en 10 minutos.\n\nSi no solicitaste este código, ignora este mensaje.",
            function ($message) use ($email) {
                $message->to($email)
                        ->subject('Código de verificación — Préstamo Fácil');
            }
        );
    }

    private function redirigirPorRol(int $roleId): RedirectResponse
    {
        return match($roleId) {
            1 => redirect()->route('gerente.productos'),
            2 => redirect()->route('coordinador.notificaciones'),
            3 => redirect()->route('verificador.dashboard'),
            4 => redirect()->route('distribuidora.dashboard'),
            5 => redirect()->route('cajera.prevale'),
            default => redirect()->route('login'),
        };
    }
}
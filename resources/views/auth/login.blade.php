<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <title>Iniciar sesión</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap');
        :root {
            --bg:#090d13; --card:#0f1521;
            --border:rgba(99,120,180,.15); --border-h:rgba(99,120,180,.32);
            --accent:#4f7cff; --accent-s:rgba(79,124,255,.13); --accent-g:rgba(79,124,255,.3);
            --t1:#e8edf5; --t2:#8a9bbf; --t3:#4a5878;
            --danger:#ff5c7a; --danger-s:rgba(255,92,122,.13);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            min-height: 100vh; background: var(--bg); font-family: 'DM Sans', sans-serif;
            display: flex; align-items: center; justify-content: center;
            position: relative; overflow: hidden;
        }
        .bg-grid {
            position: fixed; inset: 0; z-index: 0;
            background-image:
                linear-gradient(rgba(79,124,255,.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(79,124,255,.04) 1px, transparent 1px);
            background-size: 40px 40px;
        }
        .bg-glow { position: fixed; z-index: 0; border-radius: 50%; filter: blur(80px); animation: drift 12s ease-in-out infinite; }
        .bg-glow-1 { width:500px; height:500px; background:rgba(79,124,255,.08); top:-150px; left:-100px; }
        .bg-glow-2 { width:400px; height:400px; background:rgba(45,212,160,.06); bottom:-100px; right:-80px; animation-delay:-6s; }
        @keyframes drift { 0%,100%{transform:translate(0,0)} 50%{transform:translate(30px,20px)} }
        .login-wrap { position:relative; z-index:1; width:100%; max-width:420px; padding:1.5rem; }
        .login-card {
            background:var(--card); border:1px solid var(--border); border-radius:22px;
            padding:2.5rem 2rem; box-shadow:0 24px 80px rgba(0,0,0,.5);
            animation:slideUp .5s cubic-bezier(.16,1,.3,1) both;
        }
        @keyframes slideUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
        .login-logo { text-align:center; margin-bottom:2rem; }
        .login-logo .logo-icon {
            width:54px; height:54px; background:var(--accent-s); border:1px solid rgba(79,124,255,.25);
            border-radius:15px; display:inline-flex; align-items:center; justify-content:center;
            font-size:1.5rem; margin-bottom:.9rem;
        }
        .login-logo h1 { font-family:'Syne',sans-serif; font-size:1.5rem; font-weight:800; color:var(--t1); letter-spacing:-.03em; }
        .login-logo p  { font-size:.85rem; color:var(--t2); margin-top:.2rem; }
        .field { display:flex; flex-direction:column; gap:.45rem; margin-bottom:1.1rem; }
        .field label { font-size:.75rem; font-weight:600; color:var(--t2); text-transform:uppercase; letter-spacing:.07em; }
        .field input {
            background:var(--bg); border:1px solid var(--border); color:var(--t1);
            border-radius:11px; padding:.65rem 1rem; font-size:.9rem;
            font-family:'DM Sans',sans-serif; outline:none; width:100%;
            transition:border-color .2s,box-shadow .2s;
        }
        .field input:focus { border-color:var(--accent); box-shadow:0 0 0 3px var(--accent-s); }
        .field input::placeholder { color:var(--t3); }
        .field-row { display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem; font-size:.82rem; }
        .remember { display:flex; align-items:center; gap:.45rem; color:var(--t2); cursor:pointer; }
        .remember input[type=checkbox] { width:15px; height:15px; accent-color:var(--accent); cursor:pointer; }
        .forgot { color:var(--accent); text-decoration:none; font-size:.82rem; transition:opacity .15s; }
        .forgot:hover { opacity:.75; }
        .btn-login {
            width:100%; background:var(--accent); color:#fff; border:none;
            border-radius:11px; padding:.75rem; font-size:.95rem; font-weight:600;
            font-family:'Syne',sans-serif; cursor:pointer; box-shadow:0 4px 20px var(--accent-g);
            transition:opacity .15s,transform .15s,box-shadow .15s; letter-spacing:-.01em;
        }
        .btn-login:hover { opacity:.9; transform:translateY(-1px); box-shadow:0 6px 26px var(--accent-g); }
        .btn-login:active { transform:translateY(0); }
        .error-box {
            background:var(--danger-s); border:1px solid rgba(255,92,122,.22);
            border-radius:10px; padding:.7rem 1rem; font-size:.82rem;
            color:var(--danger); margin-bottom:1.2rem;
        }
        .field-error { font-size:.75rem; color:var(--danger); margin-top:-.2rem; }
        .status-box {
            background:rgba(45,212,160,.1); border:1px solid rgba(45,212,160,.2);
            border-radius:10px; padding:.7rem 1rem; font-size:.82rem;
            color:#2dd4a0; margin-bottom:1.2rem;
        }
        /* 👇 Link de registro */
        .register-link {
            text-align:center; margin-top:1.3rem;
            font-size:.83rem; color:var(--t3);
        }
        .register-link a {
            color:var(--accent); text-decoration:none; font-weight:500;
            transition:opacity .15s;
        }
        .register-link a:hover { opacity:.75; }
    </style>
</head>
<body>
    <div class="bg-grid"></div>
    <div class="bg-glow bg-glow-1"></div>
    <div class="bg-glow bg-glow-2"></div>

    <div class="login-wrap">
        <div class="login-card">

            <div class="login-logo">
                <div class="logo-icon">📦</div>
                <h1>Bienvenido</h1>
                <p>Inicia sesión para continuar</p>
            </div>

            @if(session('status'))
                <div class="status-box">{{ session('status') }}</div>
            @endif

            @if($errors->any())
                <div class="error-box">Credenciales incorrectas. Intenta de nuevo.</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field">
                    <label>Correo electrónico</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        placeholder="correo@ejemplo.com" required autofocus>
                    @error('email')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label>Contraseña</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                    @error('password')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="field-row">
                    <label class="remember">
                        <input type="checkbox" name="remember"> Recordarme
                    </label>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot">¿Olvidaste tu contraseña?</a>
                    @endif
                </div>

                <button type="submit" class="btn-login">Iniciar sesión →</button>
            </form>

            {{-- 👇 Link de registro --}}
            @if(Route::has('register'))
            <div class="register-link">
                ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a>
            </div>
            @endif

        </div>
    </div>
</body>
</html>
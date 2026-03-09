<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <title>Crear cuenta</title>
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
            min-height: 100vh;
            background: var(--bg);
            font-family: 'DM Sans', sans-serif;
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

        .wrap { position:relative; z-index:1; width:100%; max-width:440px; padding:1.5rem; }
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 22px;
            padding: 2.5rem 2rem;
            box-shadow: 0 24px 80px rgba(0,0,0,.5);
            animation: slideUp .5s cubic-bezier(.16,1,.3,1) both;
        }
        @keyframes slideUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }

        .logo { text-align:center; margin-bottom:1.8rem; }
        .logo-icon { width:54px; height:54px; background:var(--accent-s); border:1px solid rgba(79,124,255,.25); border-radius:15px; display:inline-flex; align-items:center; justify-content:center; font-size:1.5rem; margin-bottom:.9rem; }
        .logo h1 { font-family:'Syne',sans-serif; font-size:1.5rem; font-weight:800; color:var(--t1); letter-spacing:-.03em; }
        .logo p  { font-size:.85rem; color:var(--t2); margin-top:.2rem; }

        .field { display:flex; flex-direction:column; gap:.45rem; margin-bottom:1rem; }
        .field label { font-size:.75rem; font-weight:600; color:var(--t2); text-transform:uppercase; letter-spacing:.07em; }
        .field input {
            background:var(--bg); border:1px solid var(--border); color:var(--t1);
            border-radius:11px; padding:.65rem 1rem; font-size:.9rem;
            font-family:'DM Sans',sans-serif; outline:none; width:100%;
            transition:border-color .2s,box-shadow .2s;
        }
        .field input:focus { border-color:var(--accent); box-shadow:0 0 0 3px var(--accent-s); }
        .field input::placeholder { color:var(--t3); }
        .field-error { font-size:.75rem; color:var(--danger); }

        .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:.75rem; }
        @media(max-width:420px){ .form-grid { grid-template-columns:1fr; } }

        .btn-register {
            width:100%; background:var(--accent); color:#fff; border:none;
            border-radius:11px; padding:.75rem; font-size:.95rem; font-weight:600;
            font-family:'Syne',sans-serif; cursor:pointer; margin-top:.5rem;
            box-shadow:0 4px 20px var(--accent-g);
            transition:opacity .15s,transform .15s,box-shadow .15s;
            letter-spacing:-.01em;
        }
        .btn-register:hover { opacity:.9; transform:translateY(-1px); box-shadow:0 6px 26px var(--accent-g); }

        .login-link { text-align:center; margin-top:1.2rem; font-size:.83rem; color:var(--t3); }
        .login-link a { color:var(--accent); text-decoration:none; font-weight:500; }
        .login-link a:hover { opacity:.75; }
    </style>
</head>
<body>
    <div class="bg-grid"></div>
    <div class="bg-glow bg-glow-1"></div>
    <div class="bg-glow bg-glow-2"></div>

    <div class="wrap">
        <div class="card">

            <div class="logo">
                <div class="logo-icon">📦</div>
                <h1>Crear cuenta</h1>
                <p>Completa los datos para registrarte</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="field">
                    <label>Nombre completo</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        placeholder="Tu nombre" required autofocus>
                    @error('name')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label>Correo electrónico</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        placeholder="correo@ejemplo.com" required>
                    @error('email')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-grid">
                    <div class="field">
                        <label>Contraseña</label>
                        <input type="password" name="password" placeholder="••••••••" required>
                        @error('password')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Confirmar</label>
                        <input type="password" name="password_confirmation" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="btn-register">Crear cuenta →</button>
            </form>

            <div class="login-link">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
            </div>

        </div>
    </div>
</body>
</html>
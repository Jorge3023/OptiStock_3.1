<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap');
        :root {
            --bg:#090d13; --card:#0f1521; --card-h:#141d2e;
            --border:rgba(99,120,180,.12); --border-h:rgba(99,120,180,.28);
            --accent:#4f7cff; --accent-s:rgba(79,124,255,.13);
            --ok:#2dd4a0; --ok-s:rgba(45,212,160,.13);
            --danger:#ff5c7a; --danger-s:rgba(255,92,122,.13);
            --t1:#e8edf5; --t2:#8a9bbf; --t3:#4a5878;
        }
        body { background:var(--bg); font-family:'DM Sans',sans-serif; }
        .fw { max-width:760px; margin:0 auto; padding:2.5rem 1.5rem 4rem; }

        .form-header { margin-bottom:2rem; }
        .form-header h1 { font-family:'Syne',sans-serif; font-size:1.7rem; font-weight:800; color:var(--t1); letter-spacing:-.03em; margin:0 0 .3rem; }
        .form-header p  { color:var(--t2); font-size:.88rem; margin:0; }

        .form-card { background:var(--card); border:1px solid var(--border); border-radius:18px; padding:2rem; }

        .form-section { margin-bottom:1.8rem; }
        .form-section-title { font-family:'Syne',sans-serif; font-size:.78rem; font-weight:700; color:var(--t3); text-transform:uppercase; letter-spacing:.1em; margin-bottom:1rem; padding-bottom:.6rem; border-bottom:1px solid var(--border); }

        .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
        .form-grid.cols-1 { grid-template-columns:1fr; }
        @media(max-width:560px){ .form-grid { grid-template-columns:1fr; } }

        .field { display:flex; flex-direction:column; gap:.4rem; }
        .field label { font-size:.78rem; font-weight:500; color:var(--t2); text-transform:uppercase; letter-spacing:.06em; }
        .field input,
        .field select,
        .field textarea {
            background:var(--bg);
            border:1px solid var(--border);
            color:var(--t1);
            border-radius:10px;
            padding:.6rem .9rem;
            font-size:.88rem;
            font-family:'DM Sans',sans-serif;
            outline:none;
            transition:border-color .2s,box-shadow .2s;
        }
        .field input:focus,
        .field select:focus,
        .field textarea:focus { border-color:var(--accent); box-shadow:0 0 0 3px var(--accent-s); }
        .field input::placeholder,
        .field textarea::placeholder { color:var(--t3); }
        .field select option { background:var(--card); }
        .field textarea { resize:vertical; min-height:80px; }
        .field .err-msg { font-size:.75rem; color:var(--danger); }

        .form-footer { display:flex; gap:.75rem; justify-content:flex-end; margin-top:1.5rem; flex-wrap:wrap; }
        .btn-cancel { display:inline-flex; align-items:center; gap:.4rem; background:transparent; color:var(--t2); border:1px solid var(--border); border-radius:10px; padding:.55rem 1.2rem; font-size:.85rem; font-family:'DM Sans',sans-serif; cursor:pointer; text-decoration:none; transition:background .15s,color .15s,border-color .15s; }
        .btn-cancel:hover { background:var(--card-h); border-color:var(--border-h); color:var(--t1); }
        .btn-save { display:inline-flex; align-items:center; gap:.4rem; background:var(--accent); color:#fff; border:none; border-radius:10px; padding:.55rem 1.4rem; font-size:.85rem; font-weight:500; font-family:'DM Sans',sans-serif; cursor:pointer; box-shadow:0 4px 16px rgba(79,124,255,.32); transition:opacity .15s,transform .15s; }
        .btn-save:hover { opacity:.88; transform:translateY(-1px); }

        .alert { padding:.85rem 1.2rem; border-radius:12px; font-size:.84rem; margin-bottom:1.5rem; }
        .alert.err { background:var(--danger-s); border:1px solid rgba(255,92,122,.22); color:var(--danger); }
        .alert ul { margin:.3rem 0 0 1rem; padding:0; }
    </style>

    <div class="fw">

        <div class="form-header">
            <h1>Nuevo producto</h1>
            <p>Completa los campos para agregar un producto al inventario.</p>
        </div>

        @if($errors->any())
        <div class="alert err">
            <strong>Corrige los siguientes errores:</strong>
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        <div class="form-card">
            <form method="POST" action="{{ route('productos.store') }}">
                @csrf

                {{-- Info básica --}}
                <div class="form-section">
                    <div class="form-section-title">Información básica</div>
                    <div class="form-grid">
                        <div class="field">
                            <label>Nombre *</label>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Nombre del producto" required>
                            @error('nombre')<span class="err-msg">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label>Código de barras *</label>
                            <input type="text" name="codigo_barras" value="{{ old('codigo_barras') }}" placeholder="EAN / UPC" required>
                            @error('codigo_barras')<span class="err-msg">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                {{-- Precio y stock --}}
                <div class="form-section">
                    <div class="form-section-title">Precio y stock</div>
                    <div class="form-grid">
                        <div class="field">
                            <label>Precio *</label>
                            <input type="number" name="precio" value="{{ old('precio') }}" placeholder="0.00" step="0.01" min="0" required>
                            @error('precio')<span class="err-msg">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label>Stock *</label>
                            <input type="number" name="stock" value="{{ old('stock', 0) }}" placeholder="0" min="0" required>
                            @error('stock')<span class="err-msg">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                {{-- Organización --}}
                <div class="form-section">
                    <div class="form-section-title">Organización</div>
                    <div class="form-grid">
                        <div class="field">
                            <label>Cargo</label>
                            <input type="text" name="cargo" value="{{ old('cargo') }}" placeholder="Ej. Gerente, Almacén...">
                            @error('cargo')<span class="err-msg">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label>Creado por</label>
                            <input type="text" name="creado_por" value="{{ Auth::user()->name }}" readonly
                                style="opacity:.6; cursor:not-allowed;">
                        </div>
                        <div class="field">
                            <label>Estado *</label>
                            <select name="estado" required>
                                <option value="Disponible"     {{ old('estado','Disponible')=='Disponible'     ? 'selected':'' }}>Disponible</option>
                                <option value="Sin existencia" {{ old('estado')=='Sin existencia' ? 'selected':'' }}>Sin existencia</option>
                            </select>
                            @error('estado')<span class="err-msg">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-footer">
                    <a href="{{ route('productos.index') }}" class="btn-cancel">← Cancelar</a>
                    <button type="submit" class="btn-save">💾 Guardar producto</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
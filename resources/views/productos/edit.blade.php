<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap');
        :root {
            --bg:#090d13; --card:#0f1521; --card-h:#141d2e;
            --border:rgba(99,120,180,.12); --border-h:rgba(99,120,180,.28);
            --accent:#4f7cff; --accent-s:rgba(79,124,255,.13);
            --ok:#2dd4a0; --ok-s:rgba(45,212,160,.13);
            --danger:#ff5c7a; --danger-s:rgba(255,92,122,.13);
            --warn:#f5a623; --warn-s:rgba(245,166,35,.13);
            --t1:#e8edf5; --t2:#8a9bbf; --t3:#4a5878;
        }
        body { background:var(--bg); font-family:'DM Sans',sans-serif; }
        .fw { max-width:760px; margin:0 auto; padding:2.5rem 1.5rem 4rem; }

        .form-header { display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:1rem; margin-bottom:2rem; }
        .form-header-text h1 { font-family:'Syne',sans-serif; font-size:1.7rem; font-weight:800; color:var(--t1); letter-spacing:-.03em; margin:0 0 .3rem; }
        .form-header-text p  { color:var(--t2); font-size:.88rem; margin:0; }
        .id-chip { background:var(--card); border:1px solid var(--border); border-radius:8px; padding:.3rem .75rem; font-size:.75rem; color:var(--t3); font-family:monospace; }

        .form-card { background:var(--card); border:1px solid var(--border); border-radius:18px; padding:2rem; }
        .form-section { margin-bottom:1.8rem; }
        .form-section-title { font-family:'Syne',sans-serif; font-size:.78rem; font-weight:700; color:var(--t3); text-transform:uppercase; letter-spacing:.1em; margin-bottom:1rem; padding-bottom:.6rem; border-bottom:1px solid var(--border); }

        .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
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
        .field input::placeholder { color:var(--t3); }
        .field select option { background:var(--card); }
        .field .err-msg { font-size:.75rem; color:var(--danger); }

        /* meta strip */
        .meta-strip { display:flex; gap:1.5rem; flex-wrap:wrap; background:rgba(79,124,255,.05); border:1px solid rgba(79,124,255,.1); border-radius:12px; padding:.85rem 1.2rem; margin-bottom:1.8rem; }
        .meta-item label { font-size:.7rem; text-transform:uppercase; letter-spacing:.07em; color:var(--t3); font-weight:600; display:block; margin-bottom:.15rem; }
        .meta-item span  { font-size:.82rem; color:var(--t2); }

        .form-footer { display:flex; gap:.75rem; justify-content:space-between; margin-top:1.5rem; flex-wrap:wrap; }
        .footer-right { display:flex; gap:.75rem; flex-wrap:wrap; }
        .btn-cancel { display:inline-flex; align-items:center; gap:.4rem; background:transparent; color:var(--t2); border:1px solid var(--border); border-radius:10px; padding:.55rem 1.2rem; font-size:.85rem; font-family:'DM Sans',sans-serif; cursor:pointer; text-decoration:none; transition:background .15s,color .15s,border-color .15s; }
        .btn-cancel:hover { background:var(--card-h); border-color:var(--border-h); color:var(--t1); }
        .btn-delete { display:inline-flex; align-items:center; gap:.4rem; background:transparent; color:var(--danger); border:1px solid rgba(255,92,122,.25); border-radius:10px; padding:.55rem 1.1rem; font-size:.85rem; font-family:'DM Sans',sans-serif; cursor:pointer; transition:background .15s,border-color .15s; }
        .btn-delete:hover { background:var(--danger-s); border-color:rgba(255,92,122,.4); }
        .btn-save { display:inline-flex; align-items:center; gap:.4rem; background:var(--accent); color:#fff; border:none; border-radius:10px; padding:.55rem 1.4rem; font-size:.85rem; font-weight:500; font-family:'DM Sans',sans-serif; cursor:pointer; box-shadow:0 4px 16px rgba(79,124,255,.32); transition:opacity .15s,transform .15s; }
        .btn-save:hover { opacity:.88; transform:translateY(-1px); }

        .alert { padding:.85rem 1.2rem; border-radius:12px; font-size:.84rem; margin-bottom:1.5rem; }
        .alert.err { background:var(--danger-s); border:1px solid rgba(255,92,122,.22); color:var(--danger); }
        .alert ul { margin:.3rem 0 0 1rem; padding:0; }
    </style>

    <div class="fw">

        <div class="form-header">
            <div class="form-header-text">
                <h1>Editar producto</h1>
                <p>Modifica los datos del producto y guarda los cambios.</p>
            </div>
            <div class="id-chip">ID #{{ $producto->id }}</div>
        </div>

        @if($errors->any())
        <div class="alert err">
            <strong>Corrige los siguientes errores:</strong>
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        {{-- Meta strip --}}
        <div class="meta-strip">
            <div class="meta-item">
                <label>Creado</label>
                <span>{{ \Carbon\Carbon::parse($producto->created_at)->format('d/m/Y H:i') }}</span>
            </div>
            <div class="meta-item">
                <label>Actualizado</label>
                <span>{{ \Carbon\Carbon::parse($producto->updated_at)->format('d/m/Y H:i') }}</span>
            </div>
            <div class="meta-item">
                <label>Creado por</label>
                <span>{{ $producto->creado_por ?? '—' }}</span>
            </div>
        </div>

        <div class="form-card">
            <form method="POST" action="{{ route('productos.update', $producto->id) }}">
                @csrf @method('PUT')

                <div class="form-section">
                    <div class="form-section-title">Información básica</div>
                    <div class="form-grid">
                        <div class="field">
                            <label>Nombre *</label>
                            <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
                            @error('nombre')<span class="err-msg">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label>Código de barras *</label>
                            <input type="text" name="codigo_barras" value="{{ old('codigo_barras', $producto->codigo_barras) }}" required>
                            @error('codigo_barras')<span class="err-msg">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-title">Precio y stock</div>
                    <div class="form-grid">
                        <div class="field">
                            <label>Precio *</label>
                            <input type="number" name="precio" value="{{ old('precio', $producto->precio) }}" step="0.01" min="0" required>
                            @error('precio')<span class="err-msg">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label>Stock *</label>
                            <input type="number" name="stock" value="{{ old('stock', $producto->stock) }}" min="0" required>
                            @error('stock')<span class="err-msg">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-title">Organización</div>
                    <div class="form-grid">
                        <div class="field">
                            <label>Cargo</label>
                            <input type="text" name="cargo" value="{{ old('cargo', $producto->cargo) }}">
                            @error('cargo')<span class="err-msg">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label>Creado por</label>
                            <input type="text" name="creado_por" value="{{ $producto->creado_por }}" readonly
                                style="opacity:.6; cursor:not-allowed;">
                        </div>
                        <div class="field">
                            <label>Estado *</label>
                            <select name="estado" required>
                                <option value="Disponible"     {{ old('estado',$producto->estado)=='Disponible'     ? 'selected':'' }}>Disponible</option>
                                <option value="Sin existencia" {{ old('estado',$producto->estado)=='Sin existencia' ? 'selected':'' }}>Sin existencia</option>
                            </select>
                            @error('estado')<span class="err-msg">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-footer">
                    <div class="footer-right">
                        <a href="{{ route('productos.index') }}" class="btn-cancel">← Cancelar</a>
                        <button type="submit" class="btn-save">💾 Guardar cambios</button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Formulario de eliminar FUERA del form de editar --}}
        <form method="POST" action="{{ route('productos.destroy', $producto->id) }}" onsubmit="return confirm('¿Eliminar este producto? Esta acción no se puede deshacer.')" style="margin-top:.75rem;">
            @csrf @method('DELETE')
            <button type="submit" class="btn-delete">🗑 Eliminar producto</button>
        </form>

    </div>
</x-app-layout>
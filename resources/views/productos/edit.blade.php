<x-app-layout>
<link rel="stylesheet" href="{{ asset('css/productos.css') }}">

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
                            <input type="text" value="{{ $producto->creado_por }}" readonly style="opacity:.6;cursor:not-allowed;">
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

        <form method="POST" action="{{ route('productos.destroy', $producto->id) }}" onsubmit="return confirm('¿Eliminar este producto? Esta acción no se puede deshacer.')" style="margin-top:.75rem;">
            @csrf @method('DELETE')
            <button type="submit" class="btn-delete">🗑 Eliminar producto</button>
        </form>

    </div>
</x-app-layout>
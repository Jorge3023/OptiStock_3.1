<x-app-layout>
<link rel="stylesheet" href="{{ asset('css/productos.css') }}">

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
                            <input type="text" name="creado_por" value="{{ Auth::user()->name }}" readonly style="opacity:.6;cursor:not-allowed;">
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
<x-app-layout>
<link rel="stylesheet" href="{{ asset('css/cambios.css') }}">

    <div class="cw">

        <div class="page-header">
            <div>
                <h1>Últimos Cambios</h1>
                <p>Registro de actividad sobre productos — últimos 100 eventos.</p>
            </div>
            <a href="{{ route('productos.index') }}" class="btn-back">← Productos</a>
        </div>

        <div class="stats">
            <div class="stat">
                <div class="stat-ico">✅</div>
                <div class="stat-info">
                    <label>Creados</label>
                    <span>{{ $cambios->where('accion','creado')->count() }}</span>
                </div>
            </div>
            <div class="stat">
                <div class="stat-ico">✏️</div>
                <div class="stat-info">
                    <label>Editados</label>
                    <span>{{ $cambios->where('accion','editado')->count() }}</span>
                </div>
            </div>
            <div class="stat">
                <div class="stat-ico">🗑</div>
                <div class="stat-info">
                    <label>Eliminados</label>
                    <span>{{ $cambios->where('accion','eliminado')->count() }}</span>
                </div>
            </div>
            <div class="stat">
                <div class="stat-ico">📋</div>
                <div class="stat-info">
                    <label>Total eventos</label>
                    <span>{{ $cambios->count() }}</span>
                </div>
            </div>
        </div>

        <div class="timeline">
            @forelse($cambios as $c)
            <div class="cambio-card">
                <div class="cambio-icon {{ $c->accion }}">
                    @if($c->accion === 'creado')   ✅
                    @elseif($c->accion === 'editado') ✏️
                    @else 🗑
                    @endif
                </div>
                <div class="cambio-body">
                    <div class="cambio-title">{{ $c->producto_nombre }}</div>
                    <div class="cambio-detalle">{{ $c->detalle }}</div>
                </div>
                <div class="cambio-meta">
                    <span class="badge {{ $c->accion }}">{{ $c->accion }}</span>
                    <span class="cambio-usuario">👤 {{ $c->usuario }}</span>
                    <span class="cambio-fecha">{{ \Carbon\Carbon::parse($c->created_at)->format('d/m/Y H:i') }}</span>
                </div>
            </div>
            @empty
            <div class="empty">
                <div class="ei">📭</div>
                <h3>Sin actividad registrada</h3>
                <p>Los cambios aparecerán aquí al crear, editar o eliminar productos.</p>
            </div>
            @endforelse
        </div>

    </div>
</x-app-layout>
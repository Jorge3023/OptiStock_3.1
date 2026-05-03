<x-app-layout>

{{-- CSS separado --}}
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<div class="dw">

    {{-- Greeting --}}
    <div class="greet">
        <div>
            <h1>Bienvenido, {{ Auth::user()->name }} 👋</h1>
            <p>Resumen general de tu inventario y actividad.</p>
        </div>
        <div class="live-badge"><span class="dot"></span>Sesión activa</div>
    </div>

    {{-- KPI Cards --}}
    <div class="kpi-grid">
        <div class="kpi blue" style="animation-delay:.05s">
            <div class="kpi-ico">📦</div>
            <div class="kpi-label">Total Productos</div>
            <div class="kpi-val">{{ $productos->count() }}</div>
            <div class="kpi-sub">en catálogo</div>
        </div>
        <div class="kpi green" style="animation-delay:.1s">
            <div class="kpi-ico">✅</div>
            <div class="kpi-label">Disponibles</div>
            <div class="kpi-val">{{ $productos->where('estado','Disponible')->count() }}</div>
            <div class="kpi-sub">con stock</div>
        </div>
        <div class="kpi warn" style="animation-delay:.15s">
            <div class="kpi-ico">⚠️</div>
            <div class="kpi-label">Stock Bajo</div>
            <div class="kpi-val">{{ $productos->where('stock','<',5)->where('stock','>',0)->count() }}</div>
            <div class="kpi-sub">menos de 5 unidades</div>
        </div>
        <div class="kpi red" style="animation-delay:.2s">
            <div class="kpi-ico">🚫</div>
            <div class="kpi-label">Sin existencia</div>
            <div class="kpi-val">{{ $productos->where('estado','Sin existencia')->count() }}</div>
            <div class="kpi-sub">agotados</div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="charts-row">

        {{-- Dona: estado --}}
        <div class="chart-card" style="animation-delay:.25s">
            <h3>Estado del inventario</h3>
            <canvas id="chartDona"></canvas>
        </div>

        {{-- Barras: top 6 stock --}}
        <div class="chart-card" style="animation-delay:.3s">
            <h3>Top productos por stock</h3>
            <canvas id="chartBarras"></canvas>
        </div>

        {{-- Stock crítico --}}
        <div class="chart-card" style="animation-delay:.35s">
            <h3>⚠️ Stock crítico</h3>
            <div class="stock-bars">
                @php
                    $criticos = $productos->where('stock','<',5)->sortBy('stock')->take(6);
                    $maxStock = $criticos->max('stock') ?: 1;
                @endphp
                @forelse($criticos as $p)
                <div class="stock-bar-item">
                    <div class="stock-bar-header">
                        <span class="stock-bar-name">{{ $p->nombre }}</span>
                        <span class="stock-bar-val">{{ $p->stock }} uds</span>
                    </div>
                    <div class="stock-bar-track">
                        <div class="stock-bar-fill" style="width:{{ $p->stock == 0 ? 100 : ($p->stock/$maxStock*100) }}%;background:{{ $p->stock == 0 ? '#ff5c7a' : '#f5a623' }};"></div>
                    </div>
                </div>
                @empty
                <div style="text-align:center;padding:2rem 0;color:var(--t3);font-size:.83rem;">
                    ✅ Todo el stock está saludable
                </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- Products table (ultimos 5) --}}
    <div class="sec-head">
        <div class="sec-title">Últimos productos <small>{{ $productos->count() }} en total</small></div>
        <a href="{{ route('productos.index') }}" class="btn-new">Ver todos →</a>
    </div>

    <div class="tbl-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Código barras</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Estado</th>
                    <th>Cargo</th>
                    <th>Creado por</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productos->sortByDesc('created_at')->take(5) as $p)
                <tr>
                    <td style="color:var(--t3);font-size:.75rem;">{{ $p->id }}</td>
                    <td class="td-name">{{ $p->nombre }}</td>
                    <td class="td-code">{{ $p->codigo_barras }}</td>
                    <td class="td-price">${{ number_format($p->precio, 2) }}</td>
                    <td>
                        @if($p->stock === 0)
                            <span class="badge danger">0 uds</span>
                        @elseif($p->stock < 5)
                            <span class="badge warn">{{ $p->stock }} uds</span>
                        @else
                            <span class="badge blue">{{ $p->stock }} uds</span>
                        @endif
                    </td>
                    <td>
                        @if($p->estado === 'Disponible')
                            <span class="badge ok">● Disponible</span>
                        @else
                            <span class="badge danger">● Sin existencia</span>
                        @endif
                    </td>
                    <td>{{ $p->cargo ?? '—' }}</td>
                    <td>{{ $p->creado_por ?? '—' }}</td>
                    <td style="white-space:nowrap;">{{ \Carbon\Carbon::parse($p->created_at)->format('d/m/Y') }}</td>
                    <td>
                        <div class="td-actions">
                            <a href="{{ route('productos.edit', $p->id) }}" class="ic-btn" title="Editar">✏️</a>
                            <form method="POST" action="{{ route('productos.destroy', $p->id) }}" onsubmit="return confirm('¿Eliminar este producto?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="ic-btn del" title="Eliminar">🗑</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="10">
                    <div class="empty">
                        <div class="ei">📭</div>
                        <h3>Sin productos aún</h3>
                        <p>Agrega tu primer producto al catálogo.</p>
                        <a href="{{ route('productos.create') }}" class="btn-new">+ Nuevo producto</a>
                    </div>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<script>
const disponibles = {{ $productos->where('estado','Disponible')->count() }};
const sinExistencia = {{ $productos->where('estado','Sin existencia')->count() }};

const top6 = {!! json_encode(
    $productos->sortByDesc('stock')->take(6)->map(function($p) {
        return [
            'nombre' => \Illuminate\Support\Str::limit($p->nombre, 14),
            'stock'  => $p->stock,
        ];
    })->values()
) !!};

Chart.defaults.color = '#8a9bbf';
Chart.defaults.borderColor = 'rgba(99,120,180,.1)';
Chart.defaults.font.family = "'DM Sans', sans-serif";

new Chart(document.getElementById('chartDona'), {
    type: 'doughnut',
    data: {
        labels: ['Disponible', 'Sin existencia'],
        datasets: [{
            data: [disponibles, sinExistencia],
            backgroundColor: ['rgba(45,212,160,.85)', 'rgba(255,92,122,.85)'],
            borderColor: ['#0f1521'],
            borderWidth: 3,
            hoverOffset: 6,
        }]
    },
    options: {
        cutout: '72%',
        plugins: { legend: { position: 'bottom', labels: { padding: 16, font: { size: 12 } } } },
        animation: { animateRotate: true, duration: 900 }
    }
});

new Chart(document.getElementById('chartBarras'), {
    type: 'bar',
    data: {
        labels: top6.map(p => p.nombre),
        datasets: [{
            label: 'Stock',
            data: top6.map(p => p.stock),
            backgroundColor: top6.map(p =>
                p.stock === 0 ? 'rgba(255,92,122,.7)' :
                p.stock < 5  ? 'rgba(245,166,35,.7)' :
                               'rgba(79,124,255,.7)'
            ),
            borderRadius: 6,
            borderSkipped: false,
        }]
    },
    options: {
        indexAxis: 'y',
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { color: 'rgba(99,120,180,.08)' }, ticks: { font: { size: 11 } } },
            y: { grid: { display: false }, ticks: { font: { size: 11 } } }
        },
        animation: { duration: 900 }
    }
});
</script>

</x-app-layout>
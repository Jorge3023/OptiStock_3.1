<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap');
        :root {
            --bg:        #090d13;
            --card:      #0f1521;
            --card-h:    #141d2e;
            --border:    rgba(99,120,180,.12);
            --border-h:  rgba(99,120,180,.28);
            --accent:    #4f7cff;
            --accent-s:  rgba(79,124,255,.13);
            --accent-g:  rgba(79,124,255,.28);
            --ok:        #2dd4a0;
            --ok-s:      rgba(45,212,160,.13);
            --warn:      #f5a623;
            --warn-s:    rgba(245,166,35,.13);
            --danger:    #ff5c7a;
            --danger-s:  rgba(255,92,122,.13);
            --t1:        #e8edf5;
            --t2:        #8a9bbf;
            --t3:        #4a5878;
        }
        body { background: var(--bg); font-family: 'DM Sans', sans-serif; }

        .dw { max-width:1280px; margin:0 auto; padding:2.5rem 1.5rem 4rem; }

        /* greeting */
        .greet { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem; margin-bottom:2.5rem; }
        .greet h1 { font-family:'Syne',sans-serif; font-size:2rem; font-weight:800; color:var(--t1); letter-spacing:-.03em; margin:0 0 .2rem; }
        .greet p  { color:var(--t2); font-size:.92rem; margin:0; }
        .live-badge { display:flex; align-items:center; gap:.45rem; background:var(--ok-s); border:1px solid rgba(45,212,160,.22); border-radius:99px; padding:.4rem .9rem; font-size:.78rem; color:var(--ok); font-weight:500; }
        .live-badge .dot { width:7px; height:7px; background:var(--ok); border-radius:50%; animation:pulse 2s infinite; }
        @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(1.4)} }

        /* kpi */
        .kpi-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(190px,1fr)); gap:1rem; margin-bottom:2.5rem; }
        .kpi { background:var(--card); border:1px solid var(--border); border-radius:16px; padding:1.3rem 1.5rem; position:relative; overflow:hidden; transition:border-color .2s,transform .2s; }
        .kpi:hover { border-color:var(--border-h); transform:translateY(-2px); }
        .kpi::before { content:''; position:absolute; inset:0; background:radial-gradient(circle at 80% 20%, var(--g,transparent) 0%, transparent 60%); pointer-events:none; }
        .kpi.blue  { --g:var(--accent-g); }
        .kpi.green { --g:rgba(45,212,160,.16); }
        .kpi.warn  { --g:rgba(245,166,35,.16); }
        .kpi.red   { --g:rgba(255,92,122,.16); }
        .kpi-ico { position:absolute; top:1.1rem; right:1.1rem; width:34px; height:34px; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:.95rem; }
        .kpi.blue  .kpi-ico { background:var(--accent-s); }
        .kpi.green .kpi-ico { background:var(--ok-s); }
        .kpi.warn  .kpi-ico { background:var(--warn-s); }
        .kpi.red   .kpi-ico { background:var(--danger-s); }
        .kpi-label { font-size:.72rem; text-transform:uppercase; letter-spacing:.08em; color:var(--t3); margin-bottom:.5rem; font-weight:500; }
        .kpi-val   { font-family:'Syne',sans-serif; font-size:2.1rem; font-weight:800; color:var(--t1); letter-spacing:-.03em; line-height:1; }
        .kpi-sub   { font-size:.78rem; color:var(--t2); margin-top:.35rem; }

        /* section */
        .sec-head { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:.75rem; margin-bottom:1.2rem; }
        .sec-title { font-family:'Syne',sans-serif; font-size:1.1rem; font-weight:700; color:var(--t1); letter-spacing:-.02em; }
        .sec-title small { font-size:.78rem; font-weight:400; color:var(--t3); font-family:'DM Sans',sans-serif; margin-left:.4rem; }
        .btn-new { display:inline-flex; align-items:center; gap:.4rem; background:var(--accent); color:#fff; border:none; border-radius:10px; padding:.5rem 1.1rem; font-size:.83rem; font-weight:500; font-family:'DM Sans',sans-serif; cursor:pointer; text-decoration:none; transition:opacity .15s,transform .15s,box-shadow .15s; box-shadow:0 4px 16px rgba(79,124,255,.32); }
        .btn-new:hover { opacity:.88; transform:translateY(-1px); box-shadow:0 6px 22px rgba(79,124,255,.42); color:#fff; }

        .badge { display:inline-flex; align-items:center; gap:.28rem; font-size:.71rem; font-weight:500; padding:.22rem .55rem; border-radius:99px; }
        .badge.ok     { background:var(--ok-s);     color:var(--ok); }
        .badge.warn   { background:var(--warn-s);   color:var(--warn); }
        .badge.danger { background:var(--danger-s); color:var(--danger); }
        .badge.blue   { background:var(--accent-s); color:var(--accent); }
        .badge.muted  { background:rgba(74,88,120,.18); color:var(--t3); }

        .ic-btn { width:30px; height:30px; border-radius:7px; border:1px solid var(--border); background:transparent; color:var(--t2); display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:.8rem; text-decoration:none; transition:background .15s,border-color .15s,color .15s; }
        .ic-btn:hover { background:var(--card-h); border-color:var(--border-h); color:var(--t1); }
        .ic-btn.del:hover { background:var(--danger-s); border-color:rgba(255,92,122,.3); color:var(--danger); }

        /* empty */
        .empty { text-align:center; padding:4rem 2rem; }
        .empty .ei { font-size:3rem; margin-bottom:1rem; }
        .empty h3 { font-family:'Syne',sans-serif; color:var(--t2); font-size:1.05rem; margin:0 0 .4rem; }
        .empty p  { font-size:.83rem; color:var(--t3); margin:0 0 1.5rem; }

        /* product list */
        .tbl-wrap { background:var(--card); border:1px solid var(--border); border-radius:16px; overflow:hidden; }
        table { width:100%; border-collapse:collapse; }
        thead tr { border-bottom:1px solid var(--border); }
        thead th { padding:.75rem 1.1rem; text-align:left; font-size:.7rem; text-transform:uppercase; letter-spacing:.08em; color:var(--t3); font-weight:600; white-space:nowrap; }
        tbody tr { border-bottom:1px solid var(--border); transition:background .15s; animation:fadeUp .3s ease both; }
        tbody tr:last-child { border-bottom:none; }
        tbody tr:hover { background:var(--card-h); }
        tbody td { padding:.8rem 1.1rem; font-size:.85rem; color:var(--t2); vertical-align:middle; }
        tbody td.td-name  { color:var(--t1); font-weight:500; }
        tbody td.td-price { font-family:'Syne',sans-serif; font-weight:700; color:var(--accent); }
        tbody td.td-code  { font-family:monospace; font-size:.78rem; color:var(--t3); }
        .td-actions { display:flex; gap:.4rem; }
    </style>

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
            <div class="kpi blue">
                <div class="kpi-ico">📦</div>
                <div class="kpi-label">Total Productos</div>
                <div class="kpi-val">{{ $productos->count() }}</div>
                <div class="kpi-sub">en catálogo</div>
            </div>
            <div class="kpi green">
                <div class="kpi-ico">✅</div>
                <div class="kpi-label">Disponibles</div>
                <div class="kpi-val">{{ $productos->where('estado','Disponible')->count() }}</div>
                <div class="kpi-sub">con stock</div>
            </div>
            <div class="kpi warn">
                <div class="kpi-ico">⚠️</div>
                <div class="kpi-label">Stock Bajo</div>
                <div class="kpi-val">{{ $productos->where('stock','<',5)->where('stock','>',0)->count() }}</div>
                <div class="kpi-sub">menos de 5 unidades</div>
            </div>
            <div class="kpi red">
                <div class="kpi-ico">🚫</div>
                <div class="kpi-label">Sin existencia</div>
                <div class="kpi-val">{{ $productos->where('estado','Sin existencia')->count() }}</div>
                <div class="kpi-sub">agotados</div>
            </div>
        </div>

        {{-- Products list --}}
        <div class="sec-head">
            <div class="sec-title">Productos <small>{{ $productos->count() }} registros</small></div>
            <a href="{{ route('productos.create') }}" class="btn-new">+ Nuevo</a>
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
                    @forelse($productos as $p)
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
</x-app-layout>
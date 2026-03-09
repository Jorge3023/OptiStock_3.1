<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap');
        :root {
            --bg:#090d13; --card:#0f1521; --card-h:#141d2e;
            --border:rgba(99,120,180,.12); --border-h:rgba(99,120,180,.28);
            --accent:#4f7cff; --accent-s:rgba(79,124,255,.13); --accent-g:rgba(79,124,255,.28);
            --ok:#2dd4a0; --ok-s:rgba(45,212,160,.13);
            --warn:#f5a623; --warn-s:rgba(245,166,35,.13);
            --danger:#ff5c7a; --danger-s:rgba(255,92,122,.13);
            --t1:#e8edf5; --t2:#8a9bbf; --t3:#4a5878;
        }
        body { background:var(--bg); font-family:'DM Sans',sans-serif; }
        .pw { max-width:1280px; margin:0 auto; padding:2.5rem 1.5rem 4rem; }

        /* toolbar */
        .toolbar { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem; margin-bottom:1.5rem; }
        .toolbar-left { display:flex; align-items:center; gap:.75rem; flex-wrap:wrap; }
        .page-title { font-family:'Syne',sans-serif; font-size:1.6rem; font-weight:800; color:var(--t1); letter-spacing:-.03em; margin:0; }

        .search-wrap { position:relative; }
        .search-wrap input { background:var(--card); border:1px solid var(--border); color:var(--t1); border-radius:10px; padding:.48rem .9rem .48rem 2.2rem; font-size:.85rem; font-family:'DM Sans',sans-serif; width:220px; outline:none; transition:border-color .2s,box-shadow .2s; }
        .search-wrap input:focus { border-color:var(--accent); box-shadow:0 0 0 3px var(--accent-s); }
        .search-wrap input::placeholder { color:var(--t3); }
        .search-icon { position:absolute; left:.7rem; top:50%; transform:translateY(-50%); color:var(--t3); font-size:.85rem; pointer-events:none; }

        select.filter { background:var(--card); border:1px solid var(--border); color:var(--t2); border-radius:10px; padding:.48rem .9rem; font-size:.83rem; font-family:'DM Sans',sans-serif; outline:none; cursor:pointer; transition:border-color .2s; }
        select.filter:focus { border-color:var(--accent); }

        .btn-new { display:inline-flex; align-items:center; gap:.4rem; background:var(--accent); color:#fff; border:none; border-radius:10px; padding:.5rem 1.1rem; font-size:.83rem; font-weight:500; font-family:'DM Sans',sans-serif; cursor:pointer; text-decoration:none; transition:opacity .15s,transform .15s,box-shadow .15s; box-shadow:0 4px 16px rgba(79,124,255,.32); }
        .btn-new:hover { opacity:.88; transform:translateY(-1px); color:#fff; }

        /* alerts */
        .alert { padding:.85rem 1.2rem; border-radius:12px; font-size:.85rem; margin-bottom:1.5rem; display:flex; align-items:center; gap:.6rem; }
        .alert.ok { background:var(--ok-s); border:1px solid rgba(45,212,160,.22); color:var(--ok); }
        .alert.err { background:var(--danger-s); border:1px solid rgba(255,92,122,.22); color:var(--danger); }

        /* table */
        .tbl-wrap { background:var(--card); border:1px solid var(--border); border-radius:16px; overflow:hidden; }
        table { width:100%; border-collapse:collapse; }
        thead tr { border-bottom:1px solid var(--border); }
        thead th { padding:.8rem 1.1rem; text-align:left; font-size:.72rem; text-transform:uppercase; letter-spacing:.08em; color:var(--t3); font-weight:600; white-space:nowrap; }
        tbody tr { border-bottom:1px solid var(--border); transition:background .15s; }
        tbody tr:last-child { border-bottom:none; }
        tbody tr:hover { background:var(--card-h); }
        tbody td { padding:.85rem 1.1rem; font-size:.85rem; color:var(--t2); vertical-align:middle; }
        tbody td.td-name { color:var(--t1); font-weight:500; }
        tbody td.td-price { font-family:'Syne',sans-serif; font-weight:700; color:var(--accent); }
        tbody td.td-code { font-family:monospace; font-size:.8rem; color:var(--t3); }

        .badge { display:inline-flex; align-items:center; gap:.28rem; font-size:.71rem; font-weight:500; padding:.22rem .55rem; border-radius:99px; }
        .badge.ok     { background:var(--ok-s);     color:var(--ok); }
        .badge.warn   { background:var(--warn-s);   color:var(--warn); }
        .badge.danger { background:var(--danger-s); color:var(--danger); }
        .badge.muted  { background:rgba(74,88,120,.18); color:var(--t3); }

        .td-actions { display:flex; gap:.4rem; }
        .ic-btn { width:30px; height:30px; border-radius:7px; border:1px solid var(--border); background:transparent; color:var(--t2); display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:.78rem; text-decoration:none; transition:background .15s,border-color .15s,color .15s; }
        .ic-btn:hover { background:var(--card-h); border-color:var(--border-h); color:var(--t1); }
        .ic-btn.del:hover { background:var(--danger-s); border-color:rgba(255,92,122,.3); color:var(--danger); }

        /* empty */
        .empty { text-align:center; padding:4rem 2rem; }
        .empty .ei { font-size:2.5rem; margin-bottom:.8rem; }
        .empty h3 { font-family:'Syne',sans-serif; color:var(--t2); font-size:1rem; margin:0 0 .4rem; }
        .empty p  { font-size:.82rem; color:var(--t3); margin:0; }

        /* pagination */
        .pag { display:flex; justify-content:center; margin-top:1.5rem; }
        .pag nav span, .pag nav a { display:inline-flex; align-items:center; justify-content:center; min-width:34px; height:34px; border-radius:8px; border:1px solid var(--border); font-size:.83rem; color:var(--t2); text-decoration:none; background:var(--card); margin:0 2px; padding:0 .5rem; transition:background .15s,color .15s,border-color .15s; }
        .pag nav a:hover { background:var(--card-h); border-color:var(--border-h); color:var(--t1); }
        .pag nav span[aria-current] { background:var(--accent-s); border-color:rgba(79,124,255,.3); color:var(--accent); font-weight:600; }
    </style>

    <div class="pw">

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert ok">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert err">❌ {{ session('error') }}</div>
        @endif

        {{-- Toolbar --}}
        <div class="toolbar">
            <div class="toolbar-left">
                <h1 class="page-title">Productos</h1>
                <span style="color:var(--t3);font-size:.82rem;">{{ $productos->count() }} registros</span>
            </div>
            <div class="toolbar-left">
                <form method="GET" action="{{ route('productos.index') }}" style="display:flex;gap:.6rem;flex-wrap:wrap;">
                    <div class="search-wrap">
                        <span class="search-icon">🔍</span>
                        <input type="text" name="search" placeholder="Buscar producto..." value="{{ request('search') }}">
                    </div>
                    <select name="estado" class="filter" onchange="this.form.submit()">
                        <option value="">Todos</option>
                        <option value="Disponible"     {{ request('estado')=='Disponible'     ? 'selected':'' }}>Disponible</option>
                        <option value="Sin existencia" {{ request('estado')=='Sin existencia' ? 'selected':'' }}>Sin existencia</option>
                    </select>
                </form>
                <a href="{{ route('productos.create') }}" class="btn-new">+ Nuevo</a>
            </div>
        </div>

        {{-- Table --}}
        <div class="tbl-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Código de barras</th>
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
                        <td style="color:var(--t3);font-size:.78rem;">{{ $p->id }}</td>
                        <td class="td-name">{{ $p->nombre }}</td>
                        <td class="td-code">{{ $p->codigo_barras }}</td>
                        <td class="td-price">${{ number_format($p->precio, 2) }}</td>
                        <td>
                            @if($p->stock === 0)
                                <span class="badge danger">0 uds</span>
                            @elseif($p->stock < 5)
                                <span class="badge warn">{{ $p->stock }} uds</span>
                            @else
                                <span class="badge ok">{{ $p->stock }} uds</span>
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
                                <a href="{{ route('productos.show', $p->id) }}" class="ic-btn" title="Ver">👁</a>
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
                            <h3>Sin productos</h3>
                            <p>Agrega tu primer producto con el botón "+ Nuevo".</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if(method_exists($productos, 'links'))
        <div class="pag">{{ $productos->withQueryString()->links() }}</div>
        @endif

    </div>
</x-app-layout>
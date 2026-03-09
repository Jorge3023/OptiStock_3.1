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
        .cw { max-width:1100px; margin:0 auto; padding:2.5rem 1.5rem 4rem; }

        .page-header { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem; margin-bottom:2rem; }
        .page-header h1 { font-family:'Syne',sans-serif; font-size:1.7rem; font-weight:800; color:var(--t1); letter-spacing:-.03em; margin:0; }
        .page-header p  { color:var(--t2); font-size:.88rem; margin:.25rem 0 0; }
        .btn-back { display:inline-flex; align-items:center; gap:.4rem; background:transparent; color:var(--t2); border:1px solid var(--border); border-radius:10px; padding:.45rem 1rem; font-size:.83rem; font-family:'DM Sans',sans-serif; cursor:pointer; text-decoration:none; transition:background .15s,color .15s,border-color .15s; }
        .btn-back:hover { background:var(--card-h); border-color:var(--border-h); color:var(--t1); }

        /* timeline */
        .timeline { display:flex; flex-direction:column; gap:.75rem; }

        .cambio-card {
            background:var(--card);
            border:1px solid var(--border);
            border-radius:14px;
            padding:1.1rem 1.3rem;
            display:grid;
            grid-template-columns:auto 1fr auto;
            align-items:center;
            gap:1rem;
            transition:border-color .2s, transform .2s;
            animation:fadeUp .3s ease both;
        }
        .cambio-card:hover { border-color:var(--border-h); transform:translateX(3px); }
        @keyframes fadeUp { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }

        .cambio-icon {
            width:40px; height:40px; border-radius:11px;
            display:flex; align-items:center; justify-content:center;
            font-size:1.1rem; flex-shrink:0;
        }
        .cambio-icon.creado   { background:var(--ok-s); }
        .cambio-icon.editado  { background:var(--accent-s); }
        .cambio-icon.eliminado{ background:var(--danger-s); }

        .cambio-body { min-width:0; }
        .cambio-title {
            font-family:'Syne',sans-serif;
            font-size:.95rem; font-weight:700;
            color:var(--t1); margin:0 0 .25rem;
            white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
        }
        .cambio-detalle {
            font-size:.8rem; color:var(--t2);
            line-height:1.5;
            display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;
        }
        .cambio-meta { display:flex; flex-direction:column; align-items:flex-end; gap:.3rem; flex-shrink:0; }

        .badge { display:inline-flex; align-items:center; gap:.25rem; font-size:.7rem; font-weight:600; padding:.2rem .55rem; border-radius:99px; text-transform:uppercase; letter-spacing:.05em; }
        .badge.creado   { background:var(--ok-s);     color:var(--ok); }
        .badge.editado  { background:var(--accent-s); color:var(--accent); }
        .badge.eliminado{ background:var(--danger-s); color:var(--danger); }

        .cambio-usuario { font-size:.75rem; color:var(--t3); }
        .cambio-fecha   { font-size:.72rem; color:var(--t3); white-space:nowrap; }

        /* empty */
        .empty { text-align:center; padding:5rem 2rem; }
        .empty .ei { font-size:3rem; margin-bottom:1rem; }
        .empty h3 { font-family:'Syne',sans-serif; color:var(--t2); font-size:1.05rem; margin:0 0 .4rem; }
        .empty p  { font-size:.83rem; color:var(--t3); margin:0; }

        /* stats strip */
        .stats { display:flex; gap:1rem; margin-bottom:1.8rem; flex-wrap:wrap; }
        .stat { background:var(--card); border:1px solid var(--border); border-radius:12px; padding:.8rem 1.2rem; display:flex; align-items:center; gap:.7rem; flex:1; min-width:140px; }
        .stat-ico { font-size:1.1rem; }
        .stat-info label { font-size:.7rem; text-transform:uppercase; letter-spacing:.07em; color:var(--t3); font-weight:600; display:block; }
        .stat-info span  { font-family:'Syne',sans-serif; font-size:1.3rem; font-weight:800; color:var(--t1); }
    </style>

    <div class="cw">

        <div class="page-header">
            <div>
                <h1>Últimos Cambios</h1>
                <p>Registro de actividad sobre productos — últimos 100 eventos.</p>
            </div>
            <a href="{{ route('productos.index') }}" class="btn-back">← Productos</a>
        </div>

        {{-- Stats --}}
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

        {{-- Timeline --}}
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
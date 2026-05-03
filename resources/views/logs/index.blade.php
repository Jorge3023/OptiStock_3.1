<x-app-layout>
<link rel="stylesheet" href="{{ asset('css/logs.css') }}">

    <div class="lw">

        <div class="page-header">
            <div>
                <h1>Logs de Sesión</h1>
                <p>Registro de accesos, intentos fallidos y actividad de usuarios — últimos 100 eventos.</p>
            </div>
        </div>

        <div class="stats">
            <div class="stat">
                <div style="font-size:1.1rem">✅</div>
                <div class="stat-info">
                    <label>Logins exitosos</label>
                    <span>{{ $logs->where('accion','login_exitoso')->count() }}</span>
                </div>
            </div>
            <div class="stat">
                <div style="font-size:1.1rem">❌</div>
                <div class="stat-info">
                    <label>Intentos fallidos</label>
                    <span>{{ $logs->where('accion','login_fallido')->count() }}</span>
                </div>
            </div>
            <div class="stat">
                <div style="font-size:1.1rem">🚪</div>
                <div class="stat-info">
                    <label>Logouts</label>
                    <span>{{ $logs->where('accion','logout')->count() }}</span>
                </div>
            </div>
            <div class="stat">
                <div style="font-size:1.1rem">📋</div>
                <div class="stat-info">
                    <label>Total eventos</label>
                    <span>{{ $logs->count() }}</span>
                </div>
            </div>
        </div>

        <div class="tbl-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Acción</th>
                        <th>IP</th>
                        <th>Dispositivo</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td style="color:var(--t3);font-size:.75rem;">{{ $log->id }}</td>
                        <td class="td-main">{{ $log->usuario ?? '—' }}</td>
                        <td class="td-code">{{ $log->email }}</td>
                        <td>
                            @if($log->accion === 'login_exitoso')
                                <span class="badge ok">✅ Login exitoso</span>
                            @elseif($log->accion === 'login_fallido')
                                <span class="badge danger">❌ Login fallido</span>
                            @elseif($log->accion === 'logout')
                                <span class="badge warn">🚪 Logout</span>
                            @elseif($log->accion === 'registro')
                                <span class="badge blue">📝 Registro</span>
                            @else
                                <span class="badge">{{ $log->accion }}</span>
                            @endif
                        </td>
                        <td class="td-code">{{ $log->ip }}</td>
                        <td><div class="dispositivo" title="{{ $log->dispositivo }}">{{ $log->dispositivo }}</div></td>
                        <td style="white-space:nowrap;">{{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7">
                        <div class="empty">
                            <div class="ei">📭</div>
                            <h3>Sin registros aún</h3>
                            <p>Los eventos aparecerán aquí al iniciar o cerrar sesión.</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
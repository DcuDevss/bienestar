<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Estadística — Licencias</title>
  <style>
    @media print { .no-print { display:none } }
    body { font-family: "Segoe UI", Arial, sans-serif; font-size: 13px; color: #222; margin: 30px; background: #fff; }
    .header { text-align: center; margin-bottom: 20px; }
    .header img { width: 90px; height: auto; display: block; margin: 0 auto 8px; }
    .header h1 { font-size: 20px; margin: 4px 0; font-weight: 700; color: #1e3a5f; }
    .header h2 { font-size: 16px; margin: 0; color: #444; font-weight: 500; }
    .filters { margin: 10px 0 18px; padding: 8px 12px; background: #f3f6fa; border-left: 4px solid #2d5986; border-radius: 4px; }
    .section-title { margin-top: 18px; font-weight: 700; color: #1e3a5f; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #ccc; padding: 8px 10px; }
    th { background: #2d5986; color: #fff; font-weight: 600; text-align: left; font-size: 13px; }
    tr:nth-child(even) td { background: #f9f9f9; }
    .right { text-align: right; }
    .footer { margin-top: 25px; text-align: right; font-size: 11px; color: #666; }
    .no-print-btn { background: #2d5986; color: white; border: none; border-radius: 4px; padding: 8px 14px; cursor: pointer; margin-bottom: 12px; }
    .no-print-btn:hover { background: #244a70; }
  </style>
</head>
<body onload="window.print()">

  <button class="no-print no-print-btn" onclick="window.print()">Imprimir / Guardar como PDF</button>

  <div class="header">
    <img src="{{ asset('assets/escudo_128x128.png') }}" alt="Escudo" width="90">
    <h1>División Bienestar Policial</h1>
    <h2>Estadística de Licencias</h2>
  </div>

  @php
    use App\Models\Tipolicencia;
    use App\Models\Ciudade;
    use Carbon\Carbon;

    $tiposIds = collect($filtros['tipolicencia_ids'] ?? []);
    $ciudsIds = collect($filtros['ciudad_ids'] ?? []);

    $tiposTxt = $tiposIds->isNotEmpty()
        ? Tipolicencia::whereIn('id', $tiposIds)->pluck('name')->implode(', ')
        : 'Todas';

    $ciudsTxt = $ciudsIds->isNotEmpty()
        ? Ciudade::whereIn('id', $ciudsIds)->pluck('nombre')->implode(', ')
        : 'Todas';

    $desdeTxt = !empty($filtros['desde'] ?? null) ? Carbon::parse($filtros['desde'])->format('d-m-Y') : '—';
    $hastaTxt = !empty($filtros['hasta'] ?? null) ? Carbon::parse($filtros['hasta'])->format('d-m-Y') : '—';
  @endphp

  <div class="filters">
    <strong>Filtros:</strong>
    Tipo Licencia: {{ $tiposTxt }} |
    Ciudad: {{ $ciudsTxt }} |
    Desde: {{ $desdeTxt }} |
    Hasta: {{ $hastaTxt }}
  </div>

  {{-- DETALLE DE PACIENTES --}}
  <h3 class="section-title">Detalle de pacientes</h3>
  <table>
    <thead>
      <tr>
        <th>Paciente</th>
        <th>DNI</th>
        <th>Tipo Licencia</th>
        <th>Ciudad</th>
        <th>Desde</th>
        <th>Hasta</th>
      </tr>
    </thead>
    <tbody>
      @forelse($rows as $r)
        <tr>
          <td>{{ $r->apellido_nombre ?? '—' }}</td>
          <td>{{ $r->dni ?? '—' }}</td>
          <td>{{ $r->tipolicencia ?? 'Sin tipo' }}</td>
          <td>{{ $r->ciudad ?? 'Sin ciudad' }}</td>
          <td>
            {{ !empty($r->fecha_inicio_licencia)
                ? \Carbon\Carbon::parse($r->fecha_inicio_licencia)->format('d-m-Y H:i')
                : '—' }}
          </td>
          <td>
            {{ !empty($r->fecha_finalizacion_licencia)
                ? \Carbon\Carbon::parse($r->fecha_finalizacion_licencia)->format('d-m-Y H:i')
                : '—' }}
          </td>
        </tr>
      @empty
        <tr><td colspan="6" class="right">Sin datos</td></tr>
      @endforelse
    </tbody>
  </table>

  {{-- RESUMEN POR TIPO DE LICENCIA --}}
  <h3 class="section-title">Resumen por tipo de licencia</h3>
  <table>
    <thead>
      <tr>
        <th>Tipo Licencia</th>
        <th class="right">Total</th>
      </tr>
    </thead>
    <tbody>
      @forelse($totales as $t)
        <tr>
          <td>{{ $t->tipolicencia ?? 'Sin tipo' }}</td>
          <td class="right">{{ $t->total }}</td>
        </tr>
      @empty
        <tr><td colspan="2" class="right">Sin datos</td></tr>
      @endforelse
      <tr>
        <td><strong>Total General</strong></td>
        <td class="right"><strong>{{ $totalGeneral }}</strong></td>
      </tr>
    </tbody>
  </table>

    <div class="footer">
        Generado el — {{ now()->timezone('America/Argentina/Buenos_Aires')->format('d/m/Y H:i') }}
    </div>


</body>
</html>

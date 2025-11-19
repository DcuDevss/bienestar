<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Estadística — Estado del Personal</title>
  <style>
    @media print { .no-print { display:none } }
    body { font-family: "Segoe UI", Arial, sans-serif; font-size: 13px; color: #222; margin: 30px; background: #fff; }
    .header { text-align: center; margin-bottom: 20px; }
    .header img { width: 90px; display:block; margin:0 auto 8px; }
    .header h1 { font-size:20px; margin:4px 0; font-weight:700; color:#1e3a5f; }
    .header h2 { font-size:16px; margin:0; color:#444; font-weight:500; }
    .filters { margin:10px 0 18px; padding:8px 12px; background:#f3f6fa; border-left:4px solid #2d5986; border-radius:4px; }
    table { width:100%; border-collapse: collapse; margin-top:10px; }
    th, td { border:1px solid #ccc; padding:8px 10px; }
    th { background:#2d5986; color:#fff; text-align:left; font-size:13px; }
    tr:nth-child(even) td { background:#f9f9f9; }
    .right { text-align:right; }
    .no-print-btn { background:#2d5986; color:#fff; border:none; border-radius:4px; padding:8px 14px; cursor:pointer; margin-bottom:12px; }
    .no-print-btn:hover { background:#244a70; }
    .footer { margin-top: 25px; text-align: right; font-size: 11px; color: #666; }
  </style>
</head>
<body onload="window.print()">

<button class="no-print no-print-btn" onclick="window.print()">Imprimir / Guardar como PDF</button>

<div class="header">
  <img src="{{ asset('assets/escudo_128x128.png') }}" alt="Escudo">
  <h1>División Bienestar Policial</h1>
  <h2>Estado de Entrevistas</h2>
</div>

<div class="filters">
  <strong>Filtros:</strong>
  Jerarquías: {{ $filtrosTxt['jerarquias'] ?? 'Todas' }} |
  Estados: {{ $filtrosTxt['estados'] ?? 'Todos' }} |
  Desde: {{ $filtrosTxt['desde'] ?? '—' }} |
  Hasta: {{ $filtrosTxt['hasta'] ?? '—' }}
</div>

@php
  $apto        = $totalesPorEstado[1] ?? 0;
  $no_apto     = $totalesPorEstado[2] ?? 0;
  $condicional = $totalesPorEstado[3] ?? 0;
@endphp

{{-- TABLA DETALLE --}}
<table>
  <thead>
    <tr>
      <th>Fecha</th>
      <th>Jerarquía</th>
      <th>Paciente</th>
      <th>Estado</th>
    </tr>
  </thead>
  <tbody>
    @forelse($rows as $r)
      @php
        $pacNom = $mapPacientes[$r->paciente_id] ?? '—';
        $jid    = $mapPacienteJerarId[$r->paciente_id] ?? null;
        $jerNom = $jid ? ($mapJerarquias[$jid] ?? 'Sin dato') : 'Sin dato';
        $estNom = $mapEstados[$r->estado_entrevista_id] ?? '—';
      @endphp
      <tr>
        <td>
          {{ !empty($r->fecha_ref)
              ? \Carbon\Carbon::parse($r->fecha_ref)->format('d-m-Y')
              : '—' }}
        </td>
        <td>{{ $jerNom }}</td>
        <td>{{ $pacNom }}</td>
        <td>{{ $estNom }}</td>
      </tr>
    @empty
      <tr><td colspan="4" class="right">Sin datos</td></tr>
    @endforelse
  </tbody>
</table>

{{-- RESUMEN GENERAL --}}
<table style="margin-top:12px">
  <thead>
    <tr>
      <th>APTO</th>
      <th>NO APTO</th>
      <th>CONDICIONAL</th>
      <th class="right">TOTAL</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>{{ $apto }}</td>
      <td>{{ $no_apto }}</td>
      <td>{{ $condicional }}</td>
      <td class="right">{{ $rows->count() }}</td>
    </tr>
  </tbody>
</table>

<div class="footer">
  Generado automáticamente — {{ now()->timezone('America/Argentina/Buenos_Aires')->format('d/m/Y H:i') }}
</div>

</body>
</html>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Sesiones Kinesiología</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 13px;
        }

        .titulo {
            text-align: center;
            font-size: 20px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 12px;
            vertical-align: top;
        }

        th {
            background: #eee;
        }

        /* Botón que solo aparece en navegador */
        @media print {
            .no-print {
                display: none !important;
            }
        }

        .btn {
            padding: 6px 12px;
            background: #444;
            color: white;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background: #333;
        }
    </style>
</head>

<body>

    {{-- BOTÓN SOLO EN NAVEGADOR --}}
    <div class="no-print" style="text-align:center; margin-bottom:15px;">
        <button onclick="window.print()" class="btn">Imprimir / Guardar PDF</button>
    </div>

    <h2 class="titulo">Sesiones de Kinesiología</h2>

    {{-- Datos del Paciente --}}
    @php
        $datosPaciente = collect([
            'Jerarquía' => $paciente?->jerarquias?->name ?? null,
            'Nombre' => $paciente->apellido_nombre ?? null,
            'Domicilio' => $paciente->domicilio ?? null,
            'Teléfono' => $paciente->TelefonoCelular ?? null,
            'DNI' => $paciente->dni ?? null,
            'Edad' => $paciente->edad ? $paciente->edad . ' años' : null,
        ]);
    @endphp

    @if ($datosPaciente->filter()->count())
        <div class="section">
            <h2>Datos del Paciente</h2>

            @foreach ($datosPaciente as $label => $value)
                @if ($value)
                    <p><strong>{{ $label }}:</strong> {{ $value }}</p>
                @endif
            @endforeach
        </div>
    @endif


    {{-- 🔥 FORMULARIO DE FILTROS (SOLO NAVEGADOR) --}}
    <form method="GET" class="no-print" style="margin-bottom: 15px;">

        <label><strong>Estado:</strong></label>
        <select name="estado" onchange="this.form.submit()">
            <option value="activas" {{ $estado == 'activas' ? 'selected' : '' }}>Activas</option>
            <option value="inactivas" {{ $estado == 'inactivas' ? 'selected' : '' }}>Inactivas</option>
            <option value="todas" {{ $estado == 'todas' ? 'selected' : '' }}>Todas</option>
        </select>
        @if ($estado === 'todas')
            &nbsp;&nbsp;&nbsp;

            <label><strong>Mostrar solo:</strong></label>
            <select name="subestado" onchange="this.form.submit()">
                <option value="activas" {{ request('subestado') == 'activas' ? 'selected' : '' }}>Activas</option>
                <option value="inactivas" {{ request('subestado') == 'inactivas' ? 'selected' : '' }}>Inactivas</option>
            </select>
        @endif


        &nbsp;&nbsp;&nbsp;

        <label><strong>Límite:</strong></label>
        <select name="limite" onchange="this.form.submit()">
            <option value="10" {{ $limite == 10 ? 'selected' : '' }}>10</option>
            <option value="20" {{ $limite == 20 ? 'selected' : '' }}>20</option>
            <option value="50" {{ $limite == 50 ? 'selected' : '' }}>50</option>
        </select>
    </form>

    <p>
        <strong>Mostrando:</strong> {{ ucfirst($estado) }}
        {{-- <strong>Límite:</strong> {{ $limite }} --}}
    </p>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Tratamiento</th>
                <th>Evolución</th>
                <th>Estado</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($sesiones as $s)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($s->fecha_sesion)->format('d/m/Y') }}</td>
                    <td>{{ $s->tratamiento_fisiokinetico }}</td>
                    <td>{{ $s->evolucion_sesion }}</td>
                    <td>{{ $s->firma_paciente_digital == 0 ? 'Activa' : 'Inactiva' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center;">No hay sesiones para mostrar</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Firmas --}}
    <div class="section"
        style="margin-top: 95px; display: flex; justify-content: space-between; align-items: flex-end; width: 100%;">

        {{-- Firma del Kinesiólogo --}}
        <div style="text-align: center; flex: 0 0 45%;">
            <p style="margin: 0 0 10px 0;">______________________________</p>
            <p style="margin: 0 0 5px 0;">Firma del Kinesiólogo</p>
            <strong>{{ auth()->user()->name }}</strong>
        </div>

        {{-- Firma del Paciente --}}
        <div style="text-align: center; flex: 0 0 45%;">
            <p style="margin: 0 0 10px 0;">______________________________</p>
            <p style="margin: 0 0 5px 0;">Firma del Paciente</p>
            <strong>
                {{ $paciente?->jerarquias?->name ?? 'Jerarquía' }}
                {{ $paciente->apellido_nombre ?? 'Sin Nombre' }}
            </strong>
        </div>

    </div>


</body>

</html>

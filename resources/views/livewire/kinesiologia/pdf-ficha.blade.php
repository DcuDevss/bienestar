<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ficha Kinesiológica</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }

        h1,
        h2 {
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        h2 {
            margin-top: 15px;
            margin-bottom: 5px;
            color: #333;
            border-bottom: 1px solid #ccc;
            padding-bottom: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table td {
            padding: 5px;
            vertical-align: top;
        }

        .section {
            margin-bottom: 20px;
        }

        .label {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <h1>Ficha Kinesiológica</h1>

    {{-- Datos del Paciente --}}
    @php
        $datosPaciente = collect([
            'Jerarquía' => $ficha->paciente?->jerarquias?->name ?? null,
            'Nombre' => $ficha->paciente->apellido_nombre ?? null,
            'Domicilio' => $ficha->paciente->domicilio ?? null,
            'Teléfono' => $ficha->paciente->TelefonoCelular ?? null,
            'DNI' => $ficha->paciente->dni ?? null,
            'Edad' => $ficha->paciente->edad ? $ficha->paciente->edad . ' años' : null,
        ]);
    @endphp
    @if ($datosPaciente->filter()->count())
        <div class="section">
            <h2>Datos del Paciente</h2>
            <table>
                @foreach ($datosPaciente as $label => $value)
                    @if ($value)
                        <tr>
                            <td class="label">{{ $label }}:</td>
                            <td>{{ $value }}</td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </div>
    @endif

    {{-- Derivación y Diagnóstico --}}
    @php
        $derivacion = collect([
            'Doctor' => $ficha->doctor->name ?? null,
            'Matrícula' => $ficha->doctor->matricula ?? null,
            'Especialidad' => $ficha->doctor->especialidad ?? null,
            'Obra Social' => $ficha->obraSocial->nombre ?? null,
            'Diagnóstico' => $ficha->diagnostico ?? null,
        ]);
    @endphp
    @if ($derivacion->filter()->count())
        <div class="section">
            <h2>Derivación y Diagnóstico</h2>
            <table>
                @foreach ($derivacion as $label => $value)
                    @if ($value)
                        <tr>
                            <td class="label">{{ $label }}:</td>
                            <td>{{ $value }}</td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </div>
    @endif

    {{-- Anamnesis --}}
    @php
        $anamnesis = collect([
            'Motivo de consulta' => $ficha->motivo_consulta ?? null,
            'Posturas dolorosas' => $ficha->posturas_dolorosas ?? null,
            'Actividad física' => isset($ficha->realiza_actividad_fisica)
                ? ($ficha->realiza_actividad_fisica
                    ? 'Sí'
                    : 'No')
                : null,
            'Tipo de actividad' => $ficha->tipo_actividad ?? null,
            'Antecedentes enfermedades' => $ficha->antecedentes_enfermedades ?? null,
            'Antecedentes familiares' => $ficha->antecedentes_familiares ?? null,
            'Cirugías' => $ficha->cirugias ?? null,
            'Traumatismos o accidentes' => $ficha->traumatismos_accidentes ?? null,
            'Tratamientos previos' => $ficha->tratamientos_previos ?? null,
            'Estado de salud general' => $ficha->estado_salud_general ?? null,
            'Alteración de peso' => isset($ficha->alteracion_peso) ? ($ficha->alteracion_peso ? 'Sí' : 'No') : null,
            'Medicación actual' => $ficha->medicacion_actual ?? null,
            'Observaciones' => $ficha->observaciones_generales_anamnesis ?? null,
        ]);
    @endphp
    @if ($anamnesis->filter()->count())
        <div class="section">
            <h2>Anamnesis</h2>
            <table>
                @foreach ($anamnesis as $label => $value)
                    @if ($value !== null && $value !== '')
                        <tr>
                            <td class="label">{{ $label }}:</td>
                            <td>{{ $value }}</td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </div>
    @endif

    {{-- Antecedentes Ginecológicos --}}
    @php
        $gineco = collect([
            'Menarca' => isset($ficha->menarca) ? ($ficha->menarca ? 'Sí' : 'No') : null,
            'Menopausia' => isset($ficha->menopausia) ? ($ficha->menopausia ? 'Sí' : 'No') : null,
            'Partos' => $ficha->partos !== null ? $ficha->partos : null,
        ]);
    @endphp
    @if ($gineco->filter()->count())
        <div class="section">
            <h2>Antecedentes Ginecológicos</h2>
            <table>
                @foreach ($gineco as $label => $value)
                    @if ($value !== null && $value !== '')
                        <tr>
                            <td class="label">{{ $label }}:</td>
                            <td>{{ $value }}</td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </div>
    @endif

    {{-- Examen EOM --}}
    @php
        $eom = collect([
            'Palpación visceral' => $ficha->visceral_palpacion ?? null,
            'Dermalgias' => $ficha->visceral_dermalgias ?? null,
            'Triggers' => $ficha->visceral_triggers ?? null,
            'Fijaciones' => $ficha->visceral_fijaciones ?? null,
            'Forma craneal' => $ficha->craneal_forma ?? null,
            'Triggers craneales' => $ficha->craneal_triggers ?? null,
            'Fijaciones craneales' => $ficha->craneal_fijaciones ?? null,
            'Músculos craneales' => $ficha->craneal_musculos ?? null,
            'Tensión arterial' => $ficha->tension_arterial ?? null,
            'Pulsos' => $ficha->pulsos ?? null,
            'Auscultación' => $ficha->auscultacion ?? null,
            'ECG' => $ficha->ecg ?? null,
            'Ecodoppler' => $ficha->ecodoppler ?? null,
        ]);
    @endphp
    @if ($eom->filter()->count())
        <div class="section">
            <h2>Examen EOM</h2>
            <table>
                @foreach ($eom as $label => $value)
                    @if ($value !== null && $value !== '')
                        <tr>
                            <td class="label">{{ $label }}:</td>
                            <td>{{ $value }}</td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </div>
    @endif
    <p>
    <p>


    <div class="section" style="margin-top: 60px; display: flex; justify-content: space-between; width: 100%;">
        {{-- Firma del Kinesiólogo --}}
        @if ($ficha->user)
            <div style="text-align: center; flex: 0 0 40%;"> <!-- ocupa 40% del ancho -->
                <p style="margin-bottom: 10px;">______________________________</p>
                <p style="margin-bottom: 5px;">Firma del Kinesiólogo</p>
                <strong>{{ auth()->user()->name }}</strong>

            </div>
        @endif
        <!-- ↓ más espacio arriba -->

        {{-- Firma del Paciente --}}
        <div style="text-align: center; flex: 1;">
            <p style="margin-bottom: 15px; margin-top: 40px;">______________________________</p>

            <p style="margin-bottom: 5px;">Firma del Paciente</p>
            <strong>
                {{ $ficha->paciente?->jerarquias?->name ?? 'Jerarquía' }}
                {{ $ficha->paciente->apellido_nombre ?? 'Sin Nombre' }}
            </strong>
        </div>

    </div>


    </div>





</body>

</html>

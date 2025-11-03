<div class="max-w-7xl mx-auto mt-10 space-y-8">
  <h1 class="text-2xl md:text-3xl font-bold text-center text-[#2d5986]">
    Estadísticas Estado Personal Policial
  </h1>

    {{-- FILTROS --}}
    <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200">
    <h2 class="text-lg font-semibold text-gray-700 mb-5">Filtros</h2>

    {{-- Primera fila: Jerarquías y Estados --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
        <div>
        <label class="block text-sm font-medium  mb-1">Jerarquías</label>
        <select multiple wire:model.live="jerarquia_ids"
                size="{{ count($jerarquias) }}"
                class="w-full appearance-none bg-white border rounded-md px-3 py-2 focus:ring-2 focus:ring-[#2d5986]/50 focus:border-[#2d5986]">
            @foreach($jerarquias as $j)
            <option value="{{ $j->id }}">{{ $j->name }}</option>
            @endforeach
        </select>
        <p class="text-xs text-gray-500 mt-1">Podés seleccionar varias con Ctrl + click</p>
        </div>

        <div>
        <label class="block text-sm font-medium  mb-1">Estados</label>
        <select multiple wire:model.live="estado_ids"
                size="{{ count($estados) }}"
                class="w-full border bg-white rounded-md px-3 py-2 focus:ring-2 focus:ring-[#2d5986]/50 focus:border-[#2d5986]">
            @foreach($estados as $e)
            <option value="{{ $e->id }}">{{ $e->name }}</option>
            @endforeach
        </select>
        <p class="text-xs text-gray-500 mt-1">Podés seleccionar varias con Ctrl + click</p>
        </div>
    </div>

    {{-- Segunda fila: Desde y Hasta --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">Desde</label>
        <input type="date" wire:model.live="desde"
                class="w-full h-9 border rounded-md px-3 focus:ring-2 focus:ring-[#2d5986]/50 focus:border-[#2d5986]">
        @if($desde)
            <p class="text-xs text-gray-500 mt-1">
            {{ \Carbon\Carbon::parse($desde)->format('d-m-Y') }}
            </p>
        @endif
        </div>

        <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">Hasta</label>
        <input type="date" wire:model.live="hasta"
                class="w-full h-9 border rounded-md px-3 focus:ring-2 focus:ring-[#2d5986]/50 focus:border-[#2d5986]">
        @if($hasta)
            <p class="text-xs text-gray-500 mt-1">
            {{ \Carbon\Carbon::parse($hasta)->format('d-m-Y') }}
            </p>
        @endif
        </div>
    </div>
    </div>


  {{-- Totales por estado --}}
  @php
    $apto        = $totalesPorEstado[1] ?? 0;  // ajusta si tus IDs difieren
    $no_apto     = $totalesPorEstado[2] ?? 0;
    $condicional = $totalesPorEstado[3] ?? 0;
  @endphp
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
      <div class="text-sm text-green-700 font-medium">APTOS</div>
      <div class="text-2xl font-bold text-green-800">{{ $apto }}</div>
    </div>
    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
      <div class="text-sm text-red-700 font-medium">NO APTOS</div>
      <div class="text-2xl font-bold text-red-800">{{ $no_apto }}</div>
    </div>
    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
      <div class="text-sm text-amber-700 font-medium">CONDICIONALES</div>
      <div class="text-2xl font-bold text-amber-800">{{ $condicional }}</div>
    </div>
  </div>

  {{-- Tabla --}}
  <div class="bg-slate-50 border border-gray-200 rounded-lg shadow overflow-x-auto">
    <table class="w-full text-sm border-collapse">
      <thead class="bg-[#2d5986] text-white">
        <tr>
          <th class="p-3 text-left font-semibold">Fecha</th>
          <th class="p-3 text-left font-semibold">Jerarquía</th>
          <th class="p-3 text-left font-semibold">Paciente</th>
          <th class="p-3 text-left font-semibold">Estado</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-100">
        @forelse($rows as $r)
          <tr class="hover:bg-slate-100">
            <td class="p-3">{{ \Carbon\Carbon::parse($r->fecha_ref)->format('d-m-Y') }}</td>
            <td class="p-3">
                @php $jid = $mapPacienteJerarId[$r->paciente_id] ?? null; @endphp
                {{ $jid ? ($mapJerarquias[$jid] ?? ('#'.$jid)) : 'Sin dato' }}
            </td>
            <td class="p-3">
              {{ $mapPacientes[$r->paciente_id] ?? ('ID '.$r->paciente_id) }}
            </td>
            <td class="p-3">{{ $mapEstados[$r->estado_entrevista_id] ?? ('#'.$r->estado_entrevista_id) }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="p-4 text-center text-gray-500">Sin resultados</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div>
    {{ $rows->links() }}
  </div>
  {{-- BOTÓN IMPRIMIBLE --}}
<div class="flex justify-end">
    <a href="{{ route('prints.postulantes', [
        'desde'          => $desde,
        'hasta'          => $hasta,
        'jerarquia_ids'  => $jerarquia_ids,
        'estado_ids'     => $estado_ids,
    ]) }}"
    target="_blank"
    class="inline-flex items-center gap-2 rounded-md bg-[#2d5986] px-6 py-2.5 mb-4 font-medium text-white shadow hover:bg-[#244a70] transition">
        Imprimir / PDF
    </a>
</div>




</div>

<div class="max-w-7xl mx-auto mt-10 space-y-10">

  {{-- TÍTULO --}}
  <h1 class="text-3xl md:text-4xl font-extrabold text-center text-[#2d5986] tracking-wide">
    Estadísticas de Licencias
  </h1>

  {{-- FILTROS --}}
  <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200">
    <h2 class="text-lg font-semibold text-gray-700 mb-5">Filtros</h2>

    {{-- FILA 1: Tipo de licencia + Ciudades --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">

        {{-- Tipos de licencia --}}
        <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">Tipos de Licencia</label>
        <select multiple
                size="{{ max($tipos->count(), 1) }}"
                wire:model.live="tipolicencia_ids"
                class="w-full border rounded-md px-3 py-2 focus:ring-2 focus:ring-[#2d5986]/50 focus:border-[#2d5986]">
            @foreach($tipos as $t)
            <option value="{{ $t->id }}">{{ $t->name }}</option>
            @endforeach
        </select>
        <p class="text-xs text-gray-500 mt-1">
            @if(!empty($tipolicencia_ids))
            {{ count($tipolicencia_ids) }} seleccionadas
            @else
            Sin seleccionar, toma todas las licencias...
            @endif
        </p>
        </div>

      {{-- Ciudades --}}
      <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">Ciudades</label>
        <div class="max-h-48 overflow-y-auto border rounded-md">
          <select multiple wire:model.live="ciudad_ids"
                  class="w-full min-h-32 border-none rounded-md px-3 py-2 focus:ring-2 focus:ring-[#2d5986]/50 focus:border-[#2d5986]">
            @foreach($ciuds as $c)
              <option value="{{ $c->id }}">{{ $c->nombre ?? $c->name }}</option>
            @endforeach
          </select>
        </div>
        <p class="text-xs text-gray-500 mt-1">
          @if(!empty($ciudad_ids))
            {{ count($ciudad_ids) }} seleccionadas
          @else
            Sin seleccionar, toma todas las Ciudades...
          @endif
        </p>
      </div>
    </div>

    {{-- FILA 2: Fechas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
      {{-- Desde --}}
      <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">Desde</label>
        <input type="date" wire:model.live="desde"
               class="w-full h-9 border rounded-md px-3 focus:ring-2 focus:ring-[#2d5986]/50 focus:border-[#2d5986]">
        @if($desde)
          <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($desde)->format('d-m-Y') }}</p>
        @endif
      </div>

      {{-- Hasta --}}
      <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">Hasta</label>
        <input type="date" wire:model.live="hasta"
               class="w-full h-9 border rounded-md px-3 focus:ring-2 focus:ring-[#2d5986]/50 focus:border-[#2d5986]">
        @if($hasta)
          <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($hasta)->format('d-m-Y') }}</p>
        @endif
      </div>
    </div>
  </div>

  {{-- TABLA PRINCIPAL --}}
  <div class="bg-slate-50 border border-gray-300 rounded-xl shadow overflow-x-auto">
    <table class="w-full text-sm border-collapse">
      <thead class="bg-[#2d5986] text-white">
        <tr>
          <th class="p-3 text-left font-semibold text-base uppercase tracking-wide">Tipo Licencia</th>
          <th class="p-3 text-left font-semibold text-base uppercase tracking-wide">Ciudad</th>
          <th class="p-3 text-right font-semibold text-base uppercase tracking-wide">Total</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @forelse($rows as $r)
          <tr class="hover:bg-slate-100 transition">
            <td class="p-3">{{ $r->tipolicencia }}</td>
            <td class="p-3">{{ $r->ciudad }}</td>
            <td class="p-3 text-right font-semibold">{{ $r->total }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="3" class="p-4 text-center text-gray-500">Sin resultados</td>
          </tr>
        @endforelse
      </tbody>
      <tfoot class="bg-slate-100">
        <tr>
          <td colspan="2" class="p-3 text-right font-semibold text-gray-700">TOTAL</td>
          <td class="p-3 text-right font-bold text-[#2d5986]">{{ $total }}</td>
        </tr>
      </tfoot>
    </table>
  </div>

  {{-- PAGINACIÓN --}}
<div class="mt-4">
  {{ $rows->links() }}
</div>

  {{-- BOTÓN IMPRIMIBLE --}}
  @php
    $query = http_build_query([
      'desde'             => $desde,
      'hasta'             => $hasta,
      'tipolicencia_ids'  => (array)$tipolicencia_ids,
      'ciudad_ids'        => (array)$ciudad_ids,
    ]);
  @endphp

  <div class="flex justify-end">
    <a href="{{ route('prints.licencias') . '?' . $query }}"
       target="_blank"
       class="inline-flex items-center gap-2 rounded-md bg-[#2d5986] px-6 py-2.5 mb-4 font-medium text-white shadow hover:bg-[#244a70] transition">
      Imprimir / PDF
    </a>
  </div>

</div>

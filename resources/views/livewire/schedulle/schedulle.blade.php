<div class="w-full rounded-lg bg-white shadow-lg p-8 border">
    <small>
        <h1 class="border rounded font-bold text-center py-2 uppercase text-gray-700 mb-2">{{ __('Cronograma de atencion') }}</h1>
        <div>
            <input class="rounded w-full border shadow-sm" type="date" />
            @foreach ($workdays as $w)
                <div class="mt-6">
                    <div class="border py-3">
                        <h1 class="text-center font-bold text-gray-700">{{ DIA[$w->day] }}</h1>
                        <div class="flex justify-around items-center">
                            <p>
                                {{ $w->HourMs }} <br> {{ $w->HourMe }}
                            </p>
                            <p>
                                {{ $w->HourAs }} <br> {{ $w->HourAe }}
                            </p>
                            <p>
                                {{ $w->HourEs }} <br> {{ $w->HourEe }}
                            </p>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    </small>
</div>

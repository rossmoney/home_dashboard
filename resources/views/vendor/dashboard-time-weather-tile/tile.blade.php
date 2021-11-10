<x-dashboard-tile :position="$position">
    <div
        class="grid grid-cols-2 gap-2 justify-items-center h-full text-center"
        style="grid-template-rows: auto 1fr auto;"
        x-data="clock()"
        x-init="tick"
    >
        <h1 class="self-center font-medium text-dimmed text-5xl mb-0 uppercase tracking-wide tabular-nums" x-text="date"></h1>

        <div class="self-center font-bold text-5xl tracking-wide leading-none text-right" x-text="time"></div>

        <div wire:poll.600s class="col-span-2 uppercase">
            <div class="flex w-full justify-center space-x-4 items-center mt-12">
                <span class="text-3xl"> {{ $outsideTemperature }}°{{ $unit == 'metric' ? 'C': 'F'}}  <span class="text-3xl uppercase text-dimmed">out</span></span>
                <span class="text-4xl">{{ $emoji }}</span>
                @isset($insideTemperature)
                    <span> {{ $insideTemperature }}°{{ $unit == 'metric' ? 'C': 'F'}}  <span class="text-3xl uppercase text-dimmed">in</span></span>
                @endisset
            </div>
            <div class="text-4xl">{{ $city }}, {{ $countryCode }}</div>
        </div>

    </div>

    <script>
        function clock() {
            return {
                dateTime: new Date(),

                tick() {
                    setInterval(() => {
                        this.dateTime = new Date();
                    }, 1000);
                },

                get date() {
                    const day = this.dateTime
                        .toLocaleDateString('{{ app()->getLocale() }}', { weekday: 'long' })
                        .substr(0, 3);

                    const date = [
                        this.dateTime.getDate(),
                        this.dateTime.getMonth() + 1,
                    ].map(this.padNumber).join('/');

                    return `${day} ${date}`;
                },

                get time() {
                    return [
                        this.dateTime.getHours(),
                        this.dateTime.getMinutes(),
                    ].map(this.padNumber).join(':');
                },

                padNumber(number) {
                    return String(number).padStart(2, '0');
                }
            }
        }
    </script>

</x-dashboard-tile>

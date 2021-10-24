<x-dashboard-tile :position="$position" refresh-interval="{{ $refreshInterval }}">
    @if(!empty($title))
        <h6 class="mb-2 font-bold">{{ $title }}</h6>
    @endif

    @if(!empty($exchange) && !empty($currencyPair))
    <div style="height: 380px; overflow: hidden;" id="cryptowatch-container-{{ $configuration }}"></div>

    <script type="text/javascript">
    var chart = new cryptowatch.Embed('{{ $exchange }}', '{{ $currencyPair }}', {
        timePeriod: '{{ $timePeriod ?? '1d' }}',
        //width: 650,
        height: 500,
        presetColorScheme: 'delek'
    });
    chart.mount('#cryptowatch-container-{{ $configuration }}');
    </script>
    @endif

</x-dashboard-tile>

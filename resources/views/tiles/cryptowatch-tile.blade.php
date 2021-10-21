<x-dashboard-tile :position="$position" refresh-interval="{{ $refreshInterval }}">
    @if(!empty($title))
        <h1 class="mb-2 font-bold">{{ $title }}</h1>
    @endif

    @if(!empty($exchange) && !empty($currencyPair))
    <div id="cryptowatch-container-{{ $configuration }}"></div>

    <script type="text/javascript" src="https://static.cryptowat.ch/assets/scripts/embed.bundle.js"></script>

    <script type="text/javascript">
    var chart = new cryptowatch.Embed('{{ $exchange }}', '{{ $currencyPair }}', {
        timePeriod: '{{ $timePeriod ?? '1d' }}',
        //width: 650,
        height: 380,
        presetColorScheme: 'delek'
    });
    chart.mount('#cryptowatch-container-{{ $configuration }}');
    </script>
    @endif

</x-dashboard-tile>

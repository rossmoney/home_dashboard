<x-dashboard-tile :position="$position" refresh-interval="{{ $refreshInterval }}">
    @if(!empty($title))
        <h6 class="mb-2 font-bold">{{ $title }}</h6>
    @endif

    @if(!empty($trains))
    <table class="table table-sm table-striped table-dark border-2">
        <thead>
          <tr>
            <th scope="col">Time</th>
            <th scope="col">Platform</th>
            <th scope="col">Status</th>
            <th scope="col">Operator</th>
            <th scope="col">Started / Ends</th>
          </tr>
        </thead>
        <tbody>
          @foreach($trains as $train)
          <tr class="{{ $train['tooLateToLeave'] ? 'red-bg' : '' }}">
            <th scope="row">{{ $train['time'] }}</th>
            <td>{{ $train['platform'] }}</td>
            <td>
                {{ $train['delayed'] ? 'Delayed Till ' : '' }}{{ $train['status'] }}
                {!! $train['delayed'] ? '<br><span>'. $train['delayReason'] . '</span>' : '' !!}
            </td>
            <td>{{ $train['operator'] }}</td>
            <td>{{ ($train['origin'][0]['crs'] ?? '') . ((' / ' . ($train['destination'][0]['crs'] ?? '') != ' / ') ? ' / ' . ($train['destination'][0]['crs'] ?? '') : '') }}</td>
          </tr>
          @endforeach
        </tbody>
    </table>
    @else 
    <p>No departures available at this time.</p>
    @endif
</x-dashboard-tile>
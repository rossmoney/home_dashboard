<x-dashboard-tile :position="$position" refresh-interval="{{ $refreshInterval }}">
    @if(!empty($title))
        <h6 class="mb-2 font-bold text-2xl">{!! $title !!}</h6>
    @endif

    @if(!empty($trains))
    <table class="table table-sm table-striped table-dark border-2 text-xl">
        <thead>
          <tr>
            <th scope="col">Time</th>
            <th scope="col">Plt.</th>
            <th scope="col">Status</th>
            <th scope="col">Op.</th>
            <th scope="col">Start / End</th>
          </tr>
        </thead>
        <tbody>
          @foreach($trains as $train)
          <tr class="{{ $train['tooLateToLeave'] ? 'red-bg' : '' }}">
            <th scope="row"><span class="text-4xl">{{ $train['time'] }}</span></th>
            <td><span class="text-4xl">{{ $train['platform'] }}</span></td>
            <td><span class="text-3xl">
                {{ $train['delayed'] ? 'Dl: ' : '' }}{{ $train['status'] }}</span>
            </td>
            <td><span class="text-2xl">{{ $train['operator'] }}</span></td>
            <td><span class="text-2xl">
              {{ ($train['origin'][0]['crs'] ?? '') . ((' / ' . ($train['destination'][0]['crs'] ?? '') != ' / ') ? ' / ' . ($train['destination'][0]['crs'] ?? '') : '') }}
              </span>
            </td>
          </tr>
          @endforeach
        </tbody>
    </table>
    @else 
    <p>No departures available at this time.</p>
    @endif
</x-dashboard-tile>
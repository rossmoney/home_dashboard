<x-dashboard-tile :position="$position" refresh-interval="{{ $refreshInterval }}">
    @if(!empty($title))
        <h6 class="mb-2 font-bold">{{ $title }}</h6>
    @endif

    @if(!empty($categorySpending))
      @include('spending.dashTable')
    @endif
</x-dashboard-tile>
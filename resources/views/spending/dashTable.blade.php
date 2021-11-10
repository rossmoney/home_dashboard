{{--@php
$spendingChunks = $spending->chunk($spending->count() / 2);
@endphp

<div class="grid grid-cols-2">
    @include('spending.table', ['spending' => $spendingChunks[0], 'dash' => true])
    @include('spending.table', ['spending' => $spendingChunks[1], 'dash' => true])
</div>--}}

<table class="table table-sm table-striped table-dark border-2">
    <thead>
      <tr>
        <th scope="col">Category</th>
        <th scope="col">Jack</th>
        <th scope="col">Ross</th>
        <th scope="col">Total</th>
      </tr>
    </thead>
    <tbody>
    @foreach($categorySpending as $category => $breakdown)
      <tr class="{{ $breakdown['Recurrent'] ? 'blue-text' : '' }}">
        <th scope="row">{{ $category }}</th>
        <td>&pound;{{ $breakdown['Jack'] }}</td>
        <td>&pound;{{ $breakdown['Ross'] }}</td>
        <td><span class="{{ $breakdown['Total'] < 0 ? 'red-text' : '' }}">{{ $breakdown['Total'] < 0 ? '-' : '' }}&pound;{{ abs($breakdown['Total']) }}</span></td>
      </tr>
    @endforeach
      <tr>
          <td colspan="4"></td>
      </tr>
      <tr>
        <th scope="row text-4xl">Totals: </th>
        <td><span class="text-3xl font-bold">&pound;{{ $totals['jack'] }}</span></td>
        <td><span class="text-3xl font-bold">&pound;{{ $totals['ross'] }}</span></td>
        <td><span class="text-3xl font-bold">&pound;{{ $totals['totalToRoss'] }}</span></td>
      </tr>
    </tbody>
</table>
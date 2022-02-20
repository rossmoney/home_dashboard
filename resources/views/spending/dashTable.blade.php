<table class="table table-sm table-striped table-dark border-2 text-center">
   <tr>
        <td class="blue-text" width="50%">Blue = Monthly Recurring</td>
        <td class="orange-text">Orange = Jack</td>
   </tr>
</table>

<table class="table table-sm table-striped table-dark border-2 text-center">
    <thead>
      <tr>
        <th scope="col">Category</th>
        <th scope="col">Desc. / Date</th>
        <th scope="col">Amount</th>
        <th scope="col">Total</th>
      </tr>
    </thead>
    <tbody>
    @foreach($categorySpending as $category => $breakdown)
      <tr class="{{ $breakdown['Recurrent'] ? 'blue-text' : '' }}">
        <td>{{ $category }}</th>
        <td style="min-width: 125px;">{!! $breakdown['Description'] !!}</td>
        <td>{!! $breakdown['Amount'] !!}</td>
        <td><span class="text-3xl">{!! $breakdown['Total'] !!}</span></td>
      </tr>
    @endforeach
    </tbody>
</table>

<h6 class="mb-2 font-bold">Totals</h6>
<table class="table table-sm table-striped table-dark border-2 text-center">
    <thead>
      <tr>
        <th scope="col">Jack</th>
        <th scope="col">Ross</th>
    	<th scope="col">Jack 💰 to Ross</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><span class="text-3xl font-bold">{!! $totals['jack'] !!}</span></td>
        <td><span class="text-3xl font-bold">{!! $totals['ross'] !!}</span></td>
        <td><span class="text-3xl font-bold">{!! $totals['totalToRoss'] !!}</span></td>
      </tr>
    </tbody>
</table>
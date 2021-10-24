<table class="table table-sm table-striped {{ !empty($dash) ? 'table-dark border-2' : '' }}">
    <thead>
      <tr>
        <th scope="col">Cost.</th>
        <th scope="col">Desc.</th>
        <th scope="col">Category</th>
        <th scope="col">Who?</th>
        <th scope="col">When?</th>
      </tr>
    </thead>
    <tbody>
    @foreach($spending as $line)
      <tr>
        <th scope="row"><span class="{{ $line->cost < 0 ? 'red-text' : '' }}">{{ $line->cost < 0 ? '-' : '' }}&pound;{{ abs($line->cost) }}</span></th>
        <td>{{ $line->desc }}</td>
        <td>{{ $line->category }}</td>
        <td>{{ $line->user }}</td>
        <td>{{ date("d/m", strtotime($line->date)) }}</td>
      </tr>
    @endforeach
    </tbody>
</table>
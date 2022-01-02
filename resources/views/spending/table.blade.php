<table class="table table-sm table-striped {{ !empty($dash) ? 'table-dark border-2' : '' }}">
    <thead>
      <tr>
        <th scope="col">Cost.</th>
        <th scope="col">Desc.</th>
        <th scope="col">Category</th>
        <th scope="col">Who?</th>
        <th scope="col">When?</th>
        <th scope="col">Recurring?</th>
        <th scope="col">Installment Ends</th>
        <th scope="col" width="30"></th>
      </tr>
    </thead>
    <tbody>
    @foreach($spending as $line)
      <tr class="{{ $line->installment ? 'darkblue-text' :'' }}">
        <th scope="row"><span class="{{ $line->cost < 0 ? 'red-text' : '' }}">{{ $line->cost < 0 ? '-' : '' }}&pound;{{ abs($line->cost) }}</span></th>
        <td>{{ $line->desc }}</td>
        <td>{{ $line->category }}</td>
        <td>{{ $line->user }}</td>
        <td>{{ $line->when }}</td>
        <td>{{ $line->installment ? '✓' : '✗' }}</td>
        <td>{{ !empty($line->end_date) ? date('d/m/Y', strtotime($line->end_date)) : '' }}</td>
        <td>
            <form method="post" action="{{ url('spending/' . $line->id) }}">
                @csrf
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-sm btn-danger">x</button>
            </form>
        </td>
      </tr>
    @endforeach
    </tbody>
</table>
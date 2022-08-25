@extends('layouts.dashboard')

@section('content')
    @if(!empty($categorySpending))
        @include('spending.totals')
    @endif

    <div class="d-flex justify-content-center">
        <a href="/spending" class="btn btn-primary">
            Log In Here
        </a>
    </div>
@endsection
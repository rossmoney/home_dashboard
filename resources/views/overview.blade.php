@extends('layouts.dashboard')

@section('content')
    @if(!empty($title))
        <h6 class="mb-2 font-bold">{{ $title }}</h6>
    @endif

    @if(!empty($categorySpending))
        @include('spending.dashTable')
    @endif
@endsection
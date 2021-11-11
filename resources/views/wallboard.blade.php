{{--@extends('layouts.dashboard')

@section('content')
<div class="sliderAx h-auto">
    @for($i = 1; $i <= $dashboards; $i++)
    <div id="slider-{{ $i }}" class="slider mx-auto">
        <section class="h_iframe">
            <iframe src="{{ url($i) }}" frameborder="0" allowfullscreen></iframe>
        </section>
    </div>
    @endfor
</div>
@endsection--}}

@include('dashboards.1')
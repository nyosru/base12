@extends('billiard::app.app')


@section('content')

    <h2>@yield('content-head')</h2>
    @include('billiard::pages.'.$page)

    {{-- @include('billiard::infoblock.pluses') --}}

    {{-- page {{ $page }} --}}
    {{--
    <div id="contact" class="contact-us section">
        @include('kadastr::block-contact')
    </div>
    --}}


@endsection

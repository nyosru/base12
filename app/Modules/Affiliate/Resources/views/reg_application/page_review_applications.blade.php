@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Applications</h1>
        <hr/>
        @include('affiliate::reg_application._list')
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">
            Get Paid<br/>
            Helping Business Owners<br/>
            Protect Their Brands
        </h1>

        <p class="text-center">
            Become a Trademark Factory<sup>®</sup> affiliate
        </p>

        @include('affiliate::reg_application._form')
    </div>
@endsection

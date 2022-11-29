@extends('tmfentry.index')

@section('tmfentry-content')
    @include('tmfentry.search.content')
@endsection

@section('tmfentry-content-jscss')
    @include('tmfentry.search.css')
    @include('tmfentry.search.js')
@endsection
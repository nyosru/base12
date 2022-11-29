@extends('layouts.app')

@section('title')
    {{$title}}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{$title}}
                        @if($user_superadmin)
                        <button class="btn btn-sm btn-success float-right" id="add-new-category-btn">
                            <i class="fas fa-plus"></i> NEW CATEGORY
                        </button>
                        @endif
                    </div>
                    <div class="card-body">
                        @if($user_superadmin==false && $homepage_categories->count()==0)
                            <div class="jumbotron">
                                <h1 class="display-4">Hello, {{Illuminate\Support\Facades\Auth::user()->FirstName}}!</h1>
                                <p class="lead">Sorry you do not have admin privileges to edit any public categories.</p>
                                <hr class="my-4">
                                <p>You may create your user categories and add your personal links using the TMF Portal page.</p>
                                <a class="btn btn-primary btn-lg" href="#" role="button">Go to TMF Portal page</a>
                            </div>
                        @else
                            <div id="result-table-block" style="width: 99%;margin: auto">
                                <div class="accordion" id="root-block">
                                    @foreach($homepage_categories as $hp_category)
                                        @include('homepagemaintainer.root-block')
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @if($user_superadmin)
        @include('homepagemaintainer.add-edit-category-modal')
    @endif
    @include('homepagemaintainer.add-edit-category-item-modal')
    <div style="position: fixed; top: 15px; right: 15px;z-index:-1000;">
        <div class="toast sys-message" role="alert" aria-live="polite" aria-atomic="true" data-delay="3000" data-animation="true" style="width: 350px;">
            <div class="toast-header">
                <img src="/img/magentatmf.png" style="width: 16px;height: 16px;" class="rounded mr-2">
                <strong class="mr-auto">System Message</strong>
                <small class="text-muted">just now</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                Saved
            </div>
        </div>
    </div>
@endsection

@section('external-jscss')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-migrate-3.0.0.min.js" type="text/javascript"></script>
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js" type="text/javascript"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">

    @include('fc-maintainer.css')

    @include('homepagemaintainer.js')
    @if($user_superadmin)
        @include('homepagemaintainer.js-superadmin')
    @endif

@endsection
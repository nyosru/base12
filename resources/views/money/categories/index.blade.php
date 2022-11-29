@extends('layouts.app')

@section('title')
    Money | Categories
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Money | Categories
                    </div>
                    <div class="card-body">
                        <div id="result-table" style="text-align: center">
                            <div style="display: inline-block;text-align: left">
                                <div id="jstree"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
@endsection

@section('external-jscss')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js" type="text/javascript"></script>
    <link href="{{ asset('jstree/dist/themes/default/style.min.css') }}" rel="stylesheet"/>
    <style>
        .jstree-default a {
            white-space:normal !important; height: auto;
        }
        .jstree-anchor {
            height: auto !important;
        }
        .jstree-default li > ins {
            vertical-align:top;
        }
        .jstree-leaf {
            height: auto;
        }
        .jstree-leaf a{
            height: auto !important;
        }
    </style>
    <script src="{{ asset('jstree/dist/jstree.min.js') }}" type="text/javascript"></script>

    @include('money.categories.js')
@endsection
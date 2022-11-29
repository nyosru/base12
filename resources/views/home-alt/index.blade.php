@extends('layouts.app')

@section('content')
<div class="ml-5 mr-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach($sections_data as $section_id=>$el)
                        @if(!($loop->index%2))
                            @if($loop->index)
                                </div>
                            @endif
                            <div class="row mb-5">
                        @endif
                            <div class="col-6 " style="max-height: 500px;overflow-y: auto">
                                <div class="d-flex p-2 bd-highlight shadow">
                                    {{$el['name']}}
                                </div>
                                @foreach($el['data'] as $item)
                                    <div class="d-flex pl-4 pt-1 pb-1 bd-item-highlight"><a href="{{$item->url}}" style="line-height: 1.2" target="_blank">{{$item->name}}</a></div>
                                @endforeach
                            </div>
                    @endforeach
                       </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('external-jscss')
    <style>
        .bd-highlight {
            background-color: rgba(86,61,124,.15);
            border: 1px solid rgba(86,61,124,.15);
        }

        .bd-item-highlight {
            background-color: white;
            border: 1px solid rgba(86,61,124,.15);
        }
    </style>
@endsection

@section('title')
    DASHBOARD
@endsection
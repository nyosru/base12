@extends('layouts.app')

@section('title')
    Trends
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Trends
                        <a href="/ops-snapshot" class="float-right mr-3">Snapshot</a>
                        <a href="/ops-period" class="float-right mr-3">Period Page</a>
                    </div>

                    <div class="card-body">
                        <div class="mb-3 text-center">
                            <label class="mr-3"><input type="checkbox" class="country-chbx" value="Canada" checked/> Canada</label>
                            <label class="mr-3"><input type="checkbox" class="country-chbx" value="United States" checked/> United States</label>
                            <label class="mr-3"><input type="checkbox" class="country-chbx" value="Others" checked/> Other</label>
                        </div>
                        <div class="mb-3 text-center">
                            <span class="mr-2">
                                <span class="mr-3">Last:</span>
                                <span id="days">
                                    <a href="#" class="last-el mr-1" data-value="3">3</a>
                                    <a href="#" class="last-el mr-1" data-value="4">4</a>
                                    <span class="mr-1 font-weight-bold selected-day">6</span>
                                    <a href="#" class="last-el mr-1" data-value="10">10</a>
                                    <a href="#" class="last-el mr-1" data-value="12">12</a>
                                </span>
                            </span>
                            <span id="periods">
                                <a href="#" class="last-period mr-1" data-value="Weeks">Weeks</a>
                                <span class="mr-1 font-weight-bold selected-period">Months</span>
                                <a href="#" class="last-period mr-1" data-value="Quarters">Quarters</a>
                                {{--<a href="#" class="last-period mr-1" data-value="Years">Years</a>--}}
                            </span>
                        </div>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @foreach($ops_snapshot_title_group_objs as $ops_snapshot_title_group_obj)
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{($loop->index==0?'active':'')}}" id="tc{{$ops_snapshot_title_group_obj->id}}-tab" data-toggle="tab" href="#tc{{$ops_snapshot_title_group_obj->id}}" role="tab"
                                       aria-controls="tc{{$ops_snapshot_title_group_obj->id}}" aria-selected="{{($loop->index==0?'true':'false')}}">{{$ops_snapshot_title_group_obj->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            @foreach($ops_snapshot_title_group_objs as $ops_snapshot_title_group_obj)
                                <div class="tab-pane {{($loop->index==0?'active':'fade')}}" id="tc{{$ops_snapshot_title_group_obj->id}}" role="tabpanel" aria-labelledby="tc{{$ops_snapshot_title_group_obj->id}}-tab">
                                    <div class="row p-3">
                                        <div class="col-12">
                                            @foreach($tchart->getDatasets() as $dataset_el)
                                                @if(\App\OpsSnapshotTitle::find(array_values($dataset_el)[0]['trends_chart_id'])->ops_snapshot_title_group_id==$ops_snapshot_title_group_obj->id)
                                                    <div id="tc{{$loop->index}}-content">
                                                        <canvas id="tc{{$loop->index}}-canvas"></canvas>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js" type="text/javascript"></script>
    <script src="https://trademarkfactory.com/js/Chart.js"></script>
    {{--<script src="https://www.chartjs.org/samples/latest/utils.js"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
    <link rel="stylesheet" type="text/css" href="/datatables/datatables.min.css"/>
    <script type="text/javascript" src="/datatables/datatables.min.js"></script>
    @include('ops-trends.css')
    @include('ops-trends.js')
@endsection

@section('modals')
    @include('ops-trends.details-modal')
    <div style="position: fixed; top: 15px; right: 15px;">

        <!-- Then put toasts within -->
        <div class="toast" role="alert" aria-live="polite" aria-atomic="true" data-delay="1500" data-animation="true" style="width: 350px;">
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
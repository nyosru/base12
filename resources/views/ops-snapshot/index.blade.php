@extends('layouts.app')

@section('title')
    Snapshot
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Snapshot
                        <a href="/ops-period" class="float-right mr-3">Period Page</a>
                        <a href="/ops-trends" class="float-right mr-3">Trends Page</a>
                    </div>

                    <div class="card-body">
                        <div class="text-center">
                            <label class="mr-3"><input type="checkbox" class="country-chbx" value="[9]" checked/> Canada</label>
                            <label class="mr-3"><input type="checkbox" class="country-chbx" value="[8]" checked/> United States</label>
                            <label class="mr-3"><input type="checkbox" class="country-chbx" value="{{json_encode($other_countries)}}" checked/> Other</label>
                        </div>
                        <div id="result-table">{!! $result_table !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('external-jscss')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="/datatables/datatables.min.css"/>
    <script type="text/javascript" src="/datatables/datatables.min.js"></script>
    @include('ops-snapshot.css')
    @include('ops-snapshot.js')
@endsection

@section('modals')
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

    <div class="modal" id="status-details-modal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Dashboard Marks</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body overflow-auto" style="max-height: 500px">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
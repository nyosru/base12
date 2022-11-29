@extends('layouts.app')

@section('title')
    PQ Stats
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        PQ Stats
                    </div>
                    <div class="card-body">
                        {{--<form action="/pq-stats/load-stats" method="post">--}}
                            @csrf
                            <div class="text-center" style="margin-bottom:15px;">
                                <?php echo $months_btns . $q_btns;?>
                                <button class="btn btn-sm btn-info y-btn" style="margin-right: 7px;color:white;">Y</button>
                                <?php echo $y_select;?>
                            </div>
                            <div class="text-center mb-3">
                                <label class="mr-3"><input type="radio" name="date_type_filter" id="pq-request-rb"
                                                           value="pq-request" checked/> PQ Request</label>
                                <label class="mr-3"><input type="radio" name="date_type_filter" id="booking-confirmed-rb"
                                                           value="booking-confirmed"/> Booking Confirmed</label>
                                <label class="mr-3" style="font-weight: normal;">
                                    From Date: <input type="text" id="from_date" name="from_date" class="form-control"
                                                      placeholder="YYYY-MM-DD" value=""
                                                      style="width: 130px;display: inline-block">
                                </label>
                                <label style="font-weight: normal;">
                                    To Date: <input type="text" id="to_date" name="to_date" class="form-control" placeholder="YYYY-MM-DD"
                                                    value="<?php echo date('Y-m-d');?>"
                                                    style="width: 130px;display: inline-block">
                                </label>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <div class="row">
                                        <label for="name" class="col-3">Name:</label>
                                        <div class="col-9">
                                            <input type="text" class="form-control" id="name" name="name"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <label for="email" class="col-3">Email:</label>
                                        <div class="col-9">
                                            <input type="email" class="form-control" id="email" name="email"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <label for="phone" class="col-3">Phone:</label>
                                        <div class="col-9">
                                            <input type="text" class="form-control" id="phone" name="phone"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <table>
                                        <tr>
                                            <td style="white-space: nowrap;padding: 3px;vertical-align: top;">Lead Status:
                                            </td>
                                            <td style="padding: 3px;vertical-align: top;">
                                                <a href="#" data-class="lead-status-filter-chbx" data-all="1"
                                                   class="all-btn badge badge-dark mr-3">ALL</a>
                                                @foreach(\App\LeadStatus::all() as $el)
                                                    <label class="mr-3">
                                                        <input type="checkbox" class="lead-status-filter-chbx" name="lead_statuses[]"
                                                               value="{{$el->id}}" checked=""> {{$el->name}}
                                                    </label>
                                                @endforeach
                                                <label class="mr-3">
                                                    <input type="checkbox" class="lead-status-filter-chbx" name="lead_statuses[]"
                                                           value="-1" checked=""> UNCLAIMED
                                                </label>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <table>
                                        <tr>
                                            <td style="white-space: nowrap;padding: 3px;vertical-align: top;">SDR:</td>
                                            <td style="padding: 3px;vertical-align: top;">
                                                <a href="#" data-class="sdr-filter-chbx" data-all="1"
                                                   class="all-btn badge badge-dark mr-3">ALL</a>
                                                @foreach(\App\Tmfsales::whereIn('Level',[6,9])->where('ID','!=',53)->where('Visible',1)->orderBy('Level','desc')->get() as $tmfsales_el)
                                                    <label class="{{$loop->index?'ml-3':''}}">
                                                        <input type="checkbox" class="sdr-filter-chbx" name="sdrs[]" value="{{$tmfsales_el->ID}}" checked="">
                                                        {{$tmfsales_el->FirstName}}
                                                    </label>
                                                @endforeach
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <table>
                                        <tr>
                                            <td style="white-space: nowrap;padding: 3px;vertical-align: top;">From:</td>
                                            <td style="padding: 3px;vertical-align: top;">
                                                <a href="#" data-class="from-filter-chbx" data-all="1"
                                                   class="all-btn badge badge-dark mr-3">ALL</a>
                                                <label class="mr-3">
                                                    <input type="checkbox" class="from-filter-chbx" name="came_from[]" value="FB Paul LaMarca Ad" checked="">
                                                    Paul LaMarca FB Ad
                                                </label>
                                                <label class="mr-3">
                                                    <input type="checkbox" class="from-filter-chbx" name="came_from[]" value="FB Paul LaMarca Ad 1" checked="">
                                                    Paul LaMarca FB Ad 1
                                                </label>
                                                <label class="mr-3">
                                                    <input type="checkbox" class="from-filter-chbx" name="came_from[]" value="FB Paul LaMarca Ad 2" checked="">
                                                    Paul LaMarca FB Ad 2
                                                </label>
                                                <label class="mr-3">
                                                    <input type="checkbox" class="from-filter-chbx" name="came_from[]" value="Instagram" checked="">
                                                    Instagram
                                                </label>
                                                <label class="mr-3">
                                                    <input type="checkbox" class="from-filter-chbx" name="came_from[]" value="Other" checked="">
                                                    Other
                                                </label>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="mb-3 text-center">
                                <button class="btn btn-success" id="show-stat-btn">SHOW</button>
                            </div>
                        {{--</form>--}}
                        <div class="text-center">
                            <div class="d-inline-block m-auto text-left" id="result-block"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @include('pq-stats.details-modal')
    @include('pq-stats.client-data-modal')
@endsection

@section('external-jscss')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.12.0/jquery-ui.js" type="text/javascript"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
    <link href="https://trademarkfactory.com/js/noty/lib/noty.css" rel="stylesheet">
    <script type="text/javascript" src="https://trademarkfactory.com/js/noty/lib/noty.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://trademarkfactory.com/js/moment-timezone-with-data.js"></script>

    @include('pq-stats.js')
@endsection
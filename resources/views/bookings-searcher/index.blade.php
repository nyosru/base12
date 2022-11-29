@extends('layouts.app')

@section('title')
    Bookings Searcher
@endsection

@section('content')
    <div class="" style="width: 90%;margin: auto">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Bookings Search
                        <a class="float-right" href="/bookings-calendar">Bookings Calendar</a>
                    </div>

                    <div class="card-body">
                        <div style="margin:auto;width:100%;">
                            <div class="row mb-3">
                                <div class="col-4">
                                    <div class="row">
                                        <label for="name" class="col-3">Name:</label>
                                        <div class="col-9">
                                            <input type="text" class="form-control" id="name"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <label for="email" class="col-3">Email:</label>
                                        <div class="col-9">
                                            <input type="email" class="form-control" id="email"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <label for="phone" class="col-3">Phone:</label>
                                        <div class="col-9">
                                            <input type="text" class="form-control" id="phone"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mb-5">
                                <button class="btn btn-success" id="show-data">SHOW</button>
                            </div>
                            <div id="result-table"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('external-jscss')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#show-data').click(function () {
            $('#tmfwaiting400_modal').modal('show');
            $.post(
                location.href,
                {
                    name:$.trim($('#name').val()),
                    email:$.trim($('#email').val()),
                    phone:$.trim($('#phone').val())
                },
                function (msg) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    }, 500);
                    //
                    $('#result-table').html(msg);
                    // console.log(msg);
                }
            );

        });
    </script>
@endsection
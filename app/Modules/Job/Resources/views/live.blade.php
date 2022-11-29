@extends('job::app.app')


@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col-12 bg-info">
                <h1>Платежи</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-12">

                {{-- <pre>
        {{ print_r($data) }}
    </pre> --}}

                @if (1 == 1)
                    <table class="table">
                        {{-- <thead>
                            @foreach ($data_head as $pole)
                                @if ($pole == 'client_id' || $pole == 'job_id' || $pole == 'job_kooperative' || $pole == 'job_nomer')
                                @else
                                    <th>{{ $pole }}</th>
                                @endif
                            @endforeach
                        </thead> --}}
                        @foreach ($data as $k => $cl)


                            @if ($loop->index == 0)
                                <thead>
                                    <tr>
                                        @foreach ($cl as $kk => $pole)
                                            <th>{{ $kk }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                            @endif


                            <tr>

                                {{-- <td>{{ $loop->index }}</td> --}}
                                {{-- <td><pre>{{ print_r($cl) }}</pre></td> --}}
                                {{-- @foreach ($data_head as $pole) --}}

                                @foreach ($cl as $kk => $pole)

                                    {{-- @if ($pole == 'client_id' || $pole == 'job_id' || $pole == 'job_kooperative' || $pole == 'job_nomer')
                                        @else --}}
                                    {{-- <td>{{ $cl->{$pole} }}</td> --}}

                                    <td>

                                        {{-- {{ $k }} - --}}
                                        {{-- {{ $kk }}<br /> --}}

                                        {{ $pole }}

                                    </td>

                                    {{-- @endif --}}

                                @endforeach

                                <td>
                                    @if (!empty($cl['diff_pay']) && $cl['diff_pay'] > 26)
                                        пора напомнить о платеже
                                    @endif
                                    <br />
                                    <button class="btn btn-sm btn-info">+ платёж</button>
                                </td>

                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                @endif

            </div>
        </div>
    </div>

    {{-- <pre>
            {{ print_r($jobs) }}
        </pre> --}}

@endsection

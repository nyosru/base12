@extends('job::app.app')


@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col-12 bg-info">
                <h1>contract</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-6 col-sm-4">
                <h2>Добавить</h2>

                {{-- <pre>{{ print_r($d_job_jobs_id) }}</pre> --}}

                <form action="{{ route('job.contract.create') }}" method="post">
                    @csrf

                    job_client_id <br />
                    <select name="job_client_id">
                        <option value="">select</option>
                        @foreach ($d_job_client_id as $vv)
                            <option value="{{ $vv->id }}">{{ $vv->name }}</option>
                        @endforeach
                    </select>
                    <br />
                    job_jobs_id <br />
                    <select name="job_jobs_id">
                        <option value="">select</option>
                        @foreach ($d_job_jobs_id as $vv)
                            <option value="{{ $vv->id }}">#{{ $vv->id }} {{ $vv->kooperativ ?? '' }} #
                                {{ $vv->nomer ?? '' }}</option>
                        @endforeach
                    </select>
                    date start<br />
                    <input type="date" name="start_date" value="{{ date('Y-m-d') }}" id=""> <br />
                    price <br />
                    <input type="text" name="price" id=""> <br />
                    status <br />
                    <select name="status">
                        <option value="ok">ok</option>
                        <option value="finish">finish</option>
                    </select>
                    <br />

                    {{-- name <br />
                <input type="text" name="name" id=""> <br />

                phone <br />
                <input type="text" name="phone" id=""> <br />

                phone2 <br />
                <input type="text" name="phone2" id=""> <br />
                phone2_name <br />
                <input type="text" name="phone2_name" id=""> <br />
                comment <br />
                <textarea name="comment"></textarea> --}}
                    <br />
                    <br />

                    <button type="submit">Добавить</button>

                </form>


            </div>
            <div class="col-6 col-sm-8">

                <table class="table">
                    <thead>
                        @foreach ($data_head as $pole)
                            {{-- @if ($pole == 'client_id' || $pole == 'job_id' || $pole == 'job_kooperative' || $pole == 'job_nomer')
                            @else --}}
                                <th>{{ $pole }}</th>
                            {{-- @endif --}}
                        @endforeach
                    </thead>
                    <tbody>
                        @foreach ($data as $cl)
                            <tr>
                                @foreach ($data_head as $pole)
                                    @if ($pole == 'client_id' || $pole == 'job_id' || $pole == 'job_kooperative' || $pole == 'job_nomer')
                                    @else
                                        <td>{{ $cl->{$pole} }}</td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    {{-- <pre>
            {{ print_r($jobs) }}
        </pre> --}}

@endsection

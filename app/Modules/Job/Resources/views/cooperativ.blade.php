@extends('job::app.app')


@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-6">
            Кооперативы
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <h2>Добавить cooperativ</h2>

            <form action="{{ route('job.cooperativ.create') }}" method="post">
                @csrf

                кооператив <br />
                <input type="text" name="name" id=""> <br />

                номер <br />
                <input type="text" name="nomer" id=""> <br />

                комент <br />
                <input type="text" name="comment" id=""> <br />

                {{-- {!! Form::select( 'Статус', ['new','job','repair','off','pause'], 'new', []) !!} --}}
                статус <br />
                <select name="status" id="">
                    <option>new</option>
                    <option>job</option>
                    <option>repair</option>
                    <option>pause</option>
                    <option>off</option>
                </select>

                <br />
                <br />

                <button type="submit">Добавить</button>

            </form>


        </div>
        <div class="col-6">

            <table class="table">
                <tbody>
                    @foreach ($jobs as $job)
                        <tr>
                            <td>{{ $job->id }}</td>
                            <td>{{ $job->kooperativ }}</td>
                            <td>
                                {{ $job->nomer }}
                                <small>
                                    {{ $job->comment }}
                                </small>
                            </td>
                            <td>{{ $job->status }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection

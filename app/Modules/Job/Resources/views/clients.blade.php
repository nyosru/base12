@extends('job::app.app')


@section('content')
    <div class="container-fluid">

        <div class="row" style="padding: 10px 0;">
            <div class="col-12 bg-info">
                <h2>Клиенты</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-4">

                <h3>Добавить</h3>

                <form action="{{ route('job.client.create') }}" method="post">
                    @csrf

                    name <br />
                    <input type="text" name="name" id=""> <br />

                    phone <br />
                    <input type="text" name="phone" id=""> <br />

                    phone2 <br />
                    <input type="text" name="phone2" id=""> <br />
                    phone2_name <br />
                    <input type="text" name="phone2_name" id=""> <br />
                    comment <br />
                    <textarea name="comment"></textarea>

                    <br />
                    <br />

                    <button type="submit">Добавить</button>

                </form>


            </div>
            <div class="col-12 col-sm-8">

                <table class="table">
                    <thead>
                        @foreach ($clients_head as $pole)
                            <th>{{ $pole }}</th>
                        @endforeach
                    </thead>
                    <tbody>
                        @foreach ($clients as $cl)
                            <tr>
                                @foreach ($clients_head as $pole)
                                    <td>
                                        @if (
                                            strpos($pole, 'phone') !== false &&
                                            strpos($pole, 'name') === false
                                            )
                                            <a href="tel:{{ $cl->{$pole} }}">{{ $cl->{$pole} }}</a>
                                        @else
                                            {{ $cl->{$pole} }}
                                        @endif
                                    </td>
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

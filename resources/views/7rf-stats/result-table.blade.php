<table class="table table-bordered" id="main-table">
    <thead>
        <tr>
            <th>Date & Time</th>
            <th>First Name</th>
            <th>Email</th>
            <th>Reviews</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($objs as $obj)
            <tr>
                <td class="text-left" style="white-space: nowrap">{{$obj->created_at->format('Y-m-d H:i')}}</td>
                <td>{{$obj->firstname}}</td>
                <td><a href="mailto:{{$obj->email}}" target="_blank">{{$obj->email}}</a></td>
                <td>
                    @if($obj->files()->count())
                        @foreach($obj->files()->get() as $index=>$file)
                            {{$file->name}}
                            @if($index!=($obj->files()->count()-1)), @endif
                        @endforeach
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
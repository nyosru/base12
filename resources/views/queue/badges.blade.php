@foreach($result as $key=>$value)
    @if($value)
        <span class="badge {{$key}} {{($loop->first?'':'ml-1')}}">{{$value}}</span>
    @endif
@endforeach
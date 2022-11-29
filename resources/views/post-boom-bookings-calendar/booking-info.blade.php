<div class="mb-3">From: {{$how_find_out}}{!! (strlen($gparams)?' <a href="#" class="hfo-details" data-show="0"><i class="fas fa-info-circle"></i></a>':'') !!}</div>
<div class="mb-3">First Page: <a href="{{$from_page['url']}}" target="_blank" style="overflow-wrap: break-word">{{$from_page['title']}}</a></div>
@if(strlen($gparams))
    <div class="mb-3" id="hfo-details" style="display: none">{!! $gparams !!}</div>
@endif
<div class="mb-3">Offer: <a href="{{$offer_preview_url}}" target="_blank">{{$offer->offer_name}}</a></div>
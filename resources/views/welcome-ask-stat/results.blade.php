<div class="mb-3">
    <strong class="mr-3">A.</strong>
    <strong class="welcome-file" data-file="{{$welcome_ask1_data['welcome']->file}}">{{$welcome_ask1_data['welcome']->caption}}</strong>: {{$welcome_ask1_data['welcome']->num}} ->
    <strong>{{$welcome_ask1_data['ask1']->caption}}</strong>: {{$welcome_ask1_data['ask1']->num}} ({{round(100*$welcome_ask1_data['ask1']->num/$welcome_ask1_data['welcome']->num,0)}}% | {{round(100*$welcome_ask1_data['ask1']->num/$welcome_ask1_data['welcome']->num,0)}}%) ->
    <strong>{{$welcome_ask1_data['7red-flags']->caption}}</strong>: {{$welcome_ask1_data['7red-flags']->num}} ({{round(100*$welcome_ask1_data['7red-flags']->num/$welcome_ask1_data['ask1']->num,0)}}% | {{round(100*$welcome_ask1_data['7red-flags']->num/$welcome_ask1_data['welcome']->num,0)}}%) |
    <strong>{{$welcome_ask1_data['ask2']->caption}}</strong>: {{$welcome_ask1_data['ask2']->num}} ({{round(100*$welcome_ask1_data['ask2']->num/$welcome_ask1_data['ask1']->num,0)}}% | {{round(100*$welcome_ask1_data['ask2']->num/$welcome_ask1_data['welcome']->num,0)}}%) ->
    <strong>{{$welcome_ask1_data['lps']->caption}}</strong>: {{$welcome_ask1_data['lps']->num}} ({{round(100*$welcome_ask1_data['lps']->num/$welcome_ask1_data['ask2']->num,0)}}% | {{round(100*$welcome_ask1_data['lps']->num/$welcome_ask1_data['welcome']->num,0)}}%) ->
    <strong>{{$welcome_ask1_data['clicked-cta']->caption}}</strong>: {{$welcome_ask1_data['clicked-cta']->num}} ({{round(100*$welcome_ask1_data['clicked-cta']->num/$welcome_ask1_data['lps']->num,0)}}% | {{round(100*$welcome_ask1_data['clicked-cta']->num/$welcome_ask1_data['welcome']->num,0)}}%)
</div>
<div class="mb-3">
    <strong class="mr-3">B.</strong>
    <strong class="welcome-file" data-file="{{$welcome_ask2_data['welcome']->file}}">{{$welcome_ask2_data['welcome']->caption}}</strong>: {{$welcome_ask2_data['welcome']->num}} ->
    <strong>{{$welcome_ask2_data['ask2']->caption}}</strong>: {{$welcome_ask2_data['ask2']->num}} ({{round(100*$welcome_ask2_data['ask2']->num/$welcome_ask2_data['welcome']->num,0)}}% | {{round(100*$welcome_ask2_data['ask2']->num/$welcome_ask2_data['welcome']->num,0)}}%) ->
    <strong>{{$welcome_ask2_data['ask1']->caption}}</strong>: {{$welcome_ask2_data['ask1']->num}} ({{round(100*$welcome_ask2_data['ask1']->num/$welcome_ask2_data['ask2']->num,0)}}% | {{round(100*$welcome_ask2_data['ask1']->num/$welcome_ask2_data['welcome']->num,0)}}%) ->
    <strong>{{$welcome_ask2_data['7red-flags']->caption}}</strong>: {{$welcome_ask2_data['7red-flags']->num}} ({{round(100*$welcome_ask2_data['7red-flags']->num/$welcome_ask2_data['ask1']->num,0)}}% | {{round(100*$welcome_ask2_data['7red-flags']->num/$welcome_ask2_data['welcome']->num,0)}}%) |
    <strong>{{$welcome_ask2_data['lps']->caption}}</strong>: {{$welcome_ask2_data['lps']->num}} ({{round(100*$welcome_ask2_data['lps']->num/$welcome_ask2_data['ask1']->num,0)}}% | {{round(100*$welcome_ask2_data['lps']->num/$welcome_ask2_data['welcome']->num,0)}}%) ->
    <strong>{{$welcome_ask2_data['clicked-cta']->caption}}</strong>: {{$welcome_ask2_data['clicked-cta']->num}} ({{round(100*$welcome_ask2_data['clicked-cta']->num/$welcome_ask2_data['lps']->num,0)}}% | {{round(100*$welcome_ask2_data['clicked-cta']->num/$welcome_ask2_data['welcome']->num,0)}}%)
</div>
<div class="mb-3">
    <strong class="mr-3">C.</strong>
    <strong class="welcome-file" data-file="{{$welcome_ask3_data['welcome']->file}}">{{$welcome_ask3_data['welcome']->caption}}</strong>: {{$welcome_ask3_data['welcome']->num}} ->
    <strong>{{$welcome_ask3_data['ask2']->caption}}</strong>: {{$welcome_ask3_data['ask2']->num}} ({{round(100*$welcome_ask3_data['ask2']->num/$welcome_ask3_data['welcome']->num,0)}}% | {{round(100*$welcome_ask3_data['ask2']->num/$welcome_ask3_data['welcome']->num,0)}}%) ->
    <strong>{{$welcome_ask3_data['lps']->caption}}</strong>: {{$welcome_ask3_data['lps']->num}} ({{round(100*$welcome_ask3_data['lps']->num/$welcome_ask3_data['ask2']->num,0)}}% | {{round(100*$welcome_ask3_data['lps']->num/$welcome_ask3_data['welcome']->num,0)}}%) ->
    <strong>{{$welcome_ask3_data['clicked-cta']->caption}}</strong>: {{$welcome_ask3_data['clicked-cta']->num}} ({{round(100*$welcome_ask3_data['clicked-cta']->num/$welcome_ask3_data['lps']->num,0)}}% | {{round(100*$welcome_ask3_data['clicked-cta']->num/$welcome_ask3_data['welcome']->num,0)}}%)
</div>
<div class="mb-3">
    <strong class="mr-3">D.</strong>
    <strong class="welcome-file" data-file="{{$welcome_ask4_data['welcome']->file}}">{{$welcome_ask4_data['welcome']->caption}}</strong>: {{$welcome_ask4_data['welcome']->num}} ->
    <strong>{{$welcome_ask4_data['lps']->caption}}</strong>: {{$welcome_ask4_data['lps']->num}}
    @if($welcome_ask4_data['welcome']->num)
    ({{round(100*$welcome_ask4_data['lps']->num/$welcome_ask4_data['welcome']->num,0)}}% | {{round(100*$welcome_ask4_data['lps']->num/$welcome_ask4_data['welcome']->num,0)}}%)
    @else
        (N/A)
    @endif
        ->
    <strong>{{$welcome_ask4_data['clicked-cta']->caption}}</strong>: {{$welcome_ask4_data['clicked-cta']->num}}
    @if($welcome_ask4_data['lps']->num)
    ({{round(100*$welcome_ask4_data['clicked-cta']->num/$welcome_ask4_data['lps']->num,0)}}% | {{round(100*$welcome_ask4_data['clicked-cta']->num/$welcome_ask4_data['welcome']->num,0)}}%)
    @else
        (N/A)
    @endif
</div>
<div class="mb-3">
    <strong class="mr-3">E.</strong>
    <strong class="welcome-file" data-file="{{$welcome_ask5_data['welcome']->file}}">{{$welcome_ask5_data['welcome']->caption}}</strong>: {{$welcome_ask5_data['welcome']->num}} ->
    <strong>{{$welcome_ask5_data['lps']->caption}}</strong>: {{$welcome_ask5_data['lps']->num}}
    @if($welcome_ask5_data['welcome']->num)
    ({{round(100*$welcome_ask5_data['lps']->num/$welcome_ask5_data['welcome']->num,0)}}% | {{round(100*$welcome_ask5_data['lps']->num/$welcome_ask5_data['welcome']->num,0)}}%)
    @else
        (N/A)
    @endif
        ->
    <strong>{{$welcome_ask5_data['clicked-cta']->caption}}</strong>: {{$welcome_ask5_data['clicked-cta']->num}}
    @if($welcome_ask5_data['lps']->num)
    ({{round(100*$welcome_ask5_data['clicked-cta']->num/$welcome_ask5_data['lps']->num,0)}}% | {{round(100*$welcome_ask5_data['clicked-cta']->num/$welcome_ask5_data['welcome']->num,0)}}%)
    @else
        (N/A)
    @endif
</div>
<div class="mb-3">
    <strong class="mr-3">F.</strong>
    <strong class="welcome-file" data-file="{{$welcome_ask6_data['welcome']->file}}">{{$welcome_ask6_data['welcome']->caption}}</strong>: {{$welcome_ask6_data['welcome']->num}} ->
    <strong>{{$welcome_ask6_data['lps']->caption}}</strong>: {{$welcome_ask6_data['lps']->num}}
    @if($welcome_ask6_data['welcome']->num)
    ({{round(100*$welcome_ask6_data['lps']->num/$welcome_ask6_data['welcome']->num,0)}}% | {{round(100*$welcome_ask6_data['lps']->num/$welcome_ask6_data['welcome']->num,0)}}%)
    @else
        (N/A)
    @endif
        ->
    <strong>{{$welcome_ask6_data['clicked-cta']->caption}}</strong>: {{$welcome_ask6_data['clicked-cta']->num}}
    @if($welcome_ask6_data['lps']->num)
    ({{round(100*$welcome_ask6_data['clicked-cta']->num/$welcome_ask6_data['lps']->num,0)}}% | {{round(100*$welcome_ask6_data['clicked-cta']->num/$welcome_ask6_data['welcome']->num,0)}}%)
    @else
        (N/A)
    @endif
</div>
<div class="mb-3">
    <strong class="mr-3">G.</strong>
    <strong class="welcome-file" data-file="{{$welcome_ask7_data['welcome']->file}}">{{$welcome_ask7_data['welcome']->caption}}</strong>: {{$welcome_ask7_data['welcome']->num}} ->
    <strong>{{$welcome_ask7_data['lps']->caption}}</strong>: {{$welcome_ask7_data['lps']->num}}
    @if($welcome_ask7_data['welcome']->num)
    ({{round(100*$welcome_ask7_data['lps']->num/$welcome_ask7_data['welcome']->num,0)}}% | {{round(100*$welcome_ask7_data['lps']->num/$welcome_ask7_data['welcome']->num,0)}}%)
    @else
        (N/A)
    @endif
        ->
    <strong>{{$welcome_ask7_data['clicked-cta']->caption}}</strong>: {{$welcome_ask7_data['clicked-cta']->num}}
    @if($welcome_ask7_data['lps']->num)
    ({{round(100*$welcome_ask7_data['clicked-cta']->num/$welcome_ask7_data['lps']->num,0)}}% | {{round(100*$welcome_ask7_data['clicked-cta']->num/$welcome_ask7_data['welcome']->num,0)}}%)
    @else
        (N/A)
    @endif
</div>
<div class="mb-3">
    <strong class="mr-3">H.</strong>
    <strong class="welcome-file" data-file="{{$welcome_ask8_data['welcome']->file}}">{{$welcome_ask8_data['welcome']->caption}}</strong>: {{$welcome_ask8_data['welcome']->num}} ->
    <strong>{{$welcome_ask8_data['lps']->caption}}</strong>: {{$welcome_ask8_data['lps']->num}}
    @if($welcome_ask8_data['welcome']->num)
    ({{round(100*$welcome_ask8_data['lps']->num/$welcome_ask8_data['welcome']->num,0)}}% | {{round(100*$welcome_ask8_data['lps']->num/$welcome_ask8_data['welcome']->num,0)}}%)
    @else
        (N/A)
    @endif
        ->
    <strong>{{$welcome_ask8_data['clicked-cta']->caption}}</strong>: {{$welcome_ask8_data['clicked-cta']->num}}
    @if($welcome_ask8_data['lps']->num)
    ({{round(100*$welcome_ask8_data['clicked-cta']->num/$welcome_ask8_data['lps']->num,0)}}% | {{round(100*$welcome_ask8_data['clicked-cta']->num/$welcome_ask8_data['welcome']->num,0)}}%)
    @else
        (N/A)
    @endif
</div>
<div class="mb-3">
    <strong class="mr-3">I.</strong>
    <strong class="welcome-file" data-file="{{$welcome_ask9_data['welcome']->file}}">{{$welcome_ask9_data['welcome']->caption}}</strong>: {{$welcome_ask9_data['welcome']->num}} ->
    <strong>{{$welcome_ask9_data['lps']->caption}}</strong>: {{$welcome_ask9_data['lps']->num}}
    @if($welcome_ask9_data['welcome']->num)
    ({{round(100*$welcome_ask9_data['lps']->num/$welcome_ask9_data['welcome']->num,0)}}% | {{round(100*$welcome_ask9_data['lps']->num/$welcome_ask9_data['welcome']->num,0)}}%)
    @else
        (N/A)
    @endif
        ->
    <strong>{{$welcome_ask9_data['clicked-cta']->caption}}</strong>: {{$welcome_ask9_data['clicked-cta']->num}}
    @if($welcome_ask9_data['lps']->num)
    ({{round(100*$welcome_ask9_data['clicked-cta']->num/$welcome_ask9_data['lps']->num,0)}}% | {{round(100*$welcome_ask9_data['clicked-cta']->num/$welcome_ask9_data['welcome']->num,0)}}%)
    @else
        (N/A)
    @endif
</div>
<div class="mb-3">
    <strong class="mr-3">J.</strong>
    <strong class="welcome-file" data-file="{{$welcome_ask10_data['welcome']->file}}">{{$welcome_ask10_data['welcome']->caption}}</strong>: {{$welcome_ask10_data['welcome']->num}} ->
    <strong>{{$welcome_ask10_data['lps']->caption}}</strong>: {{$welcome_ask10_data['lps']->num}}
    @if($welcome_ask10_data['welcome']->num)
    ({{round(100*$welcome_ask10_data['lps']->num/$welcome_ask10_data['welcome']->num,0)}}% | {{round(100*$welcome_ask10_data['lps']->num/$welcome_ask10_data['welcome']->num,0)}}%)
    @else
        (N/A)
    @endif
        ->
    <strong>{{$welcome_ask10_data['clicked-cta']->caption}}</strong>: {{$welcome_ask10_data['clicked-cta']->num}}
    @if($welcome_ask10_data['lps']->num)
    ({{round(100*$welcome_ask10_data['clicked-cta']->num/$welcome_ask10_data['lps']->num,0)}}% | {{round(100*$welcome_ask10_data['clicked-cta']->num/$welcome_ask10_data['welcome']->num,0)}}%)
    @else
        (N/A)
    @endif
</div>
<div class="mb-3">
    <strong class="mr-3">K.</strong>
    <strong class="welcome-file" data-file="{{$welcome_ask11_data['welcome']->file}}">{{$welcome_ask11_data['welcome']->caption}}</strong>: {{$welcome_ask11_data['welcome']->num}} ->
    <strong>{{$welcome_ask11_data['lps']->caption}}</strong>: {{$welcome_ask11_data['lps']->num}}
    @if($welcome_ask11_data['welcome']->num)
    ({{round(100*$welcome_ask11_data['lps']->num/$welcome_ask11_data['welcome']->num,0)}}% | {{round(100*$welcome_ask11_data['lps']->num/$welcome_ask11_data['welcome']->num,0)}}%)
    @else
        (N/A)
    @endif
        ->
    <strong>{{$welcome_ask11_data['clicked-cta']->caption}}</strong>: {{$welcome_ask11_data['clicked-cta']->num}}
    @if($welcome_ask11_data['lps']->num)
    ({{round(100*$welcome_ask11_data['clicked-cta']->num/$welcome_ask11_data['lps']->num,0)}}% | {{round(100*$welcome_ask11_data['clicked-cta']->num/$welcome_ask11_data['welcome']->num,0)}}%)
    @else
        (N/A)
    @endif
</div>
<div class="mb-3">
    <strong class="mr-3">L.</strong>
    <strong class="welcome-file" data-file="{{$welcome_ask12_data['welcome']->file}}">{{$welcome_ask12_data['welcome']->caption}}</strong>: {{$welcome_ask12_data['welcome']->num}} ->
    <strong>{{$welcome_ask12_data['lps']->caption}}</strong>: {{$welcome_ask12_data['lps']->num}}
    @if($welcome_ask12_data['welcome']->num)
    ({{round(100*$welcome_ask12_data['lps']->num/$welcome_ask12_data['welcome']->num,0)}}% | {{round(100*$welcome_ask12_data['lps']->num/$welcome_ask12_data['welcome']->num,0)}}%)
    @else
        (N/A)
    @endif
        ->
    <strong>{{$welcome_ask12_data['clicked-cta']->caption}}</strong>: {{$welcome_ask12_data['clicked-cta']->num}}
    @if($welcome_ask12_data['lps']->num)
    ({{round(100*$welcome_ask12_data['clicked-cta']->num/$welcome_ask12_data['lps']->num,0)}}% | {{round(100*$welcome_ask12_data['clicked-cta']->num/$welcome_ask12_data['welcome']->num,0)}}%)
    @else
        (N/A)
    @endif
</div>

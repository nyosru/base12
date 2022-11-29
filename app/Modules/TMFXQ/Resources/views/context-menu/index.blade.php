<ul class="dropdown-menu" id="context-menu">
    <div>
        <div class="d-inline-block float-left">
            @for($i=0;$i<=(intval(count($items)/2)+(count($items)%2));$i++)
                {!! $items[$i] !!}
            @endfor
        </div>
        <div class="d-inline-block float-left">
            @for($i=(intval(count($items)/2)+(count($items)%2)+1);$i<count($items);$i++)
                {!! $items[$i] !!}
            @endfor
        </div>
    </div>
</ul>

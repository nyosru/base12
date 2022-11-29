@if($section->items->count())
    <table class="table table-bordered item-table" data-section-id="{{$section->id}}">
        @foreach($section->items->sortBy('order_field',SORT_REGULAR,true) as $item)
            <tr class="item-row" data-section-id="{{$section->id}}" data-id="{{$item->id}}"
                data-visible="{{(new \DateTime($item->visible_date))->format('Y-m-d')}}"
                data-headline="{!! htmlentities($item->headline,ENT_QUOTES,'UTF-8') !!}"
                data-post-url="{{$item->post_url}}"
                data-long-url="{{$item->long_url}}"
                data-comment="{!! htmlentities(nl2br($item->comment),ENT_QUOTES,'UTF-8') !!}"
                data-youtube-url="{{$item->youtube_url}}"
                data-sniply-url="{{$item->adlinks_url}}"
                data-twitter="{!! htmlentities($item->twitter,ENT_QUOTES,'UTF-8') !!}"
                data-visibility="{{$item->visibility}}"
                data-seo-title="{{$item->seo_title}}"
                data-seo-description="{{$item->seo_description}}"
                data-seo-keywords="{{$item->seo_keywords}}"
            >
                <td class="text-left">
                    <span class="mr-3"><i class="fas fa-arrows-alt-v move-item" style="cursor: grab;color:#aaa"></i></span>{{$item->headline}}
                </td>
            </tr>
        @endforeach
    </table>
@else
    <div class="text-center">EMPTY</div>
@endif

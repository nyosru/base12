@if($section->items->count())
    <table class="table table-bordered item-table" data-section-id="{{$section->id}}">
        @foreach($section->items->sortBy('place_id') as $item)
            <tr class="item-row" data-section-id="{{$section->id}}" data-id="{{$item->id}}"
                data-title="{!! htmlentities($item->title,ENT_QUOTES,'UTF-8') !!}"
                data-title-html="{!! htmlentities($item->title_html,ENT_QUOTES,'UTF-8') !!}"
                data-url="{!! htmlentities($item->url,ENT_QUOTES,'UTF-8') !!}"
                data-description="{!! htmlentities(nl2br($item->description),ENT_QUOTES,'UTF-8') !!}"
                data-transcription="{!! htmlentities(nl2br($item->transcription),ENT_QUOTES,'UTF-8') !!}"
                data-youtube-id="{{$item->youtube_id}}"
                data-sniply-url="{{$item->sniply_url}}"
                data-twitter="{!! htmlentities($item->twitter,ENT_QUOTES,'UTF-8') !!}"
                data-visible="{{$item->visibility}}"
                data-seo-title="{{$item->seo_title}}"
                data-seo-description="{{$item->seo_description}}"
            >
                <td class="text-left">
                    <span class="mr-3"><i class="fas fa-arrows-alt-v move-item" style="cursor: grab;color:#aaa"></i></span>{{$item->title}}
                    {!! $item->title==$item->title_html?'':'<i class="fas fa-code" style="color:green" title="Title != HTML Title"></i>'!!}
                    {!!strlen($item->twitter)?'<i class="fab fa-twitter" style="color:blue" title="Twitter is not empty"></i>':''!!}
                    {!!strlen($item->sniply_url)?'':'<i class="fas fa-link" style="color:red" title="Sniply code is empty"></i>'!!}
                    {!!strlen($item->description)?'':'<i class="fas fa-comment-slash" style="color:red" title="Description is empty"></i>'!!}
                    {!!strlen($item->transcription)?'':'<i class="far fa-file-alt" style="color:red" title="Transcription is empty"></i>'!!}
                    @switch($item->visibility)
                        @case('unlisted')
                            <i class="far fa-eye"></i>
                        @break
                        @case('hidden')
                            <i class="far fa-eye-slash"></i>
                        @break
                    @endswitch
                    {{--<a href="#" class="del-item-btn float-right" title="Remove Item" style="color: red;" data-id="{{$item->id}}"><i class="fas fa-times"></i></a>--}}
                </td>
            </tr>
        @endforeach
    </table>
@else
    <div class="text-center">EMPTY</div>
@endif

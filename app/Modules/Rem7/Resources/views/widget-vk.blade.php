<script defer type="text/javascript" src="https://vk.com/js/api/openapi.js?169" ></script>
{{-- <!-- VK Widget --> --}}
<div id="vk_community_messages"
{{-- style="
/* position: absolute; */
/* padding-right: 100px; */
" --}}
></div>
{{-- <script type="text/javascript">
    VK.Widgets.CommunityMessages("vk_community_messages", 73827323, {
        /*expanded: "1", // открывать */
        tooltipButtonText: "Есть вопрос?"
    });
</script> --}}

@section('script')
    @parent
    <script type="text/javascript">
        setTimeout(() => {
            VK.Widgets.CommunityMessages("vk_community_messages", 73827323, {
                /* открывать чере сколько милисек */
                /* expandTimeout: "500000", */
                tooltipButtonText: "Есть вопрос?"
            });
        }, 5000)
    </script>
@endsection

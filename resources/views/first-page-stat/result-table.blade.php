<table class="table table-bordered" id="main-table">
    <thead>
        <tr>
            <th>Page</th>
            <th>Count</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $el)
            <tr>
                <td class="text-left" style="white-space: pre-line;max-width: 300px;"><a href="https://trademarkfactory.com{{$el['data']['url']}}" target="_blank">{{$el['data']['title']}}</a></td>
                <td>{{$el['count']}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<table class="table table-bordered" id="raw-revenues-table">
    <thead>
        <tr>
            <th>Date</th>
            <th>Client</th>
            <th>Client Type</th>
            <th>Pay Type</th>
            <th>Client Source</th>
            <th>Boom Source</th>
        </tr>
        <tr>
            <th></th>
            <th>
                <input type="text" class="form-control" id="client-filter-input">
            </th>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($mm_in_objs as $obj)
            <tr class="raw-revenues-row"
                    data-pay-type="{{$obj->money_mlc_pay_type_id}}"
                    data-client="{{$obj->money_mlc_clients_id}}"
                    data-client-type="{{$obj->money_mlc_client_type_id}}"
                    data-client-source="{{$obj->moneyMlcClient->money_mlc_client_source_id}}"
                    data-boom-source="{{$obj->money_mlc_boom_source_id}}">
                <td class="text-right text-nowrap">{{(new \DateTime($obj->DateReceived))->format('Y-m-d')}}</td>
                <td class="text-left">{{$obj->moneyMlcClient->Client}}</td>
                <td class="text-left">{{$obj->moneyMlcClientType->name}}</td>
                <td class="text-center">{{$obj->moneyMlcPayType->name}}</td>
                <td class="text-left">{{$obj->moneyMlcClient->moneyMlcClientSource->name}}</td>
                <td class="text-left">{{$obj->moneyMlcBoomSource->name}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
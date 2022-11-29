<div class="table-wrapper">
    <span id="table-loader">Loading...</span>
    <table id="registration-applications-list" class="table table-dark" style="width:100%">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Text</th>
            <th scope="col">Status</th>
            <th scope="col">Date</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Text</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        </tfoot>
    </table>
</div>
<script type="text/javascript" src="{{@asset('datatables/datatables.js')}}"></script>
<script>
    const URL = '/affiliate/reg-applications';
    const STATUS_APPROVED = 1;
    const STATUS_DECLINED = 2;
    const $table = $('#registration-applications-list');
    const $loader = $('#table-loader');

    $table.dataTable({
        searching: false,
        info: false,
        pagingType: 'simple',
        pageLength: 25,
        paging: {
            info: false,
        },
        language: {
            paginate: {next: '', previous: '',},
            language: {
                loadingRecords: '&nbsp;',
                processing: 'Loading...'
            }
        },
        ajax: {
            url: URL,
        },
        columns: [
            {data: "profile.name"},
            {data: "profile.email"},
            {data: "text"},
            {
                data: "status",
                render: renderStatus,
            },
            {data: "created_at"},
            {
                data: "actions",
                render: renderActions,
            }
        ],
    });

    $table.on('length.dt', onPageSizeChange);

    function renderActions(data, type, row) {
        return (
            `<div class="actions">`
            + `<a href='#' onclick='updateStatus(event, ${row.id}, STATUS_APPROVED)'>Accept</a><br/>`
            + `<a href='#' onclick='updateStatus(event, ${row.id}, STATUS_DECLINED)'>Decline</a>`
            + `</div>`
        )
    }

    function renderStatus(data, type, row) {
        const map = {
            0: 'Pending',
            1: 'Approved',
            2: 'Declined',
        };

        return map[row.status];
    }

    function onPageSizeChange(e, settings, len) {
        $table.api().ajax.url(URL + '?' + $.param({per_page: len})).load();
    }

    function updateStatus(e, id, status) {
        e.preventDefault();

        $.ajax({
            url: `reg-applications/${id}/update_status`,
            method: "post",
            data: {
                _token: "{{ csrf_token() }}",
                status: status,
            },
            success: () => {
                $table.api().ajax.reload();
            },
        });
    }
</script>
<style>
    .table-wrapper {
        position: relative;
    }

    #table-loader {
        background: rgba(255, 255, 255, 0.8);
        padding: 10px 20px;
        position: absolute;
        transform: translate(-50%, -50%);
        top: 50%;
        left: 50%;
        z-index: 1;
        display: none;
    }

    #registration-applications-list_wrapper {
        display: unset;
    }

    .dataTables_length {
        margin-bottom: 15px;
    }

    .dataTables_length > label {
        display: unset;
    }
</style>


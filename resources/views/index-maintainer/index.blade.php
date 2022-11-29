@extends('layouts.app')

@section('title')
    Index Maintainer
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Index Maintainer
                        <button class="btn btn-sm btn-success float-right" id="add-new-item-btn">
                            <i class="fas fa-plus"></i> NEW ITEM
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="result-table-block" style="width: 99%;margin: auto">{!! $result_table !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal" id="add-edit-item-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label class="col-3" for="portal-section">Section:</label>
                        <div class="col-9">
                            <select id="portal-section">
                                @foreach($tmfportal_index_sections as $tmfportal_index_section)
                                    <option value="{{$tmfportal_index_section->id}}">{{$tmfportal_index_section->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-3" for="link-name">Link Name:</label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="link-name"/>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-3" for="link">URL:</label>
                        <div class="col-9">
                            <textarea class="form-control" rows="5" id="link"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="save-btn">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('external-jscss')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js" type="text/javascript"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
    <script type="text/javascript" src="https://trademarkfactory.com/selectize/js/standalone/selectize.js"></script>
    <link rel="stylesheet" type="text/css" href="https://trademarkfactory.com/selectize/css/selectize.css"/>
    <link href="http://trademarkfactory.com/js/noty/lib/noty.css" rel="stylesheet">
    <script type="text/javascript" src="http://trademarkfactory.com/js/noty/lib/noty.min.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var portal_section_selectize=$('#portal-section').selectize({create:true});
        var pss=portal_section_selectize[0].selectize;

        $('#add-new-item-btn').click(function () {
            $('#add-edit-item-modal .modal-title').text('Add New Item');
            $('#save-btn').data('href','/index-maintainer/save');
            $('#link-name,#link').val('');
            $('#add-edit-item-modal').modal('show');
        });

        $('body').on('click','.edit-btn',function () {
            $('#add-edit-item-modal .modal-title').text('Edit Item');
            $('#save-btn').data('href','/index-maintainer/edit/'+$(this).data('id'));
            pss.setValue($(this).data('section-id'));
            var parent_tr=$(this).parents('tr:eq(0)');
            $('#link').val(parent_tr.find('a:eq(0)').attr('href'));
            $('#link-name').val($.trim(parent_tr.find('td:eq(0)').text()));
            $('#add-edit-item-modal').modal('show');
        });

        $('#save-btn').click(function () {
            $('#add-edit-item-modal').modal('hide');
            // $('#tmfwaiting400_modal').modal('show');
            var level={{Auth::user()->Level}};
            if($('#level').length)
                level=$('#level').val();
            $.post(
                $('#save-btn').data('href'),
                {
                    section:$('#portal-section').val(),
                    link_name:$.trim($('#link-name').val()),
                    link:$.trim($('#link').val()),
                    level:level
                },
                function (msg) {
                    // $('#tmfwaiting400_modal').modal('hide');
                    if(Object.keys(msg).length){
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: 'Saved',
                            timeout: 1500
                        }).show();
                        $('#result-table-block').html(msg.result_table);
                        pss.destroy();
                        $('#portal-section').html(msg.portal_sections);
                        portal_section_selectize=$('#portal-section').selectize({create:true});
                        pss=portal_section_selectize[0].selectize;
                    }else{
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: 'Unknown error during saving data!',
                            timeout: 1500
                        }).show();
                        $('#add-edit-item-modal').modal('show');
                    }
                }
            );
        });

        $('body').on('click','.del-btn',function () {
            if(confirm('Delete Item?')){
                $.post(
                    '/index-maintainer/delete/'+$(this).data('id'),
                    {},
                    function (msg) {
                        if(msg.length){
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: 'Done',
                                timeout: 1500
                            }).show();
                            $('#result-table-block').html(msg);
                        }else{
                            new Noty({
                                type: 'error',
                                layout: 'topRight',
                                text: 'Unknown error during deleting item!',
                                timeout: 1500
                            }).show();
                        }
                    }
                );
            }
        });
    </script>
@endsection
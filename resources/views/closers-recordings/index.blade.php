@extends('layouts.app')

@section('title')
    Closers Recordings
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Closers Recordings</div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="text-center mb-3" style="display: none;">
                                    <button id="upload-btn" class="btn btn-success">UPLOAD CALL</button>
                                </div>
                                <div style="max-height: 450px;overflow-y: auto">
                                    <table class="table table-bordered">
                                        <tbody>
                                        @if(count($files))
                                            @foreach($files as $file)
                                                <tr>
                                                    <td>
                                                        <a href="{{Storage::disk('dropbox')->url($file)}}" target="_blank">{{basename($file)}}</a>
                                                        <a href="#" data-file="{{$file}}" class="remove-row text-danger float-right"><i class="fa fa-times" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr><td class="text-center">EMPTY</td></tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal" id="upload-call-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Call</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div class="row recently-uploaded-block" style="font-size:11px;margin-bottom: 20px;">
                        <div class="col-md-12 text-center" id="uploaded-files">NO UPLOADED FILES YET</div>
                    </div>
                    <div class="row" id="upload-files-progress" style="margin-bottom: 15px;display: none;">
                        <div class="col-md-12 text-center">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                    0%
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="multi-files-dragarea">
                        Drag file here or click to upload
                    </div>
                    <input type="file" name="upfile[]" id="upfiles" multiple="" style="display: none">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="upload-call-btn">Start Upload</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('external-jscss')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js" type="text/javascript"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
    <link href="https://trademarkfactory.com/js/noty/lib/noty.css" rel="stylesheet">
    <script type="text/javascript" src="https://trademarkfactory.com/js/noty/lib/noty.min.js"></script>
    <script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}" type="text/javascript"></script>
    {{--    <link href="{{ asset('jstree/dist/themes/default/style.min.css') }}" rel="stylesheet"/>--}}
    <style>
        .multi-files-dragarea {
            cursor: pointer;
            border: 1px dashed #999;
            border-radius: 5px;
            /*display: inline-block;*/
            padding: 100px;
            /*position: relative;*/
            /*top: -3px;*/
            /*margin-right: 3px;*/
            /*margin-top: 5px;*/
            background: transparent;
        }
    </style>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var files_list_selector='#uploaded-files';
        var files_input_selector='#upfiles';
        var files=[];

        function paintFiles(){
            var result='';
            if(files.length) {
                result+='<table style="margin: auto">';
                $.each(files, function (i, val) {
                    result+='<tr>';
                    result+='<td class="text-left">';
                    result+=val.name;
                    result+='<span style="float:right;cursor:pointer;color:red;padding-left:10px;" class="remove-file" data-index="'+i+'"><i class="fa fa-times" aria-hidden="true"></i></span>';
                    result+='</td>';
                    result+='</tr>';
                });
                result+='</table>';
            }
            if(result.length)
                $(files_list_selector).html(result);
            else
                $(files_list_selector).html('NO UPLOADED FILES YET');
        }

        function alreadyInFiles(val){
            var flag=0;
            $.each(files, function (i, el) {
                if(el.name==val.name)
                    flag=1;
            });
            return flag;
        }

        $(files_input_selector).change(function () {
            $.each($(this)[0].files,function (i,val) {
                if(!alreadyInFiles(val))
                    files.push(val);
            });
            paintFiles();
        });

        $('body').on('click','.remove-file',function () {
            var index=Number($(this).data('index'));
            files.splice(index,1);
            paintFiles();
        });

        $('body').on('dragover', '.multi-files-dragarea', function () {
            $(this).css('background', 'lightgray');
            return false
        });

        $('body').on('dragleave', '.multi-files-dragarea', function () {
            $(this).css('background', 'transparent');
            return false
        });

        $('body').on('drop', '.multi-files-dragarea', function (event) {
            event.preventDefault();
            //var img_id = getImgId($(this));
            $.each(event.originalEvent.dataTransfer.files,function (i,val) {
                if(!alreadyInFiles(val))
                    files.push(val);
            });
            $(this).css('background', 'transparent');
            paintFiles();
        });

        $('body').on('click','.multi-files-dragarea',function () {
            $(files_input_selector).trigger('click');
        });


        $('#upload-btn').click(function () {
            $('#upload-call-modal').modal('show');
        });

        function uploadAttachedFiles(){
            if (files.length) {
                var formData = new FormData();
                $.each(files,function (i,el) {
                    formData.append('tmf-file[]',el);
                });
                $('#upload-files-progress').show();
                $.ajax({
                    url: location.href,
                    data: formData,
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                // console.log(percentComplete);
                                var percent=Math.round(percentComplete * 100);
                                $("#upload-files-progress .progress-bar").css("width", + percent +"%");
                                $("#upload-files-progress .progress-bar").text(percent +"%");
                            }
                        }, false);
                        return xhr;
                    },
                    success: function (msg) {
                        $('#upload-files-progress').hide();
                        if (msg.length) {
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: 'DONE',
                                timeout: 1500
                            }).show();
                            // console.log(msg);
                            location.reload();
                            // $('#upload-call-modal').modal('hide');
                        } else {
                            new Noty({
                                type: 'error',
                                layout: 'topRight',
                                text: 'Unknown error during saving file!',
                                timeout: 1500
                            }).show();
                        }
                    }
                });
            }
        }

        $('#upload-call-btn').click(function () {
            uploadAttachedFiles();
        });

        $('.remove-row').click(function () {
            if(confirm('Remove call?')){
                $('#tmfwaiting400_modal').modal('show');
                $.post(
                    '/closers-recordings-uploader/remove-call',
                    {call:$(this).data('file')},
                    function (msg) {
                        setTimeout(function () {
                            $('#tmfwaiting400_modal').modal('hide');
                        },500);
                        if(msg.length){
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: 'DONE',
                                timeout: 1500
                            }).show();
                            // console.log(msg);
                            location.reload();
                        }else
                            new Noty({
                                type: 'error',
                                layout: 'topRight',
                                text: 'Unknown error during removing call!',
                                timeout: 1500
                            }).show();
                    }
                );
            }
            return false;
        });

    </script>
@endsection
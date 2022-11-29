@extends('layouts.app')

@section('title')
    Outreach Email 1
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Outreach Email 1</div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <div class="row">
                                    <label for="email-template" class="col-md-2">Template:</label>
                                    <div class="col-md-8">
                                        <select id="email-template" class="form-control">
                                            @foreach($email_templates as $email_template)
                                                <option value="{{$email_template->id}}">{{$email_template->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="row">
                                    <label for="firstname" class="col-md-4">First Name:</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="firstname"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <label for="company" class="col-md-4">Company:</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="company"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <label for="email" class="col-md-4">Email:</label>
                                    <div class="col-md-8">
                                        <input type="email" class="form-control" id="email"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="row">
                                    <label for="from" class="col-md-4">From:</label>
                                    <div class="col-md-8">
                                        <select id="from" class="form-control">
                                            @foreach($users as $user)
                                                <option value="{{$user->ID}}" data-signature="{!! htmlentities(file_get_contents('https://trademarkfactory.com/signatureall_new.php?id='.$user->ID,false,stream_context_create($arrContextOptions)),ENT_QUOTES,'UTF-8') !!}"
                                                        @if($user->ID==79) selected @endif>{{$user->FirstName}} {{$user->LastName}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-3">Image:</div>
                                    <div class="col-md-6" id="selected-img-preview">NONE</div>
                                    <div class="col-md-3">
                                        <button id="change-img" class="btn btn-sm btn-outline-dark">change</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <div class="row">
                                    <label for="subject" class="col-md-2">Subject:</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="subject">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <textarea id="email-body"></textarea>
                            </div>
                        </div>
                        <div class="text-center">
                            <button id="send-now" class="btn btn-success">SEND NOW</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal" id="images-selector-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Click on image to select</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body overflow-auto" style="max-height: 450px;">
                    <div class="text-center mb-3">
                        <label>Filter: <input type="text" id="img-filter" class="form-control"/></label>
                    </div>
                    <div id="images-set"></div>
{{--                    @foreach($images as $image)
                        @if(!($loop->index%3))
                            @if($loop->index)
                                </div>
                            @endif
                            <div class="row mb-3">
                        @endif
                                <div class="col-md-4 image-cell">
                                    <img src="https://trademarkfactory.imgix.net/img/bronson/{{$image}}" class="img-fluid">
                                </div>
                    @endforeach--}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('external-jscss')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js" type="text/javascript"></script>
    <link href="https://trademarkfactory.com/js/noty/lib/noty.css" rel="stylesheet">
    <script type="text/javascript" src="https://trademarkfactory.com/js/noty/lib/noty.min.js"></script>
    <script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}" type="text/javascript"></script>
    {{--    <link href="{{ asset('jstree/dist/themes/default/style.min.css') }}" rel="stylesheet"/>--}}
    <style>
        .image-cell{
            cursor: pointer;
            padding: 15px;
            text-align: center;
        }

        #selected-img-preview{
            text-align: center;
        }

        .image-cell:hover{
            background: orange;
        }

        #img-filter{
            width: 350px;
            display: inline-block;
        }
    </style>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var images={!! json_encode($images) !!};

        var template1ab='<p style="margin-bottom:15px;">Hi %%%firstname%%%,</p>'+
        '<p style="margin-bottom:15px;">This is about your recent ad for %%%company%%%.</p>'+
        '<p style="margin-bottom:15px;">By way of introduction, my name is %%%closername%%%. I’m the Senior Strategy Advisor with Trademark Factory<sup>&reg;</sup>. </p>'+
        '<p style="margin-bottom:15px;">We visited your website and noticed your brand does not have adequate trademark protection, which may expose %%%company%%% to significant risks.</p>'+
        '<p style="margin-bottom:15px;">Since you don\'t know me, I wanted to start off on the right foot by adding some value to you first, so I created a short video that walks you through our findings and offers a solution.</p>'+
            '<p style="margin-bottom:15px;">%%%img%%%</p>'+
        '<p style="margin-bottom:15px;">Would you like me to send this video to you or is there someone else at %%%company%%% who should see it?</p>'+
        '%%%signature%%%';

        var template2ab='<p style="margin-bottom:15px;">%%%firstname%%%,</p>'+
            '<p style="margin-bottom:15px;">As I mentioned in an email I sent you a few days ago, we noticed that your brand is not adequately trademarked, exposing %%%company%%% to significant risks.</p>'+
            '<p style="margin-bottom:15px;">I\'m following up because I thought this was important for you.</p>'+
            '<p style="margin-bottom:15px;">So much so that I actually shot a short video to walk you through our findings.</p>'+
            '<p style="margin-bottom:15px;">%%%img%%%</p>'+
            '<p style="margin-bottom:15px;">If you want me to share it with you (or someone else at %%%company%%%), let me know—and I will send it to you right away.</p>'+
            '<p style="margin-bottom:15px;">If you don\'t want to hear from me again, simply reply \'NO\' to this email—and I will no longer attempt to draw your attention to this matter.</p>'+
            '<p>%%%closer_firstname%%%</p>';

        function translateTemplate1AB(template){
            var translated_text='';
            if($.trim($('#firstname').val()).length)
                translated_text=template.replace(/%%%firstname%%%/g, $.trim($('#firstname').val()));
            else
                translated_text+='<p style="color:red">First Name is empty!</p>';
            if($.trim($('#company').val()).length) {
                translated_text = translated_text.replace(/%%%company%%%/g, $.trim($('#company').val()));
                $('#subject').val(getSubject());
            }else
                translated_text='<p style="color:red">Company is empty!</p>'+translated_text;
            translated_text=translated_text.replace(/%%%closername%%%/g, $.trim($('#from option:selected').text()));
            translated_text=translated_text.replace(/%%%closer_firstname%%%/g, $.trim($('#from option:selected').text().split(' ')[0]));
            translated_text=translated_text.replace(/%%%signature%%%/g, $.trim($('#from option:selected').data('signature')));
            if($('#selected-img').length) {
                var src=$('#selected-img').attr('src');
                translated_text = translated_text.replace(/%%%img%%%/g, '<img src="'+src+'" style="max-width:350px;max-height:350px"/>');
            }else
                translated_text='<p style="color:red">Image not selected!</p>'+translated_text;
            return translated_text;
        }

        function translateTemplate2AB(template) {
            return translateTemplate1AB(template);
        }

        function translateTemplate(){
            switch (Number($('#email-template').val())){
                case 1:
                case 2:
                    return translateTemplate1AB(template1ab);
                case 3:
                case 4:
                    return translateTemplate2AB(template2ab);
            }
        }

        function getSubject(){
            switch (Number($('#email-template').val())){
                case 1:
                    return $.trim($('#company').val()).toUpperCase()+' - TMF';
                case 2:
                case 3:
                    return 'Trademark Issue: '+$.trim($('#company').val());
                case 4:
                    return 'Video about your trademarks';
            }
        }

        $('#firstname,#company').keyup(function () {
            tinymce.get('email-body').setContent(translateTemplate());
        });

        $('#from,#email-template').change(function () {
            tinymce.get('email-body').setContent(translateTemplate());
        });

        $(document).ready(function () {
            tinymce.init({
                selector: "#email-body",
                height: 400,
                convert_urls: false,
                theme: "modern",
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars insertdatetime code media nonbreaking",
                    "table contextmenu directionality emoticons paste textcolor"
                ],
                toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
                toolbar2: "link unlink anchor | image media | forecolor backcolor  | print preview code ",
                image_advtab: true,
                init_instance_callback : function(editor) {
                }
            });

        });

        $('#change-img').click(function () {
            paintImages();
            $('#images-selector-modal').modal('show');
        });

        function paintImages(){
            var filter=$.trim($('#img-filter').val());
            var index=0;
            var html='';
            $.each(images,function (i,val) {
                if(val.toUpperCase().indexOf(filter.toUpperCase())!=-1) {
                    if (!(index % 3)) {
                        if (index)
                            html += '</div>';
                        html += '<div class="row mb-3">';
                    }
                    html+='<div class="col-md-4 image-cell">' +
                            '<img src="https://trademarkfactory.imgix.net/img/bronson/'+val+'" class="img-fluid"/><br/>'+val+
                        '</div>';
                    index++;
                }
            });
            if(html.length)
                html+='</div>';
            $('#images-set').html(html);
        }

        $('#img-filter').keyup(function () {
            paintImages();
        });

        function baseName(str)
        {
            var base = new String(str).substring(str.lastIndexOf('/') + 1);
            if(base.lastIndexOf(".") != -1)
                base = base.substring(0, base.lastIndexOf("."));
            return base;
        }

        $('body').on('click','.image-cell',function () {
            var src=$(this).find('img').attr('src');
            $('#change-img').data('src',src);
            $('#selected-img-preview').html('<img src="'+src+'" id="selected-img" style="max-width: 150px;max-height: 150px;"/><br/>'+baseName(src));
            tinymce.get('email-body').setContent(translateTemplate());
            $('#images-selector-modal').modal('hide');
        });

        function checkEmailFields(){
            var errors=[];
            if(!$.trim($('#email').val()))
                errors.push('Email is empty.');
            if(!$.trim($('#subject').val()))
                errors.push('Subject is empty.');
            if(errors.length){
                new Noty({
                    type: 'error',
                    layout: 'topRight',
                    text: errors.push('<br/>'),
                    timeout: 1500
                }).show();
                return 0;
            }
            return 1;
        }

        $('#send-now').click(function () {
            if(checkEmailFields()){
                $('#tmfwaiting400_modal').modal('show');
                $.post(
                    location.href,
                    {
                        firstname:$.trim($('#firstname').val()),
                        email:$.trim($('#email').val()),
                        from:$('#from').val(),
                        subject:$.trim($('#subject').val()),
                        message:$.trim(tinymce.get('email-body').getContent()),
                        img:$('#change-img').data('src'),
                        email_template:$('#email-template').val()
                    },
                    function (msg) {
                        $('#tmfwaiting400_modal').modal('hide');
                        if(msg.length){
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: 'Sent',
                                timeout: 1500
                            }).show();
                            $('#firstname,#company,#subject,#email').val('');
                            $('#selected-img-preview').html('NONE');
                            tinymce.get('email-body').setContent('');
                            // $('#email-template').val(1);
                        }else
                            new Noty({
                                type: 'error',
                                layout: 'topRight',
                                text: 'Unknown error during sending email',
                                timeout: 1500
                            }).show();
                    }
                );
            }
        });
    </script>
@endsection
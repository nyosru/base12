@extends('layouts.app')

@section('title')
    {{$title}}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{$title}}
                        <input type="text" class="form-control d-inline-block ml-5" name="yt-filter" id="yt-filter"
                               placeholder="Title Filter">
                        <label class="mr-3"><input type="radio" name="yt-filter-radio" value="title" checked/>
                            Title</label>
                        <label><input type="radio" name="yt-filter-radio" value="url"/> YouTube URL</label>
                        <button class="btn btn-sm btn-success float-right" id="add-new-section-btn">
                            <i class="fas fa-plus"></i> NEW SECTION
                        </button>
                        <button class="btn btn-sm btn-warning float-right mr-2" id="export-for-social-pilot-btn">
                            <i class="fas fa-cloud-download-alt"></i> EXPORT FOR SOCIAL PILOT
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="result-table-block" style="width: 99%;margin: auto">
                            <div class="accordion" id="root-block">
                                @foreach($sections as $section)
                                    @include('fc-maintainer.root-block')
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal" id="add-edit-section-modal" tabindex="-1" role="dialog">
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
                        <label class="col-3" for="portal-section">Section Name:</label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="section-name"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="save-section-btn">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="add-edit-item-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="content-tab" data-toggle="tab" href="#content" role="tab"
                               aria-controls="home" aria-selected="true">Content</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="seo-tab" data-toggle="tab" href="#seo" role="tab"
                               aria-controls="seo" aria-selected="false">SEO</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active p-2" id="content" role="tabpanel"
                             aria-labelledby="content-tab">
                            <div class="row mb-3">
                                <label class="col-2" for="item-title">Title:</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="item-title"/>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-2" for="item-title-html">Title HTML <a href="#" id="change-title-link"
                                                                                         style="color: green"><i
                                                class="fas fa-external-link-alt"></i></a>:</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="item-title-html"/>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-2" for="item-url">URL
                                    <a href="#" class="mr-2" id="change-url-link" style="color: green">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                    <a href="#" id="change-underlines-link" style="color: blue">
                                        <i class="fas fa-underline"></i>
                                    </a>:
                                </label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="item-url"/>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-2" for="item-description">Introduction:</label>
                                <div class="col-10">
                                    <textarea id="item-description"></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-2" for="item-transcription">Transcription:</label>
                                <div class="col-10">
                                    <textarea id="item-transcription"></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-4" for="item-youtube-id">Youtube ID <a href="#"
                                                                                                 id="copy-yt-id"
                                                                                                 style="color: green">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>:</label>
                                        <div class="col-8">
                                            <input type="text" class="form-control" id="item-youtube-id"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-4" for="item-sniply-url">Sniply URL <a href="#"
                                                                                                 id="change-sniply-url-link"
                                                                                                 style="color: green"><i
                                                        class="fas fa-link"></i></a>:</label>
                                        <div class="col-8">
                                            <input type="text" class="form-control" id="item-sniply-url"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-2" for="item-twitter">Twitter:</label>
                                <div class="col-10">
                                <textarea id="item-twitter" class="form-control" rows="2"
                                          style="resize: vertical"></textarea>
                                    <span class="el-counter" data-max="275">0 of 275 symbols</span>
                                </div>
                            </div>

                            <div class="row mb-3">

                                <label class="col-2" for="visibility-option-1">Visibility:</label>
                                <div class="col-10">
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="switch-top">
                                                <input type="radio" class="visibility-option-input"
                                                       name="visibility-option"
                                                       value="visible" id="visibility-option-1" checked>
                                                <label for="visibility-option-1"
                                                       class="switch-top-label switch-top-label-off">Visible</label>
                                                <input type="radio" class="visibility-option-input"
                                                       name="visibility-option"
                                                       value="unlisted" id="visibility-option-2">
                                                <label for="visibility-option-2"
                                                       class="switch-top-label switch-top-label-on">Unlisted</label>
                                                <input type="radio" class="visibility-option-input"
                                                       name="visibility-option"
                                                       value="hidden" id="visibility-option-3">
                                                <label for="visibility-option-3"
                                                       class="switch-top-label switch-top-label-three">Hidden</label>
                                                <span class="switch-top-selection"></span>
                                            </div>
                                        </div>
                                        <div class="col-9">
                                            <div class="row">
                                                <label class="col-2" for="item-section">Section:</label>
                                                <div class="col-10">
                                                    <select id="item-section" class="form-control" style="width: auto">
                                                        @foreach($sections as $section)
                                                            <option value="{{$section->id}}">{{$section->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade p-2" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                            <div class="row mb-4">
                                <label class="col-2" for="seo-title">Title:</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="seo-title"/>
                                    <span class="el-counter" data-max="60">0 of 60 symbols</span>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-2" for="seo-description">Description:</label>
                                <div class="col-10">
                                    <textarea id="seo-description" class="form-control" rows="4" style="resize: vertical"></textarea>
                                    <span class="el-counter" data-max="160">0 of 160 symbols</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div style="width: 100%">
                        <button type="button" class="btn btn-danger float-left" id="delete-item-btn">Delete Item
                        </button>
                        <button type="button" class="btn btn-primary float-right" id="save-item-btn">Save</button>
                        <button type="button" class="btn btn-secondary float-right  mr-2" data-dismiss="modal">Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="export-sp-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="/{{$prefix}}-maintainer/export-for-social-pilot" id="export-csv-frm" method="post"
                      target="_blank">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Export For Social Pilot</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row" style="margin-bottom: 20px">
                            <label for="posts-per-day" class="control-label col-md-3">Posts per day:</label>
                            <div class="col-md-2">
                                <select id="posts-per-day" name="post_per_day" class="form-control">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                        {!! $post_time_area !!}
                        <div class="row" style="margin-bottom: 20px">
                            <label for="hashtag" class="control-label col-md-3">Add hashtag:</label>
                            <div class="col-md-9">
                                <input type="text" id="hashtag" name="hashtag" class="form-control" value="">
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 20px">
                            <label for="youtube_url1" class="control-label col-md-3">Youtube URL:</label>
                            <label class="control-label col-md-3"><input type="radio" name="youtube_url"
                                                                         id="youtube_url1" value="0" checked> Do NOT
                                include</label>
                            <label class="control-label col-md-3"><input type="radio" name="youtube_url"
                                                                         id="youtube_url2" value="1"> Before
                                Sniply</label>
                            <label class="control-label col-md-3"><input type="radio" name="youtube_url"
                                                                         id="youtube_url3" value="2"> After
                                Sniply</label>
                        </div>
                        <div class="row" style="margin-bottom: 20px">
                            <label for="first_day_campaign" class="control-label col-md-3">First Day of
                                Campaign:</label>
                            <div class="col-md-9">
                                <input type="text" id="first_day_campaign" name="first_day_campaign"
                                       class="form-control"
                                       value="<?=date('Y-m-d', strtotime(date('Y-m-d') . ' + 1 day'))?>">
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 20px">
                            <label for="number-recurrences" class="control-label col-md-3">Number of
                                recurrences:</label>
                            <div class="col-md-3">
                                <select class="form-control" id="number-recurrences" name="number_recurrences">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Generate CSV
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item export-to-item" data-to="twitter" href="#">for Twitter</a>
                                <a class="dropdown-item export-to-item" data-to="linkedin" href="#">for LinkedIn</a>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="export-action" name="export_action" value=""/>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection

@section('external-jscss')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-migrate-3.0.0.min.js" type="text/javascript"></script>
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js" type="text/javascript"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
    <script type="text/javascript" src="https://trademarkfactory.com/selectize/js/standalone/selectize.js"></script>
    <link rel="stylesheet" type="text/css" href="https://trademarkfactory.com/selectize/css/selectize.css"/>
    <link href="http://trademarkfactory.com/js/noty/lib/noty.css" rel="stylesheet">
    <script type="text/javascript" src="http://trademarkfactory.com/js/noty/lib/noty.min.js"></script>
    <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.css')}}">
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>

    @include('fc-maintainer.css')
    @include('fc-maintainer.js')

@endsection
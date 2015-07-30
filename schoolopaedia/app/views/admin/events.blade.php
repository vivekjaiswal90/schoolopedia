@extends('layouts.main-layout')
@section('stylesheets')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/event-cards.css'); }}"/>
@stop
@section('page_header')
    <h1><i class="fa fa-pencil-square"></i>Home</h1>
@stop

@section('page_breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="#">
                Home
            </a>
        </li>
        <li class="active">
            Schedule
        </li>
    </ol>
@stop

@section('content')
    <!-- start: PAGE CONTENT -->
    <div class="row">
        <div class="col-sm-12">
            <!-- start: FULL CALENDAR PANEL -->
            <div class="panel panel-white">
                <div class="panel-heading">
                    <i class="fa fa-calendar"></i>
                    Full Calendar
                </div>
                <div class="panel-body">
                    <div class="col-sm-12 space20">
                        <a href="#newFullEvent" class="btn btn-green add-event"><i class="fa fa-plus"></i> Add New Event</a>
                    </div>
                    <div class="col-sm-12">
                        <div id='full-calendar'></div>
                    </div>
                </div>
            </div>
            <!-- end: FULL CALENDAR PANEL -->
        </div>
    </div>
    <!-- end: PAGE CONTENT-->
@stop
@section('subview')
    <!-- start: SUBVIEW FOR CALENDAR PAGE -->
    <div id="newFullEvent">
        <div class="noteWrap col-md-8 col-md-offset-2">
            <h3>Add new event</h3>

            <form class="form-full-event">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input class="event-id hide" type="text">
                            <input class="event-name form-control" name="eventName" type="text"
                                   placeholder="Event Name...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" class="all-day" data-label-text="All-Day" data-on-text="True"
                                   data-off-text="False">
                        </div>
                    </div>
                    <div class="no-all-day-range">
                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="form-group">
                                <span class="input-icon">
                                    <input type="text" class="event-range-date form-control" name="eventRangeDate"
                                           placeholder="Range date"/>
                                    <i class="fa fa-clock-o"></i> </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="all-day-range">
                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="form-group">
                                <span class="input-icon">
                                    <input type="text" class="event-range-date form-control" name="ad_eventRangeDate"
                                           placeholder="Range date"/>
                                    <i class="fa fa-calendar"></i>
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hide">
                        <input type="text" class="event-start-date" name="eventStartDate"/>
                        <input type="text" class="event-end-date" name="eventEndDate"/>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <select class="form-control event-categories" name="eventCategory">
                                <option value="">Select Event Category...</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label>
                                Image Upload
                            </label>
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail">
                                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA?text=no+image" alt=""/>
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail"></div>
                                <div>
															<span class="btn btn-light-grey btn-file">
                                                                <span class="fileupload-new">
                                                                    <i class="fa fa-picture-o"></i>
                                                                    Select image
                                                                </span>
                                                                <span class="fileupload-exists">
                                                                    <i class="fa fa-picture-o"></i>
                                                                     Change
                                                                </span>
																<input type="file">
															</span>
                                    <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                                        <i class="fa fa-times"></i> Remove
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea maxlength="50" class="form-control limited" id="event-content" name="content"
                                      placeholder="Event Brief Description..."></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea class="summernote" placeholder="Write note here..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="pull-right">
                    <div class="btn-group">
                        <a href="#" class="btn btn-info close-subview-button">
                            Close
                        </a>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-info save-new-event" type="submit">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel">
                    <div class="panel-title">
                        <h3>This is How Your Event Card Will look like...</h3>
                    </div>
                    <div class="panel-body no-padding">
                        <ul class="event-list">
                            <li>
                                <time datetime="{{ date("Y-m-d") }}">
                                    <span class="day">{{ date("d") }}</span>
                                    <span class="month">{{ date("M") }}</span>
                                    <span class="year">2014</span>
                                    <span class="time">ALL DAY</span>
                                </time>
                                <img alt="Independence Day" src="https://farm4.staticflickr.com/3100/2693171833_3545fb852c_q.jpg"/>
                                <div class="info">
                                    <h2 class="title center" id="card-event-name">Event Title</h2>

                                    <p class="desc center" id="card-event-content">Event Brief Discription</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="panel-footer clearfix no-padding">
                        <div class=""></div>
                        <a href="#" class="col-xs-6 padding-10 text-center text-white tooltips partition-green"
                           data-toggle="tooltip" data-placement="top" title="" data-original-title="Event Details">Details</a>
                        <a href="#" class="col-xs-6 padding-10 text-center text-white tooltips partition-red"
                           data-toggle="tooltip" data-placement="top" title=""
                           data-original-title="Register For This Event">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="readFullEvent">
        <div class="noteWrap col-md-8 col-md-offset-2">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="event-title"></h2>

                    <div class="btn-group options-toggle pull-right">
                        <button class="btn dropdown-toggle btn-transparent-grey" data-toggle="dropdown">
                            <i class="fa fa-cog"></i>
                            <span class="caret"></span>
                        </button>
                        <ul role="menu" class="dropdown-menu dropdown-light pull-right">
                            <li>
                                <a href="#newFullEvent" class="edit-event">
                                    <i class="fa fa-pencil"></i> Edit
                                </a>
                            </li>
                            <li>
                                <a href="#" class="delete-event">
                                    <i class="fa fa-times"></i> Delete
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <span class="event-category event-cancelled">Cancelled</span>
                    <span class="event-allday"><i class='fa fa-check'></i> All-Day</span>
                </div>
                <div class="col-md-12">
                    <div class="event-start">
                        <div class="event-day"></div>
                        <div class="event-date"></div>
                        <div class="event-time"></div>
                    </div>
                    <div class="event-end"></div>
                </div>
                <div class="col-md-12">
                    <div class="event-content"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- end: SUBVIEW FOR CALENDAR PAGE -->
@stop
@section('scripts')
    <!--Start: Scripts for This page only -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js'); }}"></script>
    <script src="{{ URL::asset('assets/js/modifiedJs/admin/events.js'); }}"></script>
    <script>
        jQuery(document).ready(function () {
            Main.init();
            SVExamples.init();
            Events.init();
        });
    </script>
    <!--End: Scripts for This page only -->
@stop

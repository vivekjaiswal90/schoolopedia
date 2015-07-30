@extends('layouts.main-layout')
@section('stylesheets')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/event-cards.css'); }}"/>
@stop
@section('page_header')
    <h1><i class="fa fa-pencil-square"></i>Events</h1>
@stop

@section('page_breadcrumb')
    <ol class="breadcrumb pull-left">
        <li>
            <a href="#">
                Dashboard
            </a>
        </li>
        <li class="active">
            Events
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <div class="panel">
                <div class="panel-body no-padding">
                    <ul class="event-list">
                        <li>
                            <time datetime="2014-07-20">
                                <span class="day">4</span>
                                <span class="month">Jul</span>
                                <span class="year">2014</span>
                                <span class="time">ALL DAY</span>
                            </time>
                            <img alt="Independence Day"
                                 src="https://farm4.staticflickr.com/3100/2693171833_3545fb852c_q.jpg"/>

                            <div class="info">
                                <h2 class="title center">Independence Day</h2>

                                <p class="desc center">United States Holiday</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="panel-footer clearfix no-padding">
                    <div class=""></div>
                    <a href="#" class="col-xs-6 padding-10 text-center text-white tooltips partition-green"
                       data-toggle="tooltip" data-placement="top" title="" data-original-title="More Options">Details <i
                                class="fa fa-cog"></i></a>
                    <a href="#" class="col-xs-6 padding-10 text-center text-white tooltips partition-red"
                       data-toggle="tooltip" data-placement="top" title="" data-original-title="View More">Register <i
                                class="fa fa-chevron-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel">
                <div class="panel-body no-padding">
                    <ul class="event-list">
                        <li>
                            <time datetime="2014-07-20 0000">
                                <span class="day">8</span>
                                <span class="month">Jul</span>
                                <span class="year">2014</span>
                                <span class="time">12:00 AM</span>
                            </time>
                            <div class="info">
                                <h2 class="title center">One Piece Unlimited World Red</h2>

                                <p class="desc center">PS Vita</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="panel-footer clearfix no-padding">
                    <div class=""></div>
                    <a href="#" class="col-xs-6 padding-10 text-center text-white tooltips partition-green"
                       data-toggle="tooltip" data-placement="top" title="" data-original-title="More Options">Details <i
                                class="fa fa-cog"></i></a>
                    <a href="#" class="col-xs-6 padding-10 text-center text-white tooltips partition-red"
                       data-toggle="tooltip" data-placement="top" title="" data-original-title="View More">Register <i
                                class="fa fa-chevron-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel">
                <div class="panel-body no-padding">
                    <ul class="event-list">
                        <li>
                            <time datetime="2014-07-20 2000">
                                <span class="day">20</span>
                                <span class="month">Jan</span>
                                <span class="year">2014</span>
                                <span class="time">8:00 PM</span>
                            </time>
                            <img alt="My 24th Birthday!"
                                 src="https://farm5.staticflickr.com/4150/5045502202_1d867c8a41_q.jpg"/>

                            <div class="info">
                                <h2 class="title">Mouse0270's Birthday!</h2>

                                <p class="desc">Bar Hopping in Erie, Pa.</p>
                            </div>
                            <div class="social">
                                <ul>
                                    <li class="facebook" style="width:33%;"><a href="#facebook"><span
                                                    class="fa fa-facebook"></span></a></li>
                                    <li class="twitter" style="width:34%;"><a href="#twitter"><span
                                                    class="fa fa-twitter"></span></a></li>
                                    <li class="google-plus" style="width:33%;"><a href="#google-plus"><span
                                                    class="fa fa-google-plus"></span></a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="panel-footer clearfix no-padding">
                    <div class=""></div>
                    <a href="#" class="col-xs-6 padding-10 text-center text-white tooltips partition-green"
                       data-toggle="tooltip" data-placement="top" title="" data-original-title="More Options">Details <i
                                class="fa fa-cog"></i></a>
                    <a href="#" class="col-xs-6 padding-10 text-center text-white tooltips partition-red"
                       data-toggle="tooltip" data-placement="top" title="" data-original-title="View More">Register <i
                                class="fa fa-chevron-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel">
                <div class="panel-body no-padding">
                    <ul class="event-list">
                        <li>
                            <time datetime="2014-07-31 1600">
                                <span class="day">31</span>
                                <span class="month">Jan</span>
                                <span class="year">2014</span>
                                <span class="time">4:00 PM</span>
                            </time>
                            <img alt="Disney Junior Live On Tour!"
                                 src="https://farm4.staticflickr.com/3100/2693171833_3545fb852c_q.jpg"/>

                            <div class="info">
                                <h2 class="title">Disney Junior Live On Tour!</h2>

                                <p class="desc"> Pirate and Princess Adventure</p>
                            </div>
                            <div class="social">
                                <ul>
                                    <li class="facebook" style="width:33%;"><a href="#facebook"><span
                                                    class="fa fa-facebook"></span></a></li>
                                    <li class="twitter" style="width:34%;"><a href="#twitter"><span
                                                    class="fa fa-twitter"></span></a></li>
                                    <li class="google-plus" style="width:33%;"><a href="#google-plus"><span
                                                    class="fa fa-google-plus"></span></a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="panel-footer clearfix no-padding">
                    <div class=""></div>
                    <a href="#" class="col-xs-6 padding-10 text-center text-white tooltips partition-green"
                       data-toggle="tooltip" data-placement="top" title="" data-original-title="More Options">Details <i
                                class="fa fa-cog"></i></a>
                    <a href="#" class="col-xs-6 padding-10 text-center text-white tooltips partition-red"
                       data-toggle="tooltip" data-placement="top" title="" data-original-title="View More">Register <i
                                class="fa fa-chevron-right"></i></a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')

    <!-- Scripts for This page only -->
    <script>
        jQuery(document).ready(function () {
            Main.init();
            SVExamples.init();
        });
    </script>

@stop

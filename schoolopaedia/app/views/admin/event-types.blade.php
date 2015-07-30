@extends('layouts.main-layout')

@section('stylesheets')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/select2/select2.css'); }}" />
@stop


@section('page_header')
    <h1><i class="fa fa-pencil-square"></i>Home</h1>
@stop

@section('page_breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="#">
                Dashboard
            </a>
        </li>
        <li class="active">
            Event Categories
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-sm-12">
            @if(Session::has('global'))
                <div class="errorHandler alert alert-success">
                    <i class="fa fa-remove-sign"></i>{{ Session::get('global') }}
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-sm-8 col-sm-offset-2">
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h4 class="panel-title">Event Type<span class="text-bold"> table</span></h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6 space20">
                            <button class="btn btn-green add-row-event-types">
                                New Event Type  <i class="fa fa-plus"></i>
                            </button>
                        </div>
                        <div class="col-sm-6">
                            <h3 class="text-center" id="period-profile-name">  </h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="errorHandler alert alert-danger no-display">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="table-event-types">
                            <thead>
                            <tr>
                                <th>Event Type</th>
                                <th> Edit</th>
                                <th> Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')

    <!-- Scripts for This page only -->
    <script src="{{ URL::asset('assets/plugins/select2/select2.min.js'); }}"></script>
    <script src="{{ URL::asset('assets/js/modifiedJs/admin/event-types.js'); }}"></script>
    <script>
        jQuery(document).ready(function () {
            Main.init();
            SVExamples.init();
            EventTypesTableData.init();
        });
    </script>
@stop

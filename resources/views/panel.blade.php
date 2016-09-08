@extends('layouts.app')

@section('title', 'Admin Panel')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset_timed('css/panel.css') }}">
@endsection

@section('page')
<a href="/register"><span class="glyphicon glyphicon-user"></span>Registration</a>
@endsection

@section('content')
<!-- Admin Panel -->
<div class="container">
    <div class="row">
        <div class="col-xs-offset-2 col-xs-7">

        <div class="alert alert-success user-alert">
            <p><strong> Permission Changed. </strong></p>
        </div>

            <div class="panel panel-default panel">
                <div class="panel-heading">
                    <p align="center"><strong>ADMIN PANEL</strong></p>
                </div>
                <div class="panel-body">
                    <form class="form-inline" role="form">
                        <div class="form-group">
                            <label for="role">Role:</label>
                            <select class="form-control role" name="role">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="resource">Resource:</label>
                            <select class="form-control resource" name="resource">
                            </select>
                        </div>
                        <div class="form-group privilege">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js-css')
<script type="text/javascript" src="{{ asset_timed('js/panel.js') }}"></script>
@endsection
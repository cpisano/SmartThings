@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">


                    <a href="{{ action('SmartThingsController@getOauth') }}" class="facebook">Connect</a>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
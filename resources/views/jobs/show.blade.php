@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Job: <strong>{{ $job->title }}</strong></div>
                <div class="panel-body">
                    <p>
                        {{ $job->description }}
                    </p>
                    <p>
                        <strong>Email: </strong>{{ $job->email }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Edit job</div>

                <div class="panel-body">
                    @include('partials.alert')

                    <form class="form-horizontal" method="POST" action="{{ url('/jobs/'.$job->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') ?? $job->email }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">Title</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') ?? $job->title }}" required autofocus>

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label">Description</label>

                            <div class="col-md-6">
                                <textarea id="description" class="form-control" name="description" rows="8" required>{{ old('description') ?? $job->description }}</textarea>

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="status" class="col-md-4 control-label">Status</label>

                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="approved" value="approved"
                                        @if( old('status') == 'approved' )
                                            checked
                                        @else
                                            {{ ($job->status == 'approved') ? 'checked' : ''  }}
                                        @endif
                                    >
                                    <label class="form-check-label" for="approved">Approved</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="pending" value="pending"
                                        @if( old('status') == 'pending' )
                                            checked
                                        @else
                                            {{ ($job->status == 'pending') ? 'checked' : ''  }}
                                        @endif
                                    >
                                    <label class="form-check-label" for="pending">Pending</label>
                                </div>
                                <div class="form-check disabled">
                                    <input class="form-check-input" type="radio" name="status" id="spam" value="spam"
                                        @if( old('status') == 'spam' )
                                            checked
                                        @else
                                            {{ ($job->status == 'spam') ? 'checked' : ''  }}
                                        @endif
                                    >
                                    <label class="form-check-label" for="spam">Spam</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Publish
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
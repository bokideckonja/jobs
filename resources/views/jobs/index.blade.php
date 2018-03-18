@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <a href="{{ url('/jobs/create') }}" class="btn btn-primary">Post a job</a>
            <hr>
        </div>

        <div class="col-md-10 col-md-offset-1">
            @include('partials.alert')
            <!-- <a href="{{ url('/jobs/create') }}" class="btn btn-primary pull-right mb-1">Post a job</a> -->

            <div class="panel panel-default">
                <div class="panel-heading">Job list</div>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            @auth
                            <th scope="col">Status</th>
                            @endauth
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobs as $job)
                        <tr>
                            <th scope="row">{{ $job->id }}</th>
                            <td>{{ $job->title }}</td>
                            @auth
                            <td>{{ $job->status }}</td>
                            @endauth
                            
                            <td>
                                <a href="{{ url('/jobs/'.$job->id) }}">view</a>&nbsp;
                                @auth
                                <a href="{{ url('/jobs/'.$job->id.'/edit') }}">edit</a>&nbsp;
                                <a href="" onclick="event.preventDefault(); 
                                    document.getElementById('delete-job-{{$job->id}}').submit();">delete</a>
                                <form action="{{ url('/jobs/'.$job->id) }}" id="delete-job-{{$job->id}}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form>
                                @endauth
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $jobs->links() }}
        </div>
    </div>
</div>
@endsection
<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Http\Request;
use App\Events\FirstJobPosted;

class JobsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['create', 'store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Display all jobs
        $jobs = Job::all();

        return view('jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate request
        $this->validate($request, [
            'email' => 'required|email',
            'title' => 'required|max:255',
            'description' => 'required|min:5',
        ]);

        // Check if it is first job post with that email
        $first = true;
        if(Job::where('email', $request->email)->exists()){
            // We check if tere is job in database with that email
            // Optionaly, we could also check if it is first approved job
            $first = false;
        }

        // Create Job
        $job = new Job;
        $job->email = $request->email;
        $job->title = $request->title;
        $job->description = $request->description;
        $job->status = $first ? 'pending' : 'approved';
        $job->moderate_token = $first ? str_random(35) : null;
        try{
            $job->save();
        }catch(\Exception $e){
            session()->flash('flash-message', 'Error saving job to database.');
            session()->flasj('flash-level', 'danger');

            return back();
        }



        // If this is first job post for given email, dispatch event
        if($first){
            event(new FirstJobPosted($job));
        }

        // Return back
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        return view('jobs.edit', compact('job'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        // Validate request
        $this->validate($request, [
            'email' => 'required|email',
            'title' => 'required|max:255',
            'description' => 'required|min:5',
            'status' => 'required|in:approved,pending,spam'
        ]);

        // Update Job
        $job->email = $request->email;
        $job->title = $request->title;
        $job->description = $request->description;
        $job->status = $request->status;
        // If moderator has changed the status, 
        // there is no need for token to exist anymore
        if($job->status !== $request->status){
            $job->moderate_token = null;
        }

        // Try and save to DB.
        try{
            $job->save();
        }catch(\Exception $e){
            session()->flash('flash-message', 'Error saving job to database.');
            session()->flasj('flash-level', 'danger');

            return back();
        }

        // Flash success message and return back
        session()->flash('flash-message', 'Job updated successfully.');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        $job->delete();
        return back();
    }
}

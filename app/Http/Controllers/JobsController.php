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
        $this->middleware('auth', ['except' => ['index', 'show', 'create', 'store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // If logged in display all jobs, if not only approved
        if(auth()->check()){
            $jobs = Job::paginate();
        }else{
            $jobs = Job::approved()->paginate();
        }

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

        // Flash success message
        session()->flash('flash-message', 'Job posted successfully.');

        // Return back
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        // Prevent not authorised users to see any job that is not approved
        if($job->status == 'approved' || auth()->check()){
            return view('jobs.show', compact('job'));
        }

        abort(404);
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
     * Approve the job post via moderate_token
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function tokenApprove($token)
    {
        $job = Job::where('moderate_token',$token)->firstOrFail();

        $job->moderate_token = null;
        $job->status = 'approved';

        // Try and save to DB.
        try{
            $job->save();
            // Flash success message
            session()->flash('flash-message', 'Job approved successfully.');
        }catch(\Exception $e){
            // Flash error message
            session()->flash('flash-message', 'DB error approving job.');
            session()->flasj('flash-level', 'danger');
        }

        return redirect('/');
    }

    /**
     * Send job post to spam via moderate_token
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function tokenSpam($token)
    {
        $job = Job::where('moderate_token',$token)->firstOrFail();

        $job->moderate_token = null;
        $job->status = 'spam';

        // Try and save to DB.
        try{
            $job->save();
            // Flash success message
            session()->flash('flash-message', 'Job sent to spam successfully.');
        }catch(\Exception $e){
            // Flash error message
            session()->flash('flash-message', 'DB error sending job to spam.');
            session()->flasj('flash-level', 'danger');
        }

        return redirect('/');
    }

    /**
     * Delete job from DB.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        try{
            $job->delete();
            // Flash success message
            session()->flash('flash-message', 'Job deleted successfully.');
        }catch(\Exception $e){
            // Flash error message
            session()->flash('flash-message', 'DB error deleting job.');
            session()->flasj('flash-level', 'danger');
        }

        return redirect('/');
    }
}

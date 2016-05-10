<?php

namespace App\Http\Controllers;

use DB;
use Auth;

use Request;

use Input;
use App\Trips;
use App\Assignments;
use App\Http\Requests;

	function Auth(){
	  if (Auth::guest()) {
	    echo '<script>window.location.href = "/login?error=login";</script>';
	  }
	  elseif (Auth::user()->role == '2') {
	    echo '<script>window.location.href = "/home";</script>';
	  }
	  elseif (Auth::user()->role == '3') {
	    echo '<script>window.location.href = "/home";</script>';
	  }
	}


    function isStudent(){
      if (Auth::user()->role != 'inactive') {
         echo '<script>window.location.href = "/login?error=login";</script>';
      }
    }

    function isLoggedIn(){
      if (Auth::guest()) {
        echo '<script>window.location.href = "/login?error=login";</script>';
      }
    }

class TripsController extends Controller
{
   public function index()
   {
   		isLoggedIn();
   		Auth();
		$trips = DB::table('trips')->get();
		return view('trips.index',compact('trips'));
	} 	
	public function wait(){
		isLoggedIn();
		Auth();
		$trips = Request::all();
  		$newtrip = Trips::create($trips);
  		$newtripid = $newtrip->id;
		return view('trips.wait', compact('newtripid'));
	}
  	public function create($tripid)
  	{
      isLoggedIn();
      Auth();
      $trips=Trips::find($tripid);
	  $assignments = DB::table('assignments')->get();

	  $assignmentids = $trips->assignmentids;
	  if ($assignmentids == ""){
	  	$assignments = "";
	  }
	  else{
	  	$assignments = DB::select( DB::raw("SELECT * FROM assignments WHERE id IN($trips->assignmentids)") );
	  }
	  return view('trips.create',compact('assignments','tripid'));
	}
  	/**
  	* Store a newly created resource in storage.
  	*
  	* @return Response
  	*/
  	public function store($tripid)
  	{
  		isLoggedIn();
  		Auth();
  		$trip = Request::all($tripid);

		DB::table('trips')->where('id', $tripid)->update([
			'tripname' => $trip['tripname'],
	    ]);
    	return redirect('/home/tochten'); 
	}
	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function show($tripid)
	{	
	  isLoggedIn();
	  Auth();
	  $trip = Trips::find($tripid);
	 // return $trip;
	  $assignments = DB::table('assignments')->get();

	  $assignments = DB::select( DB::raw("SELECT * FROM assignments WHERE id IN($trip->assignmentids)") );

	  return view('trips.show',compact('trip','assignments'));
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function edit($tripid)
	{
	  isLoggedIn();
	  Auth();
	  $trip = Trips::find($tripid);
	 // return $trip;
	  $assignments = DB::table('assignments')->get();

	  $assignments = DB::select( DB::raw("SELECT * FROM assignments WHERE id IN($trip->assignmentids)") );

	  return view('trips.edit',compact('trip','assignments','tripid'));
	}
	/**
	* Update the specified resource in storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function update($tripid)
	{
	  isLoggedIn();
	  Auth();
	  $trip = Request::all($tripid);

		DB::table('trips')->where('id', $tripid)->update([
			'tripname' => $trip['tripname'],
	    ]);
    	return redirect('/home/tochten'); 
	}
	
	/**
	* Remove the specified resource from storage.
    *
	* @param  int  $id
	* @return Response
	*/
	public function destroy($id)
	{
	  isLoggedIn();
	  Auth();
	  Trips::find($id)->delete();
	  return redirect('/home/tochten');
	}
}

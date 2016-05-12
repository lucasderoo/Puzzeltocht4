<?php

namespace App\Http\Controllers;

use DB;
use Auth;

use Request;

use Input;
use App\Trips;
use App\Assignments;
use App\Tripsassignments;
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
		$assignments = DB::table('tripsassignments')->pluck('tripids');
		return view('trips.index', compact('trips','assignments'));
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

	  $name = DB::table('tripsassignments')->where('tripids', $tripid)->pluck('assignmentsids');

	  $ids = implode(',', $name);

	  if ($ids == ""){
	  	$assignments = "";
	  }
	  else{
	  	$assignments = DB::select( DB::raw("SELECT * FROM assignments WHERE id IN($ids)") );
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
  		$assignments = DB::table('tripsassignments')->where('tripids', $tripid)->pluck('tripids');

		$assignments = array_count_values($assignments);

		$assignments = (array_values($assignments));

		$assignments =  implode("",$assignments);
		DB::table('trips')->where('id', $tripid)->update([
			'tripname' => $trip['tripname'],
			'assignments' => $assignments,
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

	  $trips = Trips::find($tripid);
	  $tripname = $trips->tripname;

	  $assignments = DB::table('assignments')->get();

	  $name = DB::table('tripsassignments')->where('tripids', $tripid)->pluck('assignmentsids');

	  $ids = implode(',', $name);

	  $assignments = DB::select( DB::raw("SELECT * FROM assignments WHERE id IN($ids)") );

	  return view('trips.show',compact('assignments','tripid','tripname'));
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
	  $trips=Trips::find($tripid);
	  $tripname = $trips->tripname;

	  $assignments = DB::table('assignments')->get();

	  $name = DB::table('tripsassignments')->where('tripids', $tripid)->pluck('assignmentsids');

	  $ids = implode(',', $name);

	  $assignments = DB::select( DB::raw("SELECT * FROM assignments WHERE id IN($ids)") );
	  
	  return view('trips.edit',compact('assignments','tripid','tripname'));
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
	  $assignments = DB::select( DB::raw("DELETE FROM tripsassignments WHERE tripids = $id") );
	  return redirect('/home/tochten');
	}
}

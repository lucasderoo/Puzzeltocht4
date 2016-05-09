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
      $trip=Trips::find($tripid);
	  $assignments = DB::table('assignments')->get();
	  foreach ($assignments as $assignment){
	  	if(strpos($assignment->tripids, $tripid) !== false) {
		    $assignmentids[] = $assignment;
		    //return $assignment->tripids;
		}
		else{
			$assignmentids = "";
		}
	  }

	  //return view('trips.show',compact('trip','assignments'));

	  //$assignmentids = "";
	  return view('trips.create',compact('assignmentids','tripid'));
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
  		/*$trip = Request::all($tripid);

  		$assignments = DB::table('assignments')->where('tripids', $tripid)->get();

  		$count = count($assignments);
  		if($count < "1"){
  			 "Te weinig opdrachten om een tocht te creëren";
  		}
  		else{
			foreach($assignments as $assignment){
				$names[] = $assignment->id;
			}
			$assignmentids = count($names);
			DB::table('trips')->where('id', $tripid)->update([
  				'tripname' => $trip['tripname'],
            	'assignmentids' => $assignmentids,
        	]);
  		}
  		return redirect('/home/tochten');*/
  		$trip = Request::all($tripid);

	  	$assignments = DB::table('assignments')->get();

		
		foreach ($assignments as $assignment) {
	  		if (strpos($assignment->tripids, $tripid) !== false) {
		    $data[] = $assignment->id;
		}
		}
		//$count = count($data);
		//return $data;
		$data = implode(',', $data);
		//return $data;
		//$array = json_decode(json_encode($assignmentids), True);
	    //return $count;
		   //return $array;
		    //$count = count($assignmentids);
			DB::table('trips')->where('id', $tripid)->update([
				'tripname' => $trip['tripname'],
	        	'assignmentids' => $data,
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

	  $assignments = DB::table('assignments')->get();

		
		foreach ($assignments as $assignment) {
	  		if (strpos($assignment->tripids, $tripid) !== false) {
		    $assignmentids[] = $assignment;
			}
			else {
				$assignmentids = "";
			}
		}
		$count = count($assignmentids);
		DB::table('trips')->where('id', $tripid)->update([
			'tripname' => $trip['tripname'],
        	'assignmentids' => $count,
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

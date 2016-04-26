<?php

namespace App\Http\Controllers;

use DB;

use Request;

use Input;
use App\Trips;
use App\Assignments;
use App\Http\Requests;

class TripsController extends Controller
{
   public function index()
    {
		$trips = DB::table('trips')->get();
		return view('trips.index',compact('trips'));
	}
  	public function create()
  	{
  		//$trips = Request::all();
  		//$newtrip = Trips::create($trips);
  		//$newtripid = $newtrip->id;
  		//return $newtrip;
  		$assignments = DB::table('assignments')->get();
  		//$assignments = DB::table('assignments')->where('tripids' ,$newtripid)->get();
  		return view('trips.create',compact('trips', 'assignments'));

  	}
  	/**
  	* Store a newly created resource in storage.
  	*
  	* @return Response
  	*/
  	public function store()
  	{
	   	$trips=Request::all();
    	Trips::create($trips);
    	return $trips;
	}
	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function show($id)
	{
	  $trips=Trips::find($id);
	  return view('trips.show',compact('trips'));
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function edit($id)
	{
	  $trips=Trips::find($id);
	  $assignments=Assignments::find($id);
	  return view('trips.edit',compact('trips', 'assignments'));
	}
	/**
	* Update the specified resource in storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function update($id)
	{
	  $input=Request::all();
	  $trips=Trips::find($id);
	  //$assignment=Assignments::find($id);
	  //$assignment->update($input);
	  $trips->update($input);
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
	  Trips::find($id)->delete();
	  return redirect('/home/tochten');
	}
}

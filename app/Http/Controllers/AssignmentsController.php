<?php

namespace App\Http\Controllers;

use DB;

use Request;

use App\Assignments;
use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;

class AssignmentsController extends Controller
{
	public function index()
	{
		$assignments = DB::table('assignments')->get();
		return view('assignments.index',compact('assignments'));
	}
  public function create()
  {
    return view('assignments.create');
  }
  /**
  * Store a newly created resource in storage.
  *
  * @return Response
  */
  public function store()
  {
   	$assignments=Request::all();
    Assignments::create($assignments);
    return redirect('/home/tochten/create');
    
  }
  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return Response
  */
  public function show($id)
  {
    $assignment=Assignments::find($id);
    $correct_answer = $assignment->correct_answer;
    return view('assignments.show',compact('assignment', 'correct_answer'));

  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return Response
  */
  public function edit($id)
  {
   	$assignments = Assignments::find($id);
    return view('assignments.edit',compact('assignments'));
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
    $assignments=Assignments::find($id);
    $assignments->update($input);
    return redirect('/home/tochten/create');	
  }
  public function delete($id)
  {
    $assignment = Assignments::find($id);
    return view('assignments.delete',compact('assignment'));
  }

  public function destroy($id)
  {
    Assignments::find($id)->delete();
    return redirect('/home/tochten/create');
  }

  /*public function active($id)
  {
    $assignments = Assignments::find($id);
    if($assignments->active == "Y"){
      DB::table('assignments')->where('id', $id)->update(['active' => "N"]); 
    }
    else{
      DB::table('assignments')->where('id', $id)->update(['active' => "Y"]);
    }
    return redirect('/home/tochten/create');
  }*/
  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return Response
  */
}
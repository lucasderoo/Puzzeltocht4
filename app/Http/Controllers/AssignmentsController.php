<?php

namespace App\Http\Controllers;

use DB;

use Request;
use Auth;
use App\Assignments;
use App\Http\Requests;
use App\Trips;

use Illuminate\Support\Facades\Redirect;

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
class AssignmentsController extends Controller
{
	public function index()
	{
    isLoggedIn();
    Auth();
		$assignments = DB::table('assignments')->get();
		return view('assignments.index',compact('assignments'));
	}
  public function create($tripid)
  {
    isLoggedIn();
    Auth();
    $prevurl = $_SERVER['HTTP_REFERER'];

    if($prevurl == "http://puzzeltocht.dev/home/tochten/create/".$tripid){
        $prevurl = "create";
    }
    elseif($prevurl == "http://puzzeltocht.dev/home/tochten/edit/".$tripid){
        $prevurl = "edit";
    }
    return view('assignments.create',compact('tripid','prevurl'));
  }
  /**
  * Store a newly created resource in storage.
  *
  * @return Response
  */
  public function store($tripid, $prevurl)
  {
    isLoggedIn();
    Auth();
    $assignments=Request::all();
    $assignments = Assignments::create([
        'type' => $assignments['type'],
        'title' => $assignments['title'],
        'question' => $assignments['question'],
        'answer_1' => $assignments['answer_1'],
        'answer_2' => $assignments['answer_2'],
        'answer_3' => $assignments['answer_3'],
        'correct_answer' => $assignments['correct_answer'],
        'location' => $assignments['location'],
    ]);
    $trips = DB::table('trips')->where('id', $tripid)->get();
    foreach($trips as $trip){
      $assignmentids = $trip->assignmentids;
    }
    $assignmentidss = $assignments->id;
    foreach($trips as $trip){
    if($trip->assignmentids == ""){
      DB::table('trips')->where('id', $tripid)->update([
        'assignmentids' => $assignmentidss,
      ]);
    }
    else{
      DB::table('trips')->where('id', $tripid)->update([
        'assignmentids' => $assignmentids .',' . $assignmentidss,
      ]);
    }
    }
    header('Location: http://puzzeltocht.dev/home/tochten/'.$prevurl.'/' .$tripid);
  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return Response
  */
  }
  public function show($id, $tripid)
  {
    isLoggedIn();
    Auth();
    $assignment=Assignments::find($id);
    $correct_answer = $assignment->correct_answer;
    return view('assignments.show',compact('assignment','correct_answer', 'tripid'));

  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return Response
  */
  public function edit($id, $tripid)
  {
    isLoggedIn();
    Auth();
    $prevurl = $_SERVER['HTTP_REFERER'];

    if($prevurl == "http://puzzeltocht.dev/home/tochten/create/".$tripid){
        $prevurl = "create";
    }
    elseif($prevurl == "http://puzzeltocht.dev/home/tochten/edit/".$tripid){
        $prevurl = "edit";
    }
   	$assignments = Assignments::find($id);
    return view('assignments.edit',compact('assignments','id','tripid','prevurl'));
  }
  /**
  * Update the specified resource in storage.
  *
  * @param  int  $id
  * @return Response
  */
  public function update($id, $tripid, $prevurl)
  {
    isLoggedIn();
    Auth();
    $input=Request::all();
    $assignments=Assignments::find($id);
    $assignments->update($input);
    header('Location: http://puzzeltocht.dev/home/tochten/'.$prevurl.'/' .$tripid);	
  }
  public function delete($id, $tripid)
  {
    isLoggedIn();
    Auth();
    $prevurl = $_SERVER['HTTP_REFERER'];
    if($prevurl == "http://puzzeltocht.dev/home/tochten/create/".$tripid){
        $prevurl = "create";
    }
    elseif($prevurl == "http://puzzeltocht.dev/home/tochten/edit/".$tripid){
        $prevurl = "edit";
    }
    $assignment = Assignments::find($id);
    return view('assignments.delete',compact('assignment','tripid','id','prevurl'));
  }

  public function destroy($id, $tripid, $prevurl)
  {
    isLoggedIn();
    Auth();
    /*$assignment = Assignments::find($id);
    $trips = DB::table('trips')->where('id', $tripid)->get();
    foreach($trips as $trip){
      $assignmentids[] = $trip->assignmentids;
    }
    //return $assignmentids;
    $str = implode(',', $assignmentids);
    //return $str;
   // return $assignment->id;
    $assignmentid = $assignment->id;
    $ID = (string)$assignmentid;
    //return $assignmentid;
    //return $assignmentid;
    //if (strpos($str, )!== false){
    //  return "YESSS";
    //}
    //return $assignmentid;
    //if (stripos($str, '219') !== false) {
    //  echo "True";
    //}

    if (strpos($str, $ID) === FALSE) {
       return "YESS";
    }
    else{

    }
   // else{
   //   return "wallah";
   // }*/

    //header('Location: http://puzzeltocht.dev/home/tochten/'.$prevurl.'/' .$tripid); 



  }

  public function active($id)
  {
    isLoggedIn();
    Auth();
    $assignments = Assignments::find($id);
    if($assignments->active == "Y"){
      DB::table('assignments')->where('id', $id)->update(['active' => "N"]); 
    }
    else{
      DB::table('assignments')->where('id', $id)->update(['active' => "Y"]);
    }
    return redirect()->back();  
  }
  public function connect($tripid){
    $assignments = DB::table('assignments')->get();
    $prevurl = $_SERVER['HTTP_REFERER'];
    if($prevurl == "http://puzzeltocht.dev/home/tochten/create/".$tripid){
        $prevurl = "create";
    }
    elseif($prevurl == "http://puzzeltocht.dev/home/tochten/edit/".$tripid){
        $prevurl = "edit";
    }
    return view('assignments.connect',compact('assignments','tripid','prevurl'));
  }
  public function connectassignments($tripid, $prevurl)
  {
    isLoggedIn();
    Auth();
    $trip=Trips::find($tripid);
    $assignmentids = $_POST['connect'];
    $assignmentidss = implode(',',$assignmentids);
    $assignments = DB::table('assignments')->get();
    $assignmentids = $trip->assignmentids;
    if($assignmentids == ""){
      DB::table('trips')->where('id', $tripid)->update([
        'assignmentids' => $assignmentidss,
      ]);
    }
    else{
      DB::table('trips')->where('id', $tripid)->update([
        'assignmentids' => $assignmentids .',' . $assignmentidss,
      ]);
    }
    header('Location: http://puzzeltocht.dev/home/tochten/'.$prevurl.'/' .$tripid);
  }
  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return Response
  */
}
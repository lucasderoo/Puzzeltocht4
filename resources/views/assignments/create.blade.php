@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <a href="{{url('/home/opdrachten')}}">Terug</a>
                    <h1>Nieuwe opdracht</h1>
                    <div>
                      {!! Form::open(['method' => 'post', 'url' => '/home/opdrachten/store/' . $tripid .'/'.$prevurl]) !!}
                    </div>
                    <div>
                        {!! Form::label('type', 'Type:') !!}
                        {!! Form::select('type', [
                           'question' => 'Vraag',
                           'Type2' => 'Type2',
                           'Type3' => 'Type3',
                           'Type4' => 'Type4']
                        ) !!}<br>
                        {!! Form::label('title', 'Titel:') !!}
                        {!! Form::text('title', null, array('question' => '','maxlength' => 100 )) !!}<br>
                        {!! Form::label('question', 'Vraag:') !!}
                        {!! Form::text('question', null, array('question' => '','maxlength' => 100 )) !!}<br>
                        <div style="float: left;">
                        {!! Form::label('answer_1', 'Antwoord 1:') !!}
                        {!! Form::text('answer_1', null, array('question' => '','maxlength' => 100 )) !!}<br>
                        {!! Form::label('answer_2', 'Antwoord 2:') !!}
                        {!! Form::text('answer_2', null, array('question' => '','maxlength' => 100 )) !!}<br>
                        {!! Form::label('answer_3', 'Antwoord 3:') !!}
                        {!! Form::text('answer_3', null, array('question' => '','maxlength' => 100 )) !!}<br>
                        {!! Form::label ('location' , 'Locatie:') !!}
                        {!! Form::text('location', null) !!}
                        </div>
                        <div style="float :left; width: 20px;">
                        {!! Form::radio('correct_answer','answer_1',true ) !!}
                        {!! Form::radio('correct_answer','answer_2') !!}
                        {!! Form::radio('correct_answer','answer_3') !!}
                        </div>
                    </div>
                    
                    <div>
                        {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

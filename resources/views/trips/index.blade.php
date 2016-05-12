
@extends('layouts.app')
<style>
a{
    text-decoration: none !important;
}
.top{
    width: 100%;
    height: 100px;
    border-bottom: 1px solid black;
}
.TopInput{
    margin-left: auto;
    margin-right: auto;
    width: 235px;
}
.top h1{
    text-align: center;
}
.midtop{
    width: 100%;
    border-bottom: 1px solid black;
}
.midtopbuttons{
    width: 800px;
    margin: 10px auto;
}
.midtop a{
    display: inline-block;
}
.midtop a{
    margin-left: 31px;
    margin-right: 31px;
}
.DataTR{
    height: 70px;
}
th{
    width: 120px;
}
td{
    text-align: center;
    padding: 10px !important;
}
th{
    text-align: center !important;
}
.clickable-row:hover{
    background-color: white;
    opacity: 0.8;
    cursor: pointer;
}
.no-data{
    text-align: center;
}
table{
    margin: 10 auto;
}
.mida{
    margin: 5 auto;
    display: block !important;
}
}
</style>
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="top">
                        <h1>Tochten</h1>
                    </div>
                    <div class="midmid">
                    <p><a class="mida btn btn-success" href="{{url('/home/tochten/wait')}}">Niewe tocht</a></p>
                    <?php if ($trips == []) : ?>
                        <div class="no-data">
                                <h1>No data found!</h1>
                            </div>
                    <?php else : ?>
                    <table class="table-striped">
                            <tr>
                                <th>Tripsnaam</th>
                                <th>Aantal opdrachten</th>
                                <th>Aanpassen</th>
                                <th>Verwijderen</th>
                            </tr>
                        <script>
                        jQuery(document).ready(function($) {
                        $(".clickable-row").click(function() {
                            window.document.location = $(this).data("href");
                        });
                        });
                        </script>
                            <tdbody>
                            @foreach ($trips as $trip)
                            <tr class='clickable-row DataTR' data-href="/home/tochten/show/{{$trip->id}}">
                                <td>{{ $trip->tripname }}</td>
                                <td>{{ $trip->assignments }}</td>
                                <td><a class="btn btn-info" href="/home/tochten/edit/{{$trip->id}}">edit</a></td>
                                <td>
                                {!! Form::open(['method' => 'DELETE', 'route' => ['home.tochten.destroy', $trip->id]]) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!}
                                </td>
                            </tr>
                            @endforeach
                            </tdbody>
                    </table>
                    <?php endif; ?>
                    </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
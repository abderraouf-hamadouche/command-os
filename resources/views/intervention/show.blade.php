@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 pt-2">
                <a href="../intervention" class="btn btn-outline-primary btn-sm">Go back</a>
                <h1 class="display-one">La Procésure est : {{ ucfirst($intervention->intervention_name) }}</h1>
                <p>{!! $intervention->id !!}</p>
                <h1 class="display-one">Liste des Commandes : </h1>
                
                <p>{!! $intervention->intervention_name !!}   :   {!! $intervention->description !!}</p> 
                
               
                

                <hr>
                <a href="/intervention/{{$intervention}}/edit" class="btn btn-outline-primary">Edit Post</a>
                <br><br>
                <form id="delete-frm" class="" action="" method="POST">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-danger">Delete Post</button>
                </form>
            </div>
        </div>
    </div>
@endsection
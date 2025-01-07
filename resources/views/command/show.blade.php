@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 pt-2">
                <a href="../command" class="btn btn-outline-primary btn-sm">Go back</a>
                <h1 class="display-one">La Commande est : {{ ucfirst($command->first()->command) }}</h1>
                <p>{!! $command->first()->description !!}</p>
                <h3 class="display-one"> Référencé dans    :</h3>
                <p> {!! implode(' ', is_array($command->first()->tags) ? $command->first()->tags : [$command->first()->tags]) !!}</p>
                <h1 class="display-one">Liste des parametres : </h1>
                @foreach ($command as $command)
                <p>{!! e($command->param) !!}   :   {!! e($command->pdescription) !!}   </p> 
                @endforeach
                <hr>
                <a href=".//edit" class="btn btn-outline-primary">Edit Post</a>
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
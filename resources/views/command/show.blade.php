@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 pt-2">
                <a href="../command" class="btn btn-outline-primary btn-sm">Go back</a>
                <h1 class="display-one">La Commande est : {{ ucfirst($command->first()->command) }}</h1>
                <p>{!! $command->first()->description !!}</p>
                <h3 class="display-one"> Arguments  :</h3>
                @foreach ($command as $cmd)
                @foreach ($cmd->argumentPositions as $argumentPosition) 
                    <p>  Argument:  {!!$argumentPosition->argument->name!!} Description : {!!$argumentPosition->argument->description!!} Position:  {!!$argumentPosition->position!!}</p>
                @endforeach
                @endforeach
                <h3 class="display-one"> Référencé dans    :</h3>
                <p> {!! implode(' ', is_array($command->first()->tags) ? $command->first()->tags : [$command->first()->tags]) !!}</p>
                <h1 class="display-one">Liste des parametres : </h1>
                
                @foreach ($command as $cmd)
                <p>{!!  e($cmd->param) !!}   :   {!! e($cmd->pdescription) !!}   <a href="./{!!$cmd->id!!}/edit" class="btn btn-outline-primary">Edit Post</a></p> 
                @endforeach
                <pre>  @json($command)  </pre>
                
                <hr>
                <a href="./{!!$command->first()->id!!}/edit" class="btn btn-outline-primary">Edit Post</a>
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
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 pt-2">
                <a href="../intervention" class="btn btn-outline-primary btn-sm">Go back</a>
                <h1 class="display-one">{{ ucfirst($intervention->intervention) }} :</h1>
                <h2>Introduction</h2>
                <p> {!! $intervention->description !!}</p>
                <h1 class="display-one">Etapes à suivre : </h1>
                
                @foreach ($intervention->processSteps as $step)
                <h4>Etape {!! $step->step_order !!}   :    </h4> 
                <p>  {!! $step->command->command !!}  </p>
                <p>  {!! $step->comment !!}  </p>
                @endforeach
                
                

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
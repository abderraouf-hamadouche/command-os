@extends('layouts.app')

@section('content')

<div class="container">
        <div class="row">
            <div class="col-12 pt-2">
                <a href="../" class="btn btn-outline-primary btn-sm">Go back</a>
    <h1>Commandes associées au tag : {{ $tag }}</h1>

    @if($commands->isEmpty())
        <p class="text-warning">Aucune commande trouvée pour ce tag.</p>
    @else
    <table class="col-8">    
                <tr>        <td width="120px">Commande</td>    <td>Description</td>
    </tr>
                @forelse($commands as $command)
                <tr>
        <td width="120px"><a href="./command/{{ $command->id }}">{{ ucfirst($command->command) }}</a></td> 
        
        <td>{{ ucfirst($command->pdescription) }}</td>
    </tr>
                @empty
                    <p class="text-warning">No blog Posts available</p>
                @endforelse
                </table>
    @endif

    </div>
        </div>
    </div>
@endsection



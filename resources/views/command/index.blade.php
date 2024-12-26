@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 pt-2">
                 <div class="row">
                    <div class="col-8">
                        <h1 class="display-one"><a href="./" >Our Blog!</a></h1>
                        <p>Enjoy reading our posts. Click on a post to read!</p>
                    </div>
                    <div class="col-4">
                        <p>Create new Command</p>
                        <a href="./command/create/command" class="btn btn-primary btn-sm">Add Command</a>
                    </div>

                       
                <table class="col-8">    
                <tr>        <td width="120px">Commande</td>  <td width="180px">Parametre</td>   <td>Description</td>
    </tr>
                @forelse($command->sortByDesc('id') as $command)
                <tr>
        <td width="120px"><a href="./command/{{ $command->id }}">{{ ucfirst($command->command) }}</a></td> 
        <td width="180px">{{ $command->param }}</td>
        <td>{{ ucfirst($command->pdescription) }}</td>
    </tr>
                @empty
                    <p class="text-warning">No blog Posts available</p>
                @endforelse
                </table>
                <div class="col-4">
                        <p>Liste des tags</p>
                        @forelse($tags as $tag) 
                        <a href="./command/create/command" >{{ $tag }}</a>
                        @empty
                             <p class="text-warning">No Tags available</p>
                        @endforelse
                    </div>
                </div>     
            </div>
        </div>
    </div>
@endsection
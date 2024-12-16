@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 pt-2">
                 <div class="row">
                    <div class="col-8">
                        <h1 class="display-one"><a href="./" >Our Blog!</a></h1>
                        <p>Enjoy reading our Procédures. Click on a Procédure to read IT!</p>
                    </div>
                    <div class="col-4">
                        <p>Create new Procédure</p>
                        <a href="./intervention/create/intervention" class="btn btn-primary btn-sm">Ajout Procédure</a>
                    </div>
                </div>                
                @forelse($interventions as $intervention)
                    @php
                        if ($intervention->order == 0) {
                    @endphp
                            <ul>
                                <li><a href="./intervention/{{ $intervention->id }}">{{ ucfirst($intervention->intervention_name) }} -- {{ ucfirst($intervention->description) }}</a></li>
                            </ul>
                    @php
                        }
                    @endphp
                @empty
                    <p class="text-warning">Nothing To see here.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
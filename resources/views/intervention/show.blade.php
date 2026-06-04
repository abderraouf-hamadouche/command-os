@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Intervention Details --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h1 class="card-title h3">{{ $intervention->titre }} </h1>
            <h2 class="card-subtitle mb-2 text-muted h6">{{ $intervention->probleme }}</h2>
            @if($intervention->description)
                <p class="card-text mt-3">{{ $intervention->description }}</p>
            @endif
        </div>
    </div>

    {{-- Steps Graph --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h3 class="h5 mb-0">Steps Graph</h3>
        </div>
        <div class="card-body">
            @if ($intervention->etapes->isEmpty())
                <div class="text-center p-3 text-muted">
                    <p>No steps defined yet. Use the form below to add the first step.</p>
                </div>
            @else
                <form action="{{ route('etape.updateGraph') }}" method="POST">
                    @csrf
                    @method('PUT') 
                    <input type="hidden" name="intervention_id" value="{{ $intervention->id }}">

                    <ul class="list-group list-group-flush" id="etapesList">
                        @foreach ($intervention->etapes as $etape)

                        <li class="list-group-item etape-item id="etape-{{ $etape->position }}">
                            <div class="row align-items-center">

                                <!-- MAIN CONTENT -->
                                <div class="col-md-11">

                                    <!-- Hidden position field -->
                                    <input type="hidden" name="etapes[{{ $etape->id }}][position]" class="position-input" value="{{ $etape->position }}">
                                    <div class="fw-bold step-label">Etape {{ $loop->iteration }}:</div>
                                    <div class="fw-bold">
                                        {{ $etape->command->name }}
                                        {{ $etape->parametre->nom }}
                                        {{ $etape->parametre->argument }}
                                        {{ $etape->parametre->suffix }}
                                    </div>

                                    <small class="text-muted">{{ $etape->note }}</small>

                                    <!-- BRANCH (next_step_ko) -->
                                    @if($etape->next_step_ko)
                                        <div class="d-flex align-items-center mt-2">
                                            <div class="border rounded px-2 py-1 bg-light">
                                            @php  $nextEtape = $intervention->etapes->firstWhere('id', $etape->next_step_ko);
                                            @endphp
                                            En cas d'échec → Continuez avec l'étape :   {{ $nextEtape['position'] }}
                                            </div>
                                        </div>
                                    @endif

                                </div>

                        

                            </div>
                        </li>
                        @endforeach
                    </ul>
                    <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('intervention.edit', $intervention) }}" id="lulu" class="btn btn-primary">Editer</a>
                    </div>
                </form>
            @endif
        </div>
    </div>

 
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {


        const list = document.getElementById("etapesList");

        function updatePositions() {
        const items = list.querySelectorAll(".etape-item");

        items.forEach((item, index) => {
            // Update visible label
            const label = item.querySelector(".step-label");
            label.textContent = "Etape " + (index + 1) + ":";

            // Update displayed order number
            const orderNumber = item.querySelector(".order-number");
            orderNumber.textContent = index + 1;

            // Update hidden input value
            const positionInput = item.querySelector(".position-input");
            if (positionInput) {
                positionInput.value = index + 1;
            }
        });
    }

    // MOVE UP
    document.querySelectorAll(".move-up").forEach(button => {
        button.addEventListener("click", function () {
            const item = this.closest("li");
            const prev = item.previousElementSibling;

            if (prev) {
                list.insertBefore(item, prev);
                updatePositions();
            }
        });
    });


    

    // MOVE DOWN
    document.querySelectorAll(".move-down").forEach(button => {
        button.addEventListener("click", function () {
            const item = this.closest("li");
            const next = item.nextElementSibling;

            if (next) {
                list.insertBefore(next, item);
                updatePositions();
            }
        });
    });


    });
</script>
@endpush
@endsection

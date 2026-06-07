@extends('layouts.app')

@section('content')
    <div class="container py-4">

        {{-- Intervention Details --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h1 class="h4 mb-0">{{ $intervention->titre }}</h1>
                <a href="{{ route('intervention.index') }}" class="btn btn-light btn-sm">&larr; {{ __('Back to list') }}</a>
            </div>
            <div class="card-body">
                <h2 class="card-subtitle mb-2 text-muted h6">{{ __('Problem') }} : {{ $intervention->probleme }}</h2>
                @if($intervention->description)
                    <p class="card-text mt-3">{{ __('Description') }} : {{ $intervention->description }}</p>
                @endif
            </div>
        </div>

        {{-- Steps Graph --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h3 class="h5 mb-0">{{ __('Steps Graph') }}</h3>
            </div>
            <div class="card-body">
                @if ($intervention->etapes->isEmpty())
                    <div class="text-center p-3 text-muted">
                        <p>{{ __('No steps defined yet. Use the form below to add the first step.') }}</p>
                    </div>
                @else
                    <form action="{{ route('etape.updateGraph') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="intervention_id" value="{{ $intervention->id }}">

                        <ul class="list-group list-group-flush" id="etapesList">
                            @foreach ($intervention->etapes as $etape)

                                <li class="list-group-item etape-item">
                                    <div class="row align-items-center">

                                        <!-- MAIN CONTENT -->
                                        <div class="col-md-10">

                                            <!-- Hidden position field -->
                                            <input type="hidden" name="etapes[{{ $etape->id }}][position]" class="position-input"
                                                value="{{ $etape->position }}">

                                            <div class="fw-bold step-label">{{ __('Step') }} {{ $loop->iteration }}:</div>

                                            <div class="fw-bold">
                                                {{ $etape->command->name }}
                                                {{ $etape->parametre->nom }}
                                                {{ $etape->parametre->argument }}
                                                {{ $etape->parametre->suffix }}
                                            </div>

                                            <small class="text-muted">{{ $etape->note }}</small>
                                            <!-- BRANCH (next_step_ko) -->

                                            <input type="hidden" name="etapes[{{ $etape->id }}][next_step_ko]"
                                                class="next-step-ko-input" value="{{ $etape->next_step_ko }}">

                                            <!-- Fail next step selection -->

                                            <select class="form-select w-auto form-select-sm mt-2 ko-select"
                                                style="{{ $etape->next_step_ko ? 'display: block;' : 'display: none;' }}">
                                                <option value="">{{ __('-- Choose step --') }}</option>
                                                @foreach($intervention->etapes as $e)
                                                    <option value="{{ $e->id }}" {{ $etape->next_step_ko == $e->id ? 'selected' : '' }}>
                                                        {{ __('Step') }} {{ $e->position }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>



                                        <!-- ACTION BUTTONS -->
                                        <div class="col-md-2 text-end btn-group" role="group">
                                            <button type="button" class="btn btn-outline-secondary btn-sm move-up">▲</button>
                                            <button class="btn btn-danger" title="Delete"><i class="bi bi-trash">X</i></button>
                                            {{-- <span class="mx-1 my-1 fw-bold order-number"> {{ $loop->iteration }} </span> --}}
                                            <button type="button"
                                                class="btn btn-sm toggle-ko {{ $etape->next_step_ko ? 'btn-warning' : 'btn-outline-warning' }}"
                                                data-id="{{ $etape->id }}">⚠️</button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm move-down">▼</button>
                                        </div>

                                    </div>
                                </li>

                            @endforeach
                        </ul>

                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary">{{ __('Save Graph') }}</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>

        {{-- Section 3: Add a New Step Form --}}
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0">{{ __('Add a New Step') }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('etape.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="intervention_id" value="{{ $intervention->id }}">

                    <div class="row g-3">
                        {{-- Command Selection --}}
                        <div class="col-md-6">
                            <label for="commande_id" class="form-label">{{ __('Command') }}</label>
                            <select class="form-select" id="commande_id" name="commande_id" required>
                                <option value="" disabled selected>{{ __('-- Select a Command --') }}</option>
                                @foreach ($commands as $command)
                                    <option value="{{ $command->id }}"
                                        data-parametres='{{ json_encode($command->parametres) }}'>{{ $command->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Parameter Selection (will be loaded with JS) --}}
                        <div class="col-md-6">
                            <label for="parametre_id" class="form-label">{{ __('Parameter (Optional)') }}</label>
                            <select class="form-select" id="parametre_id" name="parametre_id">
                                <option value="">{{ __('-- Select a Parameter --') }}</option>
                                {{-- Options will be loaded dynamically --}}
                            </select>
                        </div>

                        {{-- Note --}}
                        <div class="col-12">
                            <label for="note" class="form-label">{{ __('Note') }}</label>
                            <input type="text" class="form-control" id="note" name="note"
                                placeholder="e.g., Check the status of the container">
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">{{ __('Add Step') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const commandSelect = document.getElementById('commande_id');
                const parametreSelect = document.getElementById('parametre_id');

                commandSelect.addEventListener('change', function () {
                    // Clear existing options
                    parametreSelect.innerHTML = '<option value="">-- Select a Parameter --</option>';

                    // Get the selected command's parameters from the data attribute
                    const selectedOption = commandSelect.options[commandSelect.selectedIndex];
                    const parametres = JSON.parse(selectedOption.getAttribute('data-parametres'));

                    // Populate the parameter dropdown
                    if (parametres && parametres.length > 0) {
                        parametres.forEach(function (parametre) {
                            const option = new Option(parametre.nom, parametre.id);
                            parametreSelect.add(option);
                        });
                    }
                });

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

            // fail etape add or modify 
            document.querySelectorAll('.toggle-ko').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    let container = this.closest('.etape-item');
                    let select = container.querySelector('.ko-select');

                    if (select.style.display === 'none') {
                        select.style.display = 'block';
                    } else {
                        select.style.display = 'none';

                        // reset value if disabled
                        select.value = '';
                        container.querySelector('.next-step-ko-input').value = '';
                    }
                    // Toggle warning button color
                    this.classList.toggle('btn-warning');
                    this.classList.toggle('btn-outline-warning');
                });
            });

            // Sync select → hidden input
            document.querySelectorAll('.ko-select').forEach(function (select) {
                select.addEventListener('change', function () {
                    let container = this.closest('.etape-item');
                    let hidden = container.querySelector('.next-step-ko-input');

                    hidden.value = this.value;
                });
            });




        </script>
    @endpush
@endsection
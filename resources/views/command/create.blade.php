@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h1 class="h4 mb-0">Add a New Command</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('command.store') }}" method="POST">
                        @csrf

                        {{-- COMMAND DETAILS --}}
                        <fieldset class="mb-4">
                            <legend class="h5">Command Details</legend>
                            <div class="mb-3">
                                <label for="name" class="form-label">Command Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tags" class="form-label">Tags</label>
                                <input type="text" class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags" value="{{ old('tags') }}" aria-describedby="tagsHelp">
                                <div id="tagsHelp" class="form-text">Enter tags separated by spaces (e.g. git laravel file).</div>
                                @error('tags')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </fieldset>

                        <hr>

                        {{-- PARAMETERS --}}
                        <fieldset class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <legend class="h5 m-0">Parameters</legend>
                                <button type="button" id="add-parameter-btn" class="btn btn-sm btn-success">+ Add Parameter</button>
                            </div>

                            <div id="parameters-container">
                                {{-- Dynamic parameter rows will be inserted here --}}
                            </div>
                        </fieldset>

                        <div class="d-flex justify-content-end">
                             <a href="{{ route('command.index') }}" class="btn btn-secondary me-2">Cancel</a>
                             <button type="submit" class="btn btn-primary">Save Command</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Hidden template for a single parameter row --}}
<div id="parameter-template" style="display: none;">
    <div class="parameter-row border rounded p-3 mb-3">
        <div class="d-flex justify-content-end">
            <button type="button" class="btn-close remove-parameter-btn" aria-label="Remove"></button>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="parametres[__INDEX__][nom]" class="form-label">Parameter Name</label>
                <input type="text" class="form-control" name="parametres[__INDEX__][nom]">
            </div>
            <div class="col-md-6 mb-3">
                <label for="parametres[__INDEX__][type]" class="form-label">Type</label>
                <select class="form-select" name="parametres[__INDEX__][type]">
                    <option value="flag">Flag</option>
                    <option value="option">Option</option>
                    <option value="arg">Argument</option>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label for="parametres[__INDEX__][description]" class="form-label">Description</label>
            <input type="text" class="form-control" name="parametres[__INDEX__][description]">
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="parametres[__INDEX__][argument]" class="form-label">Argument</label>
                <input type="text" class="form-control" name="parametres[__INDEX__][argument]">
            </div>
            <div class="col-md-6 mb-3">
                <label for="parametres[__INDEX__][suffix]" class="form-label">Suffix</label>
                <input type="text" class="form-control" name="parametres[__INDEX__][suffix]">
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let parameterIndex = 0;
        const addParamBtn = document.getElementById('add-parameter-btn');
        const container = document.getElementById('parameters-container');
        const template = document.getElementById('parameter-template');

        addParamBtn.addEventListener('click', () => {
            const newRow = template.firstElementChild.cloneNode(true);
            
            // Update name attributes with the correct index
            newRow.querySelectorAll('[name^="parametres[__INDEX__]"]').forEach(input => {
                input.name = input.name.replace('__INDEX__', parameterIndex);
            });
            
            container.appendChild(newRow);
            parameterIndex++;
        });

        // Event delegation for remove buttons
        container.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-parameter-btn')) {
                e.target.closest('.parameter-row').remove();
            }
        });
    });
</script>
@endpush

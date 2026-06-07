@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h1 class="h4 mb-0">{{ __('Create New Intervention') }}</h1>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ __('Fill out the form below to define a new intervention procedure. You will add the specific steps in the next screen.') }}</p>
                    <hr>

                    {{-- This form will post to the 'intervention.store' route --}}
                    <form action="{{ route('intervention.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="titre" class="form-label">{{ __('Title') }}</label>
                            <input type="text"
                                   class="form-control @error('titre') is-invalid @enderror"
                                   id="titre"
                                   name="titre"
                                   value="{{ old('titre') }}"
                                   placeholder="Example: Container is not responding"
                                   required>
                            @error('titre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="probleme" class="form-label">{{ __('Problem Statement') }}</label>
                            <input type="text"
                                   class="form-control @error('probleme') is-invalid @enderror"
                                   id="probleme"
                                   name="probleme"
                                   value="{{ old('probleme') }}"
                                   placeholder="Example: The service is inaccessible via HTTP"
                                   required>
                            @error('probleme')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Detailed Description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="4"
                                      placeholder="(Optional) Provide more context about the problem">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('intervention.index') }}" class="btn btn-outline-secondary me-2">{{ __('Cancel') }}</a>
                            <button type="submit" class="btn btn-primary">{{ __('Save and Build Steps') }} &rarr;</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

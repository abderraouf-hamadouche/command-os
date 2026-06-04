@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h1 class="h4 mb-0">Edit Command</h1>
                    <a href="{{ route('command.index') }}" class="btn btn-outline-primary btn-sm">Go back</a>
                </div>
                <div class="card-body">
                    <p class="card-text">Fill and submit this form to edit the command.</p>
                    <hr>

                    {{-- The form points to the update route and uses the PUT method --}}
                    <form action="{{ route('command.update', $command->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="command-name" class="form-label">Command Name</label>
                            {{-- Using {{ }} for security and old() to retain value on validation error --}}
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="command-name"
                                   name="name"
                                   value="{{ old('name', $command->name) }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="command-description" class="form-label">Command Description</label>
                            {{-- The textarea is populated safely between the tags --}}
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="command-description"
                                      name="description"
                                      rows="4"
                                      required>{{ old('description', $command->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Update Command</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

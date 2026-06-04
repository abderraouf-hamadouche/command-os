@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h1 class="h4 mb-0">Edit Parameter for Command: <strong>{{ $command->name }}</strong></h1>
                </div>
                <div class="card-body">
                    <p class="card-text">Use this form to update the details of the parameter.</p>
                    <hr>

                    {{-- The form will point to the update route, which we will create next --}}
                    <form action="{{ route('parametre.update', ['command' => $command->id, 'parametre' => $parametre->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="param-nom" class="form-label">Parameter Name</label>
                            <input type="text"
                                   class="form-control @error('nom') is-invalid @enderror"
                                   id="param-nom"
                                   name="nom"
                                   value="{{ old('nom', $parametre->nom) }}"
                                   required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="param-type" class="form-label">Type</label>
                            <select class="form-select @error('type') is-invalid @enderror" id="param-type" name="type" required>
                                <option value="flag" {{ old('type', $parametre->type) == 'flag' ? 'selected' : '' }}>Flag</option>
                                <option value="option" {{ old('type', $parametre->type) == 'option' ? 'selected' : '' }}>Option</option>
                                <option value="arg" {{ old('type', $parametre->type) == 'arg' ? 'selected' : '' }}>Argument</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="param-description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="param-description"
                                      name="description"
                                      rows="3">{{ old('description', $parametre->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="param-argument" class="form-label">Argument</label>
                                <div class="d-flex gap-2">
                                    <input type="text"
                                        class="form-control @error('argument') is-invalid @enderror"
                                        id="param-argument"
                                        name="argument"
                                        value="{{ old('argument', $parametre->argument) }}"
                                        placeholder="ex: <container_name>">
                                    <button type="button" class="btn btn-outline-secondary insert-var-btn text-nowrap">
                                        &lt;&gt; Insérer variable
                                    </button>
                                </div>
                                <div class="form-text mt-1 text-muted" style="font-size: 0.8em;">Sélectionne un mot puis clique "Insérer variable" pour le wrapper en &lt;&gt;, ou clique sans sélection pour insérer &lt;variable&gt;</div>
                                @error('argument')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="param-suffix" class="form-label">Suffix</label>
                                <div class="d-flex gap-2">
                                    <input type="text"
                                        class="form-control @error('suffix') is-invalid @enderror"
                                        id="param-suffix"
                                        name="suffix"
                                        value="{{ old('suffix', $parametre->suffix) }}"
                                        placeholder="ex: --timestamps ou -C <pathtofile>">
                                    <button type="button" class="btn btn-outline-secondary insert-var-btn text-nowrap">
                                        &lt;&gt; Insérer variable
                                    </button>
                                </div>
                                <div class="form-text mt-1 text-muted" style="font-size: 0.8em;">Si le suffix contient lui-même une variable, insère-la ici directement</div>
                                @error('suffix')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('command.show', $command->id) }}" class="btn btn-outline-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Parameter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.insert-var-btn');
        if (btn) {
            e.preventDefault();
            const container = btn.closest('.d-flex');
            const input = container ? container.querySelector('input') : null;
            
            if (input) {
                const start = input.selectionStart;
                const end = input.selectionEnd;
                const val = input.value;
                
                if (start !== end) {
                    const selectedText = val.substring(start, end);
                    const before = val.substring(0, start);
                    const after = val.substring(end);
                    input.value = before + '<' + selectedText + '>' + after;
                    input.focus();
                    input.setSelectionRange(start, end + 2);
                } else {
                    const textToInsert = '<variable>';
                    const before = val.substring(0, start);
                    const after = val.substring(end);
                    input.value = before + textToInsert + after;
                    input.focus();
                    input.setSelectionRange(start, start + textToInsert.length);
                }
            }
        }
    });
</script>
@endpush

@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h1 class="h4 mb-0">{{ $command->name }}</h1>
                        <a href="{{ route('command.index') }}" class="btn btn-light btn-sm">&larr; Back to list</a>
                    </div>
                    <div class="card-body">
                        <p class="lead">{{ $command->description }}</p>

                        <hr>

                        {{-- TAGS --}}
                        <div class="mb-4">
                            <h5 class="font-weight-bold">Tags</h5>
                            @if($command->tags->isNotEmpty())
                                <div>
                                    @foreach($command->tags as $tag)
                                        <span class="badge bg-secondary">{{ $tag->nom }}</span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">No tags associated.</p>
                            @endif
                        </div>

                        <hr>

                        {{-- PARAMETRES --}}
                        <div>
                            <h5 class="font-weight-bold">Parameters</h5>
                            @if($command->parametres->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Position</th>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Description</th>
                                                <th>Argument</th>
                                                <th>Suffix</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($command->parametres as $param)
                                                <tr>
                                                    <td class="text-center">{{ $param->pivot->position }}</td>
                                                    <td><code>{{ $param->nom }}</code></td>
                                                    <td><span class="badge bg-info">{{ $param->type }}</span></td>
                                                    <td>{{ $param->description }}</td>
                                                    <td>{{ $param->argument ?? 'N/A' }}</td>
                                                    <td>{{ $param->suffix ?? 'N/A' }}</td>
                                                    <td class="text-center">
                                                        {{-- <div class="btn-group btn-group-sm" role="group"> --}}
                                                            <div class="d-flex gap-1">
                                                                <button type="button" class="btn btn-info copy-btn text-white"
                                                                    data-cmd="{{ $command->name }}" data-param="{{ $param->nom }}"
                                                                    data-argument="{{ $param->argument }}"
                                                                    data-suffix="{{ $param->suffix }}">Copy</button>
                                                                <a href="{{ route('parametre.edit', ['command' => $command->id, 'parametre' => $param->id]) }}"
                                                                    class="btn btn-warning d-flex align-items-center">Edit</a>
                                                                <form
                                                                    action="{{ route('parametre.destroy', ['command' => $command->id, 'parametre' => $param->id]) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Are you sure you want to delete this parameter?');"
                                                                    class="d-flex m-0 p-0">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger ">Delete</button>
                                                                </form>
                                                            </div>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">No parameters associated.</p>
                            @endif
                        </div>

                        <hr class="my-4">
                        {{-- ADD NEW PARAMETERS FORM --}}
                        <div class="mt-4">
                            <h5 class="font-weight-bold">Add New Parameters</h5>

                            <form action="{{ route('command.addParametres', $command) }}" method="POST">
                                @csrf
                                <fieldset>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <legend class="h6 m-0 text-muted">Dynamically add new parameters to this command.
                                        </legend>
                                        <button type="button" id="add-parameter-btn" class="btn btn-sm btn-success">+ Add
                                            Parameter</button>
                                    </div>
                                    <div id="parameters-container">
                                        {{-- Dynamic parameter rows will be inserted here --}}
                                    </div>
                                </fieldset>
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="submit" class="btn btn-primary">Save New Parameters</button>
                                </div>
                            </form>
                        </div>


                    </div>
                    <div class="card-footer text-muted">
                        Created: {{ $command->created_at->format('Y-m-d H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Hidden template for a single parameter row --}}
    <div id="parameter-template" style="display: none;">
        <div class="parameter-row border rounded p-3 mb-3 bg-light">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn-close remove-parameter-btn" aria-label="Remove"></button>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Parameter Name</label>
                    <input type="text" class="form-control" name="parametres[__INDEX__][nom]">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Type</label>
                    <select class="form-select" name="parametres[__INDEX__][type]">
                        <option value="flag">Flag</option>
                        <option value="option">Option</option>
                        <option value="arg">Argument</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <input type="text" class="form-control" name="parametres[__INDEX__][description]">
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Argument</label>
                    <div class="d-flex gap-2">
                        <input type="text" class="form-control" name="parametres[__INDEX__][argument]"
                            placeholder="ex: <container_name>">
                        <button type="button" class="btn btn-outline-secondary insert-var-btn text-nowrap">
                            &lt;&gt; Insérer variable
                        </button>
                    </div>
                    <div class="form-text mt-1 text-muted" style="font-size: 0.8em;">Sélectionne un mot puis clique "Insérer
                        variable" pour le wrapper en &lt;&gt;, ou clique sans sélection pour insérer &lt;variable&gt;</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Suffix</label>
                    <div class="d-flex gap-2">
                        <input type="text" class="form-control" name="parametres[__INDEX__][suffix]"
                            placeholder="ex: --timestamps ou -C <pathtofile>">
                        <button type="button" class="btn btn-outline-secondary insert-var-btn text-nowrap">
                            &lt;&gt; Insérer variable
                        </button>
                    </div>
                    <div class="form-text mt-1 text-muted" style="font-size: 0.8em;">Si le suffix contient lui-même une
                        variable, insère-la ici directement</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Copy Modal --}}
    <div class="modal fade" id="copyModal" tabindex="-1" aria-labelledby="copyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="copyModalLabel">Copier la commande</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="dynamicInputsContainer">
                        <!-- Generate dynamically -->
                    </div>
                    <div class="mt-3">
                        <strong>Aperçu de la commande (modifiable) :</strong>
                        <textarea id="commandPreview" class="form-control mt-2 font-monospace" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" id="confirmCopyBtn">Copier dans le presse-papier</button>
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

            if (addParamBtn && container && template) {
                addParamBtn.addEventListener('click', () => {
                    const newRow = template.firstElementChild.cloneNode(true);

                    newRow.querySelectorAll('[name^="parametres[__INDEX__]"]').forEach(input => {
                        input.name = input.name.replace('__INDEX__', parameterIndex);
                    });

                    container.appendChild(newRow);
                    parameterIndex++;
                });

                container.addEventListener('click', function (e) {
                    if (e.target && e.target.classList.contains('remove-parameter-btn')) {
                        e.target.closest('.parameter-row').remove();
                    }
                });
            }

            // Copy Command Logic
            const copyModalEl = document.getElementById('copyModal');
            if (copyModalEl) {
                const copyModal = new bootstrap.Modal(copyModalEl);
                const dynamicInputsContainer = document.getElementById('dynamicInputsContainer');
                const commandPreview = document.getElementById('commandPreview');
                const confirmCopyBtn = document.getElementById('confirmCopyBtn');

                let currentCmd = '';
                let currentParam = '';
                let currentArg = '';
                let currentSuffix = '';

                let placeholders = [];

                document.querySelectorAll('.copy-btn').forEach(button => {
                    button.addEventListener('click', function () {
                        currentCmd = this.dataset.cmd;
                        currentParam = this.dataset.param;
                        currentArg = this.dataset.argument && this.dataset.argument !== 'N/A' ? this.dataset.argument : '';
                        currentSuffix = this.dataset.suffix && this.dataset.suffix !== 'N/A' ? this.dataset.suffix : '';

                        placeholders = [];
                        const regex = /<([^>]+)>/g;
                        let match;
                        let idCount = 0;

                        const strToSearch = `${currentArg} ${currentSuffix}`;

                        while ((match = regex.exec(strToSearch)) !== null) {
                            if (!placeholders.find(p => p.original === match[0])) {
                                placeholders.push({
                                    original: match[0],
                                    name: match[1],
                                    inputId: `ph_${idCount++}`,
                                    value: ''
                                });
                            }
                        }

                        buildInputs();
                        updatePreview();

                        copyModal.show();
                    });
                });

                function buildInputs() {
                    dynamicInputsContainer.innerHTML = '';

                    if (placeholders.length === 0) {
                        // Fallback input if no <...> exists
                        dynamicInputsContainer.innerHTML = `
                                            <div class="mb-3">
                                                <label class="form-label">Argument supplémentaire (optionnel)</label>
                                                <input type="text" class="form-control" id="fallbackExtraArg" placeholder="Saisir un argument...">
                                            </div>
                                        `;
                        document.getElementById('fallbackExtraArg').addEventListener('input', updatePreview);
                    } else {
                        placeholders.forEach(ph => {
                            const div = document.createElement('div');
                            div.className = 'mb-3';
                            div.innerHTML = `
                                                <label class="form-label text-capitalize">${ph.name.replace(/_/g, ' ')}</label>
                                                <input type="text" class="form-control" id="${ph.inputId}" placeholder="Saisir ${ph.name}...">
                                            `;
                            dynamicInputsContainer.appendChild(div);

                            document.getElementById(ph.inputId).addEventListener('input', (e) => {
                                ph.value = e.target.value;
                                updatePreview();
                            });
                        });
                    }
                }

                function updatePreview() {
                    let finalCmd = `${currentCmd} ${currentParam}`;

                    if (placeholders.length === 0) {
                        const fallback = document.getElementById('fallbackExtraArg');
                        let argVal = fallback ? fallback.value.trim() : '';
                        if (currentArg) finalCmd += ` ${currentArg}`;
                        if (argVal) finalCmd += ` ${argVal}`;
                        if (currentSuffix) finalCmd += ` ${currentSuffix}`;
                    } else {
                        let parsedArg = currentArg;
                        let parsedSuffix = currentSuffix;

                        placeholders.forEach(ph => {
                            const replaceVal = ph.value.trim() !== '' ? ph.value : ph.original;
                            const regexSafe = ph.original.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                            parsedArg = parsedArg.replace(new RegExp(regexSafe, 'g'), replaceVal);
                            parsedSuffix = parsedSuffix.replace(new RegExp(regexSafe, 'g'), replaceVal);
                        });

                        if (parsedArg) finalCmd += ` ${parsedArg}`;
                        if (parsedSuffix) finalCmd += ` ${parsedSuffix}`;
                    }

                    commandPreview.value = finalCmd.replace(/\s+/g, ' ').trim();
                }

                confirmCopyBtn.addEventListener('click', function () {
                    navigator.clipboard.writeText(commandPreview.value).then(function () {
                        copyModal.hide();

                        let originalText = confirmCopyBtn.textContent;
                        confirmCopyBtn.textContent = 'Copiée !';
                        setTimeout(() => {
                            confirmCopyBtn.textContent = originalText;
                        }, 2000);
                    }).catch(function (err) {
                        console.error('Erreur lors de la copie : ', err);
                        alert("Erreur lors de la tentative de copie dans le presse-papier.");
                    });
                });
            }

            // Handle "Insérer variable" button clicks
            document.addEventListener('click', function (e) {
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
        });
    </script>
@endpush
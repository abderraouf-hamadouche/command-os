@extends('layouts.app')
@section('content')

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h1 class="display-4 mb-3">{{ __('Welcome to') }} {{ config('app.name') }}</h1>
                <p class="text-muted mb-4">By Admins For Admins</p>
                {{-- Search Bar --}}
                <div class="mb-4 mx-auto" style="max-width: 500px;">
                    <input type="text" id="search-input" class="form-control form-control-lg"
                        placeholder="{{ __('Type to search commands...') }}" autocomplete="off">
                </div>
                {{-- Search Results Container --}}
                <div id="search-results-container" class="text-start mb-5 mx-auto"></div>
                {{-- Section Links --}}
                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                    <a href="{{ route('command.index') }}" class="btn btn-primary btn-lg px-4 gap-3">{{ __('Commands') }}
                    </a>
                    <a href="{{ route('intervention.index') }}"
                        class="btn btn-outline-secondary btn-lg px-4">{{ __('Operations') }}</a>
                </div>
            </div>
        </div>
    </div>


@endsection


@push('styles')
    <style>
        #search-results-container .list-group-item-action {
            padding: 0.75rem 1rem;
            border: 1px solid #dee2e6;
            margin-bottom: -1px;
            /* To collapse borders */
        }

        #search-results-container .list-group-item-action:first-child {
            border-top-left-radius: .25rem;
            border-top-right-radius: .25rem;
        }

        #search-results-container .list-group-item-action:last-child {
            margin-bottom: 0;
            border-bottom-left-radius: .25rem;
            border-bottom-right-radius: .25rem;
        }

        .search-result-item {
            display: flex;
            align-items: baseline;
            /* Aligns text based on their bottom line */
            gap: 1.5rem;
            /* Creates space between the name and description */
        }

        .command-name {
            flex: 0 0 180px;
            /* Fixed width of 180px, does not grow or shrink */
            font-weight: 600;
            /* Bolder font */
            color: #212529;
            /* Darker text color */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            /* Adds "..." if name is too long */
        }

        /*
                             * NEW: Styling for the description (right column).
                             * It takes the remaining space and has a muted color.
                            */
        .command-description {
            flex: 1 1 auto;
            /* Allows this column to grow */
            color: #6c757d;
            /* Muted text color for the description */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            /* Adds "..." if description is too long */
        }
    </style>
@endpush


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search-input');
            const resultsContainer = document.getElementById('search-results-container');
            // The route() helper function is not available in JS, so we pass the URL this way
            const searchUrl = '{{ route("command.search") }}';
            searchInput.addEventListener('keyup', function () {
                const query = this.value;
                if (query.length < 2) {
                    resultsContainer.innerHTML = '';
                    return; // Don't search for very short strings
                }
                fetch(`${searchUrl}?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(commands => {
                        let html = '';
                        if (commands.length > 0) {
                            html = '<div class="list-group">';
                            commands.forEach(command => {
                                // Note: We need to manually construct the URL for the show page
                                const commandUrl = `{{ url('/command') }}/${command.id}`;
                                html += `
                                                        <a href="${commandUrl}" class="list-group-item list-group-item-action search-result-item">
                                                            <span class="command-name">${command.name}</span>
                                                            <span class="command-description">${command.description}</span>
                                                        </a>
                                                    `;
                            });
                            html += '</div>';
                        } else {
                            html = '<p class="text-muted text-center">No commands found.</p>';
                        }
                        resultsContainer.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error fetching search results:', error);
                        resultsContainer.innerHTML = '<p class="text-danger text-center">An error occurred while searching.</p>';
                    });
            });
        });
    </script>
@endpush
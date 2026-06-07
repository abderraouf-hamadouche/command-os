@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">{{ __('All Commands') }}</h1>
            <a href="{{ route('command.create') }}" class="btn btn-primary">{{ __('+ Add New Command') }}</a>
        </div>

        {{-- Session success message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Description') }}</th>
                                <th scope="col">{{ __('Tags') }}</th>
                                <th scope="col" class="text-center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($commands as $command)
                                <tr>
                                    <td><strong>{{ $command->name }}</strong></td>
                                    <td>{{ Str::limit($command->description, 80) }}</td>
                                    <td>
                                        @foreach($command->tags as $tag)
                                            <span class="badge bg-secondary">{{ $tag->nom }}</span>
                                        @endforeach
                                    </td>
                                    <td class="d-flex gap-1">
                                        <a href="{{ route('command.show', $command) }}"
                                            class="btn btn-sm btn-info ">{{ __('View Details') }}</a>
                                        <a href="{{ route('command.edit', $command) }}"
                                            class="btn btn-sm btn-warning me-1">{{ __('Edit Details') }}</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        No commands found. <a href="{{ route('command.create') }}">Create the first one!</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($commands->hasPages())
                <div class="card-footer bg-light border-top-0">
                    {{ $commands->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
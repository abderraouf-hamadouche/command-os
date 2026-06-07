@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">{{ __('All Operations') }}</h1>
            <a href="{{ route('intervention.create') }}" class="btn btn-primary">{{ __('+ Add New Operations') }}</a>
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
                                <th scope="col">{{ __('Titre') }}</th>
                                <th scope="col">{{ __('Description') }}</th>
                                <th scope="col" class="col-md-3">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($interventions as $intervention)
                                <tr>
                                    <td><strong>{{ $intervention->titre }}</strong></td>
                                    <td>{{ Str::limit($intervention->description, 80) }}</td>

                                    <td class="d-flex gap-1">
                                        <a href="{{ route('intervention.show', $intervention) }}"
                                            class="btn btn-sm btn-info ">{{ __('View Details') }}</a>
                                        <a href="{{ route('intervention.edit', $intervention) }}"
                                            class="btn btn-sm btn-warning me-1">{{ __('Edit Details') }}</a>
                                        <a href="{{ route('intervention.destroy', $intervention) }}"
                                            class="btn btn-sm btn-danger me-1">{{ __('Delete') }}</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        {{ __('No interventions found.') }} <a
                                            href="{{ route('intervention.create') }}">{{ __('Create the first one!') }}</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($interventions->hasPages())
                <div class="card-footer bg-light border-top-0">
                    {{ $intervention->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
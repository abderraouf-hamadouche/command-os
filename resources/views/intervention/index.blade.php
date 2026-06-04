@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">All Interventions</h1>
        <a href="{{ route('command.create') }}" class="btn btn-primary">+ Nouvelle Intervention</a>
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
                            <th scope="col" >Titre</th>
                            <th scope="col">Description</th>
                            <th scope="col" class="col-md-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($interventions as $intervention)
                            <tr>
                                <td><strong>{{ $intervention->titre }}</strong></td>
                                <td>{{ Str::limit($intervention->description, 80) }}</td>
 
                                <td class="d-flex gap-1">
                                 <a href="{{ route('intervention.show', $intervention) }}" class="btn btn-sm btn-info ">View Details</a>
                                 <a href="{{ route('intervention.edit', $intervention) }}" class="btn btn-sm btn-warning me-1">Edit Details</a>
                                 <a href="{{ route('intervention.destroy', $intervention) }}" class="btn btn-sm btn-danger me-1">Delete Details</a>
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
        @if($interventions->hasPages())
            <div class="card-footer bg-light border-top-0">
                {{ $intervention->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

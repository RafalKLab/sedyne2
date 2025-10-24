@extends('templates.main')

@section('title', 'Spaces')

@section('content')
    <div>
        {{-- Heading --}}
        <div class="mb-4">
            <h1 class="h4 fw-semibold text-dark">Spaces</h1>
            <p class="text-muted small">Create and view spaces below.</p>
        </div>

        {{-- Form --}}
        <form method="POST" class="row g-2 align-items-center mb-4">
            @csrf
            <div class="col-sm">
                <input
                    type="text"
                    name="name"
                    placeholder="Enter space name"
                    class="form-control"
                    required
                >
            </div>
            <div class="col-sm-auto">
                <button type="submit" class="btn btn-primary w-100">
                    Add Space
                </button>
            </div>
        </form>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                <tr>
                    <th scope="col">#id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($spaces as $space)
                    <tr>
                        <td>{{ $space->id  }}</td>
                        <td class="fw-medium">
                            @if(auth()->user()->settings->primary_space_id === $space->id)<span style="color: red"><i class="fa-solid fa-heart"></i></span>@endif
                             {{ $space->name }} </td>
                        <td>
                            <div class="action-buttons">
                                <div>
                                    @if ($space->layout)
                                        <a href="{{ route('space-preview', ['id' => $space->id]) }}" class="btn btn-sm btn-outline-secondary">
                                            Preview layout
                                        </a>
                                    @else
                                        <a href="{{ route('setup-layout', ['id' => $space->id]) }}" class="btn btn-sm btn-outline-primary">
                                            Setup layout
                                        </a>
                                    @endif
                                    @if(auth()->user()->settings->primary_space_id !== $space->id)
                                            <form style="display: inline" action="{{ route('space-set-primary', ['id' => $space->id]) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-sm btn-primary">Make your primary</button>
                                            </form>
                                    @endif

                                </div>
                                <a href="" class="btn btn-sm btn-outline-danger disabled">
                                    Delete
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">No spaces found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

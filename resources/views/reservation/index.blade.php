@extends('templates.main')

@section('title')
    My reservations
@endsection

@section('content')
    {{-- Heading --}}
    <div class="mb-4">
        <h1 class="h4 fw-semibold text-dark">My reservations</h1>
    </div>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover table-bordered align-middle text-center">
            <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Space</th>
                <th scope="col">Seat</th>
                <th scope="col">From</th>
                <th scope="col">To</th>
                <th scope="col">Created At</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($reservations as $index => $reservation)
                <tr>
                    <th scope="row">{{ $index + 1 }}</th>
                    <td>{{ $reservation->space->name ?? '-' }}</td>
                    <td>{{ $reservation->seatId }}</td>
                    <td>{{ $reservation->fromDate }}</td>
                    <td>{{ $reservation->toDate }}</td>
                    <td>{{ $reservation->createdAt }}</td>
                    <td>
                        <a href="" class="btn btn-outline-danger btn-sm w-100">Cancel</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-muted">No reservations found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Audit Activity')

@section('content')
<div class="container">
    <h3 class="mb-4">📋 Audit Activity</h3>

    {{-- Filter Event --}}
    <div class="mb-3">
        <a href="{{ route('activities.index') }}" class="btn btn-outline-dark btn-sm {{ request('event') ? '' : 'active' }}">Semua</a>
        <a href="{{ route('activities.index', ['event' => 'created']) }}" class="btn btn-outline-success btn-sm {{ request('event') == 'created' ? 'active' : '' }}">Ditambahkan</a>
        <a href="{{ route('activities.index', ['event' => 'updated']) }}" class="btn btn-outline-warning btn-sm {{ request('event') == 'updated' ? 'active' : '' }}">Diperbarui</a>
        <a href="{{ route('activities.index', ['event' => 'deleted']) }}" class="btn btn-outline-danger btn-sm {{ request('event') == 'deleted' ? 'active' : '' }}">Dihapus</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>User</th>
                <th>Event</th>
                <th>Detail Perubahan</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            @forelse($activities as $index => $activity)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $activity['user'] }}</td>
                <td>{{ $activity['event'] }}</td>
                <td>
                    @foreach($activity['details'] as $detail)
                        <div>{{ $detail }}</div>
                    @endforeach
                </td>
                <td>{{ $activity['time'] }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada aktivitas</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    {{ $pagination->links() }}
</div>
@endsection

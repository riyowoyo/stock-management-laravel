@extends('layouts.app')

@section('title', 'Audit Activity')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-body py-3">
            <h5 class="mb-0 fw-bold">📝 Audit Activity</h5>
        </div>
        <div class="card-body p-3">

            {{-- Switch Produk / Transaksi --}}
            <div class="d-flex gap-2 mb-3 flex-wrap">
                <a href="{{ route('activities.index', ['type' => 'product']) }}"
                   class="btn btn-outline-primary {{ $type === 'product' ? 'active' : '' }}">
                    Produk
                </a>
                <a href="{{ route('activities.index', ['type' => 'transaction']) }}"
                   class="btn btn-outline-secondary {{ $type === 'transaction' ? 'active' : '' }}">
                    Transaksi
                </a>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 40px;">No</th>
                            <th>User</th>
                            <th>Deskripsi</th>
                            <th>Event</th>
                            <th>Tanggal</th>
                            <th style="width: 80px;">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr>
                                <td>{{ $loop->iteration + ($logs->currentPage()-1)*$logs->perPage() }}</td>
                                <td>{{ $log->causer?->name ?? 'System' }}</td>
                                <td>{{ $log->description }}</td>
                                <td>
                                    @php
                                        $badgeClass = match($log->event) {
                                            'created' => 'success',
                                            'updated' => 'warning',
                                            'deleted' => 'danger',
                                            default => 'secondary'
                                        };
                                        $eventLabel = match($log->event) {
                                            'created' => 'Ditambahkan',
                                            'updated' => 'Diperbarui',
                                            'deleted' => 'Dihapus',
                                            default => ucfirst($log->event)
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }}">{{ $eventLabel }}</span>
                                </td>
                                <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    @if($log->properties)
                                        <button class="btn btn-sm btn-info" data-bs-toggle="collapse"
                                                data-bs-target="#detail-{{ $log->id }}">
                                            Detail
                                        </button>
                                    @endif
                                </td>
                            </tr>

                            @if($log->properties)
                            <tr class="collapse bg-light" id="detail-{{ $log->id }}">
                                <td colspan="6" class="p-2">
                                    <table class="table table-sm table-bordered mb-0">
                                        <tbody>
                                            @foreach($log->properties->toArray() as $key => $value)
                                                <tr>
                                                    <th style="width: 200px;">{{ $key }}</th>
                                                    <td>{{ is_array($value) ? json_encode($value) : $value }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-3">Belum ada aktivitas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-end mt-3">
                {{ $logs->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>
</div>
@endsection

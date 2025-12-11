@extends('layouts.wali')

@section('title', 'Notifikasi')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Notifikasi</h1>
            <p class="page-subtitle">Daftar semua notifikasi Anda.</p>
        </div>
        @if($notifikasi->where('is_read', false)->count() > 0)
        <div>
            <form action="{{ route('wali.notifikasi.mark-all-read') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-secondary">
                    <i class="bi bi-check-all"></i> Tandai Semua Dibaca
                </button>
            </form>
        </div>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th width="50">Tipe</th>
                        <th>Judul</th>
                        <th>Pesan</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th width="80">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notifikasi as $item)
                        <tr class="{{ !$item->is_read ? 'table-primary' : '' }}">
                            <td>
                                @if($item->tipe == 'tagihan')
                                    <i class="bi bi-receipt text-warning fs-5"></i>
                                @elseif($item->tipe == 'pembayaran')
                                    <i class="bi bi-check-circle text-success fs-5"></i>
                                @elseif($item->tipe == 'pengumuman')
                                    <i class="bi bi-megaphone text-primary fs-5"></i>
                                @else
                                    <i class="bi bi-info-circle text-info fs-5"></i>
                                @endif
                            </td>
                            <td>
                                <strong class="{{ !$item->is_read ? 'fw-bold' : '' }}">{{ $item->judul }}</strong>
                            </td>
                            <td>{{ Str::limit($item->pesan, 50) }}</td>
                            <td data-order="{{ $item->created_at->format('Y-m-d H:i:s') }}">
                                {{ $item->created_at->diffForHumans() }}
                            </td>
                            <td>
                                @if(!$item->is_read)
                                    <span class="badge badge-primary">Baru</span>
                                @else
                                    <span class="badge badge-secondary">Dibaca</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('wali.notifikasi.show', $item) }}" class="btn btn-sm btn-primary" title="Lihat">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .table-primary {
            background-color: var(--primary-subtle) !important;
        }
        .fs-5 {
            font-size: 1.25rem;
        }
    </style>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            order: [[3, 'desc']],
            columnDefs: [
                { orderable: false, targets: [0, -1] }
            ]
        });
    });
</script>
@endpush

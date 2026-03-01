@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')

<style>
    .light-card {
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        color: #111827;
        border-radius: 12px;
    }

    .light-table thead {
        background-color: #f3f4f6;
        color: #111827;
    }

    .light-table tbody tr {
        border-bottom: 1px solid #e5e7eb;
    }

    .light-table tbody tr:hover {
        background-color: #f9fafb;
        transition: 0.2s;
    }

    .text-muted-light {
        color: #6b7280 !important;
    }
</style>

{{-- Header --}}
<div class="light-card shadow-sm p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1 text-primary fw-bold">
                👥 Kelola User
            </h4>
            <small class="text-muted-light">
                Manajemen keanggotaan perpustakaan
            </small>
        </div>

        @if (Auth::user()->role === 'admin')
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm px-3">
                + Tambah User
            </a>
        @endif
    </div>
</div>

{{-- Table --}}
<div class="light-card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table light-table align-middle mb-0">
                <thead>
                    <tr>
                        <th>NIS</th>
                        <th>Jurusan</th>
                        <th>Kelas</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->school_id }}</td>
                            <td>{{ $user->major }}</td>
                            <td>{{ $user->class }}</td>
                            <td class="fw-semibold">{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>
                                <span class="badge bg-{{ $user->role === 'admin' ? 'primary' : 'success' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="text-center">

                                <a href="{{ route('users.edit', $user->id) }}"
                                   class="btn btn-warning btn-sm me-1">
                                    Edit
                                </a>

                                @if (Auth::id() !== $user->id)
                                    <form action="{{ route('users.destroy', $user->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            Hapus
                                        </button>
                                    </form>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted-light">
                                👤 Tidak ada data user
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>

@endsection
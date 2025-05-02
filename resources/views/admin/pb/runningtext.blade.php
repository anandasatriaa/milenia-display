@extends('admin.layouts.app')

@section('title', 'Running Text PB | Milenia Display')

@section('css')
    <style>
        .runningtext-item {
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            background: white;
            cursor: move;
        }

        .runningtext-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .runningtext-item2 {
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            background: white;
        }

        .runningtext-item2:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .runningtext-thumbnail {
            height: 150px;
            object-fit: cover;
            border-radius: 4px;
        }

        .sortable-chosen {
            opacity: 0.8;
            background: #f8f9fa;
        }

        .badge-sm {
            font-size: 0.65rem;
            padding: 3px 6px;
            margin-top: 5px;
            width: fit-content;
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Running Text Management</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRunningtextModal">
                    <i class="bx bx-plus me-1"></i> Add Running Text
                </button>
            </div>
            <div class="card-body">
                <div class="runningtext-item2 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex flex-column">
                            @if (count($keterlambatan) > 0)
                                <span class="fw-bold mb-2">
                                    Keterlambatan
                                    {{ \Carbon\Carbon::parse($keterlambatan[0]->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                </span>

                                @foreach ($keterlambatan as $absen)
                                    @php
                                        $formattedFoto = str_pad($absen->ID, 5, '0', STR_PAD_LEFT); // <-- Gunakan $absen->ID disini

                                        $clientIp = request()->ip();

                                        if (
                                            $clientIp === '127.0.0.1' ||
                                            \Illuminate\Support\Str::startsWith($clientIp, '192.168.0.')
                                        ) {
                                            $baseUrl = 'http://192.168.0.8/hrd-milenia/foto/';
                                        } else {
                                            $baseUrl = 'http://pc.dyndns-office.com:8001/hrd-milenia/foto/';
                                        }

                                        $fotoUrl = $baseUrl . "{$formattedFoto}.JPG";
                                    @endphp

                                    <div class="d-flex align-items-center gap-2 my-1">
                                        <img src="{{ $fotoUrl }}" alt="{{ $absen->Nama }}" class="rounded-circle"
                                            width="35" height="35" style="object-fit: cover;">
                                        <span class="text-muted">
                                            {{ $absen->Nama }} : {{ \Carbon\Carbon::parse($absen->jam)->format('H:i') }}
                                        </span>
                                    </div>
                                @endforeach
                            @else
                                <span class="fw-bold">Tidak ada keterlambatan hari ini.</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div id="runningtextList" class="sortable-list">
                    @forelse ($runningtexts as $runningtext)
                        <div class="runningtext-item d-flex align-items-center justify-content-between"
                            data-id="{{ $runningtext->id }}">
                            <div class="d-flex align-items-center gap-3">
                                <span class="handle"><i class="bx bx-menu"></i></span>
                                <div class="d-flex flex-column">
                                    <span class="text-muted">{{ $runningtext->name }}</span>
                                    <span
                                        class="status-badge badge rounded-pill {{ $runningtext->active ? 'bg-success' : 'bg-danger' }} badge-sm">
                                        {{ $runningtext->active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <button
                                    class="btn btn-sm toggle-status {{ $runningtext->active ? 'btn-danger' : 'btn-success' }}"
                                    data-id="{{ $runningtext->id }}">
                                    <i class="bx bx-power-off"></i>
                                </button>
                                <button class="btn btn-primary btn-sm edit-runningtext" data-id="{{ $runningtext->id }}"
                                    data-title="{{ $runningtext->name }}">
                                    <i class="bx bx-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm delete-runningtext" data-id="{{ $runningtext->id }}">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted"></p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Add Running Text Modal -->
    <div class="modal fade" id="addRunningtextModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Running Text</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="runningtextForm" action="{{ route('admin.pb.runningtext.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Running Text</label>
                            <div class="d-flex align-items-start mb-1">
                                <textarea id="runningTextInput" class="form-control" name="name" rows="3"
                                    placeholder="Enter running text with emoji" required></textarea>
                            </div>
                            <small class="text-muted">
                                Tekan <kbd>Windows</kbd> + <kbd>.</kbd> atau <kbd>Windows</kbd> + <kbd>;</kbd> di keyboard
                                untuk menambahkan emoji 😊
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Running Text</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Running Text Modal -->
    <div class="modal fade" id="editRunningtextModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Running Text</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editRunningtextForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editRunningtextId">
                        <div class="mb-3">
                            <label class="form-label">Running Text</label>
                            <div class="d-flex align-items-start mb-1">
                                <textarea id="editRunningtextName" class="form-control" name="name" rows="3"
                                    placeholder="Enter running text with emoji" required></textarea>
                            </div>
                            <small class="text-muted">
                                Tekan <kbd>Windows</kbd> + <kbd>.</kbd> atau <kbd>Windows</kbd> + <kbd>;</kbd> di keyboard
                                untuk menambahkan emoji 😊
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        // SUKSES DAN GAGAL KETIKA ADD BANNER
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Refresh halaman setelah klik OK
                    location.reload();
                }
            });

            // Jika pakai Bootstrap 5
            const modal = bootstrap.Modal.getInstance(document.getElementById('addBannerModal'));
            if (modal) modal.hide();
        @endif

        // Handle Errors using SweetAlert
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                showConfirmButton: true
            });
        @endif

        // URUTAN RUNNING TEXT
        const sortable = new Sortable(document.getElementById('runningtextList'), {
            animation: 150,
            onUpdate: function(evt) {
                const itemIds = Array.from(document.querySelectorAll('.runningtext-item')).map(item => item
                    .dataset.id);

                // Kirim urutan baru ke backend
                fetch("{{ route('admin.pb.runningtext.update-order') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            order: itemIds
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Tampilkan notifikasi sukses
                        Swal.fire({
                            toast: true,
                            position: 'bottom-end', // Menampilkan di pojok bawah kanan
                            icon: 'success',
                            title: 'Urutan running text berhasil diubah!',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                    })
                    .catch(error => {
                        // Jika terjadi error saat pembaruan
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat mengubah urutan.',
                            showConfirmButton: true
                        });
                    });
            }
        });
    </script>

    {{-- TOOGLE STATUS ACTIVE DAN INACTIVE --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Meng-handle klik tombol toggle status
            document.querySelectorAll('.toggle-status').forEach(button => {
                button.addEventListener('click', function() {
                    const runningtextId = this.getAttribute('data-id');

                    fetch("{{ route('admin.pb.runningtext.toggle-status') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                id: runningtextId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);

                            if (data.status === 'success' && typeof data.active !==
                                'undefined') {
                                // Ubah badge status dan icon
                                const runningtextItem = document.querySelector(
                                    `.runningtext-item[data-id="${runningtextId}"]`);
                                const badge = runningtextItem.querySelector('.status-badge');
                                const toggleButton = runningtextItem.querySelector(
                                    '.toggle-status');

                                // Toggle the 'active' status
                                if (data.active) {
                                    badge.classList.remove('bg-danger');
                                    badge.classList.add('bg-success');
                                    badge.innerText = 'Active';

                                    toggleButton.classList.remove('btn-success');
                                    toggleButton.classList.add('btn-danger');
                                } else {
                                    badge.classList.remove('bg-success');
                                    badge.classList.add('bg-danger');
                                    badge.innerText = 'Inactive';

                                    toggleButton.classList.remove('btn-danger');
                                    toggleButton.classList.add('btn-success');
                                }

                                // Show success SweetAlert
                                Swal.fire({
                                    toast: true,
                                    position: 'bottom-end',
                                    icon: 'success',
                                    title: data.active ? 'Running Text Activated' :
                                        'Running Text Deactivated',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true
                                });
                            } else {
                                // Show error SweetAlert only if status is not success
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan saat memperbarui status.',
                                    showConfirmButton: true
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat memperbarui status.',
                                showConfirmButton: true
                            });
                        });
                });
            });
        });
    </script>

    {{-- EDIT RUNNING TEXT --}}
    <script>
        // --- definisi named-route template ---
        const editTpl = "{{ route('admin.pb.runningtext.edit', ['id' => ':id']) }}";
        const updateTpl = "{{ route('admin.pb.runningtext.update', ['id' => ':id']) }}";

        // --- handler edit ---
        $(document).on('click', '.edit-runningtext', function() {
            const id = $(this).data('id');
            const url = editTpl.replace(':id', id);

            $.get(url, function(data) {
                $('#editRunningtextId').val(data.id);
                $('#editRunningtextName').val(data.name);
                $('#editRunningtextForm')
                    .attr('action', updateTpl.replace(':id', id));
                $('#editRunningtextModal').modal('show');
            });
        });
    </script>

    {{-- DELETE RUNNING TEXT --}}
    <script>
        $(document).on('click', '.delete-runningtext', function() {
            const runningtextId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    let deleteUrl = `{{ route('admin.pb.runningtext.delete', ':id') }}`.replace(':id',
                        runningtextId);

                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'Running text has been deleted.',
                                'success'
                            );
                            $(`[data-id="${runningtextId}"]`).closest('.runningtext-item')
                                .remove();
                        },
                        error: function() {
                            Swal.fire(
                                'Failed!',
                                'An error occurred while deleting the running text.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    </script>

@endsection

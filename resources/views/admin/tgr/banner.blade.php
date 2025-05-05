@extends('admin.layouts.app')

@section('title', 'Banner TGR | Milenia Display')

@section('css')
    <style>
        .banner-item {
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            background: white;
            cursor: move;
        }

        .banner-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .banner-thumbnail {
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
                <h5 class="mb-0">Banner Management</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBannerModal">
                    <i class="bx bx-plus me-1"></i> Add Banner
                </button>
            </div>
            <div class="card-body">
                <div id="bannerList" class="sortable-list">
                    @forelse ($banners as $banner)
                        <div class="banner-item d-flex align-items-center justify-content-between"
                            data-id="{{ $banner->id }}">
                            <div class="d-flex align-items-center gap-3">
                                <span class="handle"><i class="bx bx-menu"></i></span>
                                <img src="{{ asset('storage/' . $banner->image) }}" class="banner-thumbnail" alt="Banner">

                                <div class="d-flex flex-column">
                                    <span class="text-muted">{{ $banner->name }}</span>
                                    <span
                                        class="status-badge badge rounded-pill {{ $banner->active ? 'bg-success' : 'bg-danger' }} badge-sm">
                                        {{ $banner->active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <button
                                    class="btn btn-sm toggle-status {{ $banner->active ? 'btn-danger' : 'btn-success' }}"
                                    data-id="{{ $banner->id }}">
                                    <i class="bx bx-power-off"></i>
                                </button>
                                <button class="btn btn-primary btn-sm edit-banner"
                                    data-url="{{ route('admin.tgr.banner.edit', $banner->id) }}"
                                    data-id="{{ $banner->id }}" data-title="{{ $banner->name }}"
                                    data-image="{{ asset('storage/' . $banner->image) }}">
                                    <i class="bx bx-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm delete-banner" data-id="{{ $banner->id }}">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Belum ada banner ditambahkan.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Add Banner Modal -->
    <div class="modal fade" id="addBannerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="bannerForm" action="{{ route('admin.tgr.banner.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Banner Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter banner title"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Banner Image</label>
                            <input type="file" class="form-control" name="image" accept="image/*" required>
                            <small class="text-muted"><span class="text-danger">*</span> max size: 10MB</small>
                            <div class="mt-2">
                                <img id="imagePreview" src="#" alt="Preview" class="img-fluid d-none"
                                    style="max-height: 200px;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Banner</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Banner Modal -->
    <div class="modal fade" id="editBannerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editBannerForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editBannerId">
                        <div class="mb-3">
                            <label class="form-label">Banner Title</label>
                            <input type="text" class="form-control" name="title" id="editBannerTitle" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Banner Image (leave empty to keep current)</label>
                            <input type="file" class="form-control" name="image" accept="image/*">
                            <small class="text-muted"><span class="text-danger">*</span> max size: 10MB</small>
                            <div class="mt-2">
                                <img id="editImagePreview" src="#" alt="Preview" class="img-fluid"
                                    style="max-height: 200px;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Banner</button>
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

        // URUTAN BANNER
        const sortable = Sortable.create(document.getElementById('bannerList'), {
            animation: 150,
            onUpdate: function(evt) {
                const itemIds = Array.from(document.querySelectorAll('.banner-item')).map(item => item.dataset
                    .id);

                fetch("{{ route('admin.tgr.banner.update-order') }}", {
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
                        // Show success SweetAlert on successful order change
                        Swal.fire({
                            toast: true,
                            position: 'bottom-end', // Display at the bottom right
                            icon: 'success',
                            title: 'Urutan banner berhasil diubah!',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                    })
                    .catch(error => {
                        // If there is an error during the update
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat mengubah urutan.',
                            showConfirmButton: true
                        });
                    });
            }
        });

        // IMAGE PREVIEW DI MODAL ADD BANNER
        document.querySelector('input[name="image"]').addEventListener('change', function(e) {
            const reader = new FileReader();
            reader.onload = function() {
                const preview = document.getElementById('imagePreview');
                preview.src = reader.result;
                preview.classList.remove('d-none');
            };
            reader.readAsDataURL(e.target.files[0]);
        });
    </script>

    {{-- TOOGLE STATUS ACTIVE DAN INACTIVE --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Meng-handle klik tombol toggle status
            document.querySelectorAll('.toggle-status').forEach(button => {
                button.addEventListener('click', function() {
                    const bannerId = this.getAttribute('data-id');

                    fetch("{{ route('admin.tgr.banner.toggle-status') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                id: bannerId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);

                            if (data.status === 'success' && typeof data.active !==
                                'undefined') {
                                // Ubah badge status dan icon
                                const bannerItem = document.querySelector(
                                    `.banner-item[data-id="${bannerId}"]`);
                                const badge = bannerItem.querySelector('.status-badge');
                                const toggleButton = bannerItem.querySelector('.toggle-status');

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
                                    title: data.active ? 'Banner Activated' :
                                        'Banner Deactivated',
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

    {{-- EDIT BANNER --}}
    <script>
        $(document).on('click', '.edit-banner', function() {
            const url = $(this).data('url');
            const imageUrl = $(this).data('image');

            $.get(url, function(data) {
                $('#editBannerId').val(data.id);
                $('#editBannerTitle').val(data.name);

                $('#editImagePreview').attr('src', imageUrl).removeClass('d-none');
                $('#editBannerForm').attr('action', url.replace('/edit', ''));
                $('#editBannerModal').modal('show');
            });
        });

        // Event listener untuk mengganti preview gambar saat memilih file baru
        $('#editBannerForm input[name="image"]').on('change', function() {
            const file = this.files[0];
            if (file) {
                // Membaca gambar baru menggunakan FileReader
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#editImagePreview').attr('src', e.target
                        .result); // Ganti preview dengan gambar yang baru dipilih
                };
                reader.readAsDataURL(file); // Membaca file dan menyiapkan gambar untuk ditampilkan
            }
        });
    </script>

    {{-- DELETE BANNER --}}
    <script>
        $(document).on('click', '.delete-banner', function() {
            const bannerId = $(this).data('id');

            // Konfirmasi dengan SweetAlert
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
                    // Jika konfirmasi di-OK-kan, hapus data
                    let deleteUrl = `{{ route('admin.tgr.banner.delete', ':id') }}`.replace(':id',
                        bannerId);
                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'The banner has been deleted.',
                                'success'
                            );
                            // Menghapus elemen banner dari halaman setelah dihapus
                            $(`[data-id="${bannerId}"]`).closest('.banner-item').remove();
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Failed!',
                                'An error occurred while deleting the banner.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    </script>

@endsection

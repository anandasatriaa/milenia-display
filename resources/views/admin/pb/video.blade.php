@extends('admin.layouts.app')

@section('title', 'Video PB | Milenia Display')

@section('css')
    <style>
        .video-item {
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            background: white;
            cursor: move;
        }

        .video-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .video-thumbnail {
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
                <h5 class="mb-0">Video Management</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVideoModal">
                    <i class="bx bx-plus me-1"></i> Add Video
                </button>
            </div>
            <div class="card-body">
                <div id="videoList" class="sortable-list">
                    @forelse ($videos as $video)
                        <div class="video-item d-flex align-items-center justify-content-between"
                            data-id="{{ $video->id }}">
                            <div class="d-flex align-items-center gap-3">
                                <span class="handle"><i class="bx bx-menu"></i></span>

                                <video width="150" class="rounded" controls muted>
                                    <source src="{{ asset('storage/' . $video->video) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>

                                <div class="d-flex flex-column">
                                    <span class="text-muted">{{ $video->name }}</span>
                                    <span
                                        class="status-badge badge rounded-pill {{ $video->active ? 'bg-success' : 'bg-danger' }} badge-sm">
                                        {{ $video->active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm toggle-status {{ $video->active ? 'btn-danger' : 'btn-success' }}"
                                    data-id="{{ $video->id }}">
                                    <i class="bx bx-power-off"></i>
                                </button>
                                <button class="btn btn-primary btn-sm edit-video" data-id="{{ $video->id }}"
                                    data-title="{{ $video->name }}" data-video="{{ asset('storage/' . $video->video) }}">
                                    <i class="bx bx-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm delete-video" data-id="{{ $video->id }}">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Belum ada video ditambahkan.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Add Video Modal -->
    <div class="modal fade" id="addVideoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="videoForm" action="{{ route('admin.pb.video.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Video Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter video title"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload Video</label>
                            <input type="file" class="form-control" name="video" accept="video/*" required>
                            <small class="text-muted"><span class="text-danger">*</span> max size: 300MB</small>
                            <div class="mt-2">
                                <video id="videoPreview" controls class="w-100 d-none" style="max-height: 300px;">
                                    <source src="#" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Video</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Video Modal -->
    <div class="modal fade" id="editVideoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editVideoForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editVideoId">
                        <div class="mb-3">
                            <label class="form-label">Video Title</label>
                            <input type="text" class="form-control" name="title" id="editVideoTitle" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Video (leave empty to keep current)</label>
                            <input type="file" class="form-control" name="video" accept="video/*">
                            <small class="text-muted"><span class="text-danger">*</span> max size: 300MB</small>
                            <div class="mt-2">
                                <video id="editVideoPreview" class="img-fluid" style="max-height: 200px;" controls muted>
                                    <source src="#" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Video</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        // SUKSES DAN GAGAL KETIKA ADD VIDEO
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });

            const modal = bootstrap.Modal.getInstance(document.getElementById('addVideoModal'));
            if (modal) modal.hide();
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                showConfirmButton: true
            });
        @endif

        // URUTAN VIDEO
        const sortable = Sortable.create(document.getElementById('videoList'), {
            animation: 150,
            onUpdate: function(evt) {
                const itemIds = Array.from(document.querySelectorAll('.video-item')).map(item => item.dataset
                    .id);

                fetch("{{ route('admin.pb.video.update-order') }}", { // Ganti route ke video
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
                            position: 'bottom-end',
                            icon: 'success',
                            title: 'Urutan video berhasil diubah!',
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
    </script>

    {{-- PREVIEW VIDEO --}}
    <script>
        document.querySelector('input[name="video"]').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith('video/')) {
                const videoPreview = document.getElementById('videoPreview');
                const source = videoPreview.querySelector('source');

                source.src = URL.createObjectURL(file);
                videoPreview.load();
                videoPreview.classList.remove('d-none');
            }
        });
    </script>

    {{-- TOOGLE STATUS ACTIVE DAN INACTIVE --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Meng-handle klik tombol toggle status
            document.querySelectorAll('.toggle-status').forEach(button => {
                button.addEventListener('click', function() {
                    const videoId = this.getAttribute('data-id');

                    fetch("{{ route('admin.pb.video.toggle-status') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                id: videoId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);

                            if (data.status === 'success' && typeof data.active !==
                                'undefined') {
                                // Ubah badge status dan icon
                                const videoItem = document.querySelector(
                                    `.video-item[data-id="${videoId}"]`);
                                const badge = videoItem.querySelector('.status-badge');
                                const toggleButton = videoItem.querySelector('.toggle-status');

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
                                    title: data.active ? 'Video Activated' :
                                        'Video Deactivated',
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

    {{-- EDIT VIDEO --}}
    <script>
        $(document).on('click', '.edit-video', function() {
            const videoId = $(this).data('id');
            $.get(`/admin/pb/video/${videoId}/edit`, function(data) {
                $('#editVideoId').val(data.id);
                $('#editVideoTitle').val(data.name);
                $('#editVideoPreview source').attr('src', `/storage/${data.video}`);
                const videoElement = document.getElementById('editVideoPreview');
                videoElement.load(); // <-- ini cara yang benar!
                $('#editVideoForm').attr('action', `/admin/pb/video/${videoId}`);
                $('#editVideoModal').modal('show');
            });
        });

        // Update preview video saat upload file baru
        $('#editVideoForm input[name="video"]').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#editVideoPreview source').attr('src', e.target.result);
                    const videoElement = document.getElementById('editVideoPreview');
                    videoElement.load(); // <-- ini cara yang benar!
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

    {{-- DELETE VIDEO --}}
    <script>
        $(document).on('click', '.delete-video', function() {
            const videoId = $(this).data('id');

            // Konfirmasi dengan SweetAlert
            Swal.fire({
                title: 'Are you sure?',
                text: "The video will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika user konfirmasi, jalankan delete
                    let deleteUrl = `{{ route('admin.pb.video.delete', ':id') }}`.replace(':id', videoId);
                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'The video has been deleted.',
                                'success'
                            );
                            // Hapus elemen video dari halaman setelah berhasil
                            $(`[data-id="${videoId}"]`).closest('.video-item').remove();
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Failed!',
                                'An error occurred while deleting the video.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    </script>

@endsection

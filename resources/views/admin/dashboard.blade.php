@extends('admin.layouts.app')

@section('title', 'Dashboard | Milenia Display')

@section('css')
    <style>
        .card {
            border-radius: 15px;
            overflow: hidden;
        }

        .card-header {
            padding: 1rem 1.5rem;
        }

        .badge {
            font-size: 0.85em;
            padding: 0.5em 0.75em;
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="mb-4">Preview Display</h4>

        <div class="row g-4">
            <!-- Preview PB -->
            <div class="col-12">
                <div class="card shadow-lg">
                    <div
                        class="card-header d-flex justify-content-between align-items-center bg-light border-bottom border-top border-success border-3">
                        <div class="d-flex align-items-center">
                            <h5 class="m-0">Preview PB</h5>
                            <span id="pb-badge" class="badge bg-danger ms-2 d-none">
                                <i class="bx bx-error-circle me-1"></i>Gagal Memuat
                            </span>
                        </div>
                        <div>
                            <button onclick="refreshIframe('pb-iframe')" class="btn btn-sm btn-outline-secondary me-2">
                                <i class="bx bx-refresh"></i>
                            </button>
                            <a href="{{ route('pb') }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="bx bx-fullscreen me-1"></i>Halaman Penuh
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <iframe id="pb-iframe" src="{{ route('pb') }}" class="w-100"
                            style="height: 750px; border: none;"></iframe>
                    </div>
                </div>
            </div>

            <!-- Preview TGR -->
            <div class="col-12">
                <div class="card shadow-lg">
                    <div
                        class="card-header d-flex justify-content-between align-items-center bg-light border-bottom border-top border-primary border-3">
                        <div class="d-flex align-items-center">
                            <h5 class="m-0">Preview TGR</h5>
                            <span id="tgr-badge" class="badge bg-danger ms-2 d-none">
                                <i class="bx bx-error-circle me-1"></i>Gagal Memuat
                            </span>
                        </div>
                        <div>
                            <button onclick="refreshIframe('tgr-iframe')" class="btn btn-sm btn-outline-secondary me-2">
                                <i class="bx bx-refresh"></i>
                            </button>
                            <a href="{{ route('tgr') }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="bx bx-fullscreen me-1"></i>Halaman Penuh
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <iframe id="tgr-iframe" src="{{ route('tgr') }}" class="w-100"
                            style="height: 750px; border: none;"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi pemantauan untuk kedua iframe
            monitorIframeStatus('tgr-iframe', 'tgr-badge');
            monitorIframeStatus('pb-iframe', 'pb-badge');
        });

        function monitorIframeStatus(iframeId, badgeId) {
            const iframe = document.getElementById(iframeId);
            const badge = document.getElementById(badgeId);

            // Cek status setiap 30 detik
            const checkInterval = setInterval(() => {
                checkIframeStatus(iframe, badge);
            }, 30000);

            // Event listener untuk error loading iframe
            iframe.addEventListener('error', () => {
                showErrorBadge(badge);
            });
        }

        function checkIframeStatus(iframe, badge) {
            fetch(iframe.src)
                .then(response => {
                    if (!response.ok) throw new Error('Error');
                    badge.classList.add('d-none');
                    // Jika iframe masih error, refresh
                    if (iframe.contentWindow.document.readyState === 'complete' &&
                        iframe.contentDocument.title === "Error") {
                        refreshIframe(iframe.id);
                    }
                })
                .catch(() => showErrorBadge(badge));
        }

        function showErrorBadge(badge) {
            badge.classList.remove('d-none');
            badge.classList.add('animate__animated', 'animate__headShake');
            setTimeout(() => {
                badge.classList.remove('animate__headShake');
            }, 1000);
        }

        function refreshIframe(iframeId) {
            const iframe = document.getElementById(iframeId);
            iframe.src = iframe.src;
            const badge = document.getElementById(iframeId === 'tgr-iframe' ? 'tgr-badge' : 'pb-badge');
            badge.classList.add('d-none');
        }
    </script>

@endsection

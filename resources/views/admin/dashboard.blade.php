@extends('admin.layouts.app')

@section('title', 'Dashboard | Milenia Display')

@section('css')

@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="container py-5">
            <h1 class="mb-4">Preview Display</h1>
        
            <div class="row g-4">
                <!-- Preview TGR -->
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Preview TGR</span>
                            <a href="{{ route('tgr') }}" target="_blank" class="btn btn-sm btn-primary">
                                Lihat Halaman Penuh
                            </a>
                        </div>
                        <div class="card-body p-0">
                            <iframe src="{{ route('tgr') }}" class="w-100" style="height: 750px; border: none;"></iframe>
                        </div>
                    </div>
                </div>
        
                <!-- Preview PB -->
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Preview PB</span>
                            <a href="{{ route('pb') }}" target="_blank" class="btn btn-sm btn-primary">
                                Lihat Halaman Penuh
                            </a>
                        </div>
                        <div class="card-body p-0">
                            <iframe src="{{ route('pb') }}" class="w-100" style="height: 750px; border: none;"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
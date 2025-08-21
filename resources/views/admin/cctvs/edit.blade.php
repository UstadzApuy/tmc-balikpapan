@extends('admin.layout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit CCTV</h1>
        
        <form action="{{ route('admin.cctvs.update', $cctv) }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama CCTV</label>
                <input type="text" name="name" id="name" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('name', $cctv->name) }}" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="location_id" class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                <select name="location_id" id="location_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Pilih Lokasi</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}" {{ old('location_id', $cctv->location_id) == $location->id ? 'selected' : '' }}>
                            {{ $location->name }} - {{ $location->kecamatan }}
                        </option>
                    @endforeach
                </select>
                @error('location_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="camera_type" class="block text-sm font-medium text-gray-700 mb-2">Tipe Kamera</label>
                <select name="camera_type" id="camera_type" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="PTZ" {{ old('camera_type', $cctv->camera_type) == 'PTZ' ? 'selected' : '' }}>PTZ</option>
                    <option value="Fix" {{ old('camera_type', $cctv->camera_type) == 'Fix' ? 'selected' : '' }}>Fix</option>
                </select>
                @error('camera_type')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" id="status" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="Active" {{ old('status', $cctv->status) == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ old('status', $cctv->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="rtsp_url" class="block text-sm font-medium text-gray-700 mb-2">RTSP URL</label>
                <input type="url" name="rtsp_url" id="rtsp_url" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('rtsp_url', $cctv->rtsp_url) }}">
                @error('rtsp_url')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="hls_url" class="block text-sm font-medium text-gray-700 mb-2">HLS URL</label>
                <input type="url" name="hls_url" id="hls_url" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('hls_url', $cctv->hls_url) }}">
                @error('hls_url')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.cctvs.index') }}" 
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

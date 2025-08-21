@extends('admin.layout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Lokasi</h1>
        
        <form action="{{ url('/admin/locations/' . $location->id) }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-2">Kecamatan</label>
                <input type="text" name="kecamatan" id="kecamatan" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('kecamatan', $location->kecamatan) }}" required>
                @error('kecamatan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lokasi</label>
                <input type="text" name="name" id="name" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('name', $location->name) }}" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">Latitude</label>
                <input type="number" step="any" name="latitude" id="latitude" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('latitude', $location->latitude) }}" required>
                @error('latitude')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2">Longitude</label>
                <input type="number" step="any" name="longitude" id="longitude" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('longitude', $location->longitude) }}" required>
                @error('longitude')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ url('/admin/locations') }}" 
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

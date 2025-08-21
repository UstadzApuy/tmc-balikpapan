@extends('admin.layout')

@section('title', 'Edit Berita - TMC Balikpapan')
@section('page-title', 'Edit Berita')

@section('content')
<div class="px-4 py-6 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Edit Berita
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Perbarui informasi berita yang ada.
            </p>
        </div>
        <div class="mt-5 sm:mt-0">
            <a href="{{ route('admin.news.index') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="mt-6 bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('admin.news.update', $news->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-6">
                    <div class="sm:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700">
                            Judul Berita
                        </label>
                        <div class="mt-1">
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   value="{{ old('title', $news->title) }}"
                                   class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                   placeholder="Masukkan judul berita"
                                   required>
                        </div>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="content" class="block text-sm font-medium text-gray-700">
                            Konten Berita
                        </label>
                        <div class="mt-1">
                            <textarea id="content" 
                                      name="content" 
                                      rows="6"
                                      class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                      placeholder="Masukkan konten berita"
                                      required>{{ old('content', $news->content) }}</textarea>
                        </div>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="weather_condition" class="block text-sm font-medium text-gray-700">
                            Kondisi Cuaca
                        </label>
                        <div class="mt-1">
                            <select id="weather_condition" 
                                    name="weather_condition" 
                                    class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                    required>
                                <option value="hujan" {{ old('weather_condition', $news->weather_condition) == 'hujan' ? 'selected' : '' }}>Hujan</option>
                                <option value="banjir" {{ old('weather_condition', $news->weather_condition) == 'banjir' ? 'selected' : '' }}>Banjir</option>
                                <option value="kemacetan" {{ old('weather_condition', $news->weather_condition) == 'kemacetan' ? 'selected' : '' }}>Kemacetan</option>
                                <option value="kepadatan" {{ old('weather_condition', $news->weather_condition) == 'kepadatan' ? 'selected' : '' }}>Kepadatan</option>
                                <option value="normal" {{ old('weather_condition', $news->weather_condition) == 'normal' ? 'selected' : '' }}>Normal</option>
                                <option value="info" {{ old('weather_condition', $news->weather_condition) == 'info' ? 'selected' : '' }}>Info</option>
                            </select>
                        </div>
                        @error('weather_condition')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Status Berita
                        </label>
                        <div class="mt-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" 
                                       name="is_active" 
                                       value="1" 
                                       class="rounded border-gray-300 text-green-600 focus:ring-green-500"
                                       {{ old('is_active', $news->is_active) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">Aktifkan berita</span>
                            </label>
                        </div>
                        @error('is_active')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('admin.news.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Perbarui Berita
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

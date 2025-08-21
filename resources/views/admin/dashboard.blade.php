@extends('admin.layout')

@section('title', 'Admin Dashboard - TMC Balikpapan')
@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
    <!-- Total Locations -->
    <div class="bg-white overflow-hidden shadow-lg rounded-xl">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500 truncate">Total Lokasi</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalLocations ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Total CCTV -->
    <div class="bg-white overflow-hidden shadow-lg rounded-xl">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-.553.894l-5 2.5a1 1 0 01-.894 0l-5-2.5A1 1 0 019 15.382V8.618a1 1 0 01.553-.894l5-2.5a1 1 0 01.894 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500 truncate">Total CCTV</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalCctvs ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Contacts -->
    <div class="bg-white overflow-hidden shadow-lg rounded-xl">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500 truncate">Total Kontak</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalContacts ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- News Selection Widget -->
<div class="mt-8">
    <div class="bg-white shadow-lg rounded-xl">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Pengaturan Berita Topbar</h3>
            
            <form id="newsSelectionForm" method="POST" action="{{ route('admin.dashboard.update-news') }}">
                @csrf
                
                <!-- News Selection -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Berita</label>
                    <select name="news_id" id="news_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- Pilih Berita --</option>
                        @foreach($news as $item)
                            <option value="{{ $item->id }}" 
                                    {{ session('selected_news_id') == $item->id ? 'selected' : '' }}
                                    data-title="{{ $item->title }}">
                                {{ $item->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Location Selection -->
                <div id="locationSection" class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cakupan Lokasi</label>
                    
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="radio" name="scope" value="city" class="mr-2" 
                                {{ session('selected_scope') == 'city' ? 'checked' : '' }}>
                            <span>Seluruh Kota Balikpapan</span>
                        </label>
                        
                        <label class="flex items-center">
                            <input type="radio" name="scope" value="kecamatan" class="mr-2"
                                {{ session('selected_scope') == 'kecamatan' ? 'checked' : '' }}>
                            <span>Berdasarkan Kecamatan</span>
                        </label>
                        
                        <label class="flex items-center">
                            <input type="radio" name="scope" value="area" class="mr-2"
                                {{ session('selected_scope') == 'area' ? 'checked' : '' }}>
                            <span>Lokasi Tertentu</span>
                        </label>
                    </div>

                    <!-- Kecamatan Selection -->
                    <div id="kecamatanSection" class="mt-3 hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Kecamatan</label>
                        <select name="kecamatan_id[]" id="kecamatan_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" multiple>
                            @foreach($locations as $kecamatan => $locationsInKecamatan)
                                <option value="{{ $kecamatan }}" 
                                    {{ in_array($kecamatan, session('selected_kecamatan', [])) ? 'selected' : '' }}>
                                    {{ $kecamatan }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Gunakan Ctrl/Cmd+click untuk memilih multiple</p>
                    </div>

                    <!-- Location Selection -->
                    <div id="locationSpecificSection" class="mt-3 hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Lokasi</label>
                        <select name="location_ids[]" id="location_ids" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" multiple>
                            @foreach($locations as $kecamatan => $locationsInKecamatan)
                                <optgroup label="{{ $kecamatan }}">
                                    @foreach($locationsInKecamatan as $location)
                                        <option value="{{ $location->id }}" 
                                            {{ in_array($location->id, session('selected_locations', [])) ? 'selected' : '' }}>
                                            {{ $location->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Gunakan Ctrl/Cmd+click untuk memilih multiple</p>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- CCTV Distribution by Kecamatan -->
<div class="mt-8">
    <div class="bg-white shadow-lg rounded-xl">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Distribusi CCTV per Kecamatan</h3>
            <div class="space-y-3">
                @foreach($cctvsPerKecamatan as $kecamatan)
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                        <div>
                            <p class="text-sm text-gray-900">{{ $kecamatan->kecamatan }}</p>
                            <p class="text-xs text-gray-500">CCTV: {{ $kecamatan->total_cctv }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const newsSelect = document.getElementById('news_id');
    const scopeRadios = document.querySelectorAll('input[name="scope"]');
    const kecamatanSection = document.getElementById('kecamatanSection');
    const locationSpecificSection = document.getElementById('locationSpecificSection');
    const locationSection = document.getElementById('locationSection');

    // Handle news selection change
    newsSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const newsTitle = selectedOption.getAttribute('data-title');
        
        if (newsTitle === 'Informasi Aplikasi TMC Balikpapan') {
            // Hide location selection for "Informasi Aplikasi TMC Balikpapan"
            locationSection.style.display = 'none';
            // Clear scope selection
            scopeRadios.forEach(radio => radio.checked = false);
            kecamatanSection.style.display = 'none';
            locationSpecificSection.style.display = 'none';
        } else {
            // Show location selection for other news
            locationSection.style.display = 'block';
        }
    });

    // Handle scope selection change
    scopeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            const scope = this.value;
            
            kecamatanSection.style.display = scope === 'kecamatan' ? 'block' : 'none';
            locationSpecificSection.style.display = scope === 'area' ? 'block' : 'none';
        });
    });

    // Initial state
    const selectedNews = newsSelect.options[newsSelect.selectedIndex];
    if (selectedNews && selectedNews.getAttribute('data-title') === 'Informasi Aplikasi TMC Balikpapan') {
        locationSection.style.display = 'none';
        scopeRadios.forEach(radio => radio.checked = false);
        kecamatanSection.style.display = 'none';
        locationSpecificSection.style.display = 'none';
    } else {
        locationSection.style.display = 'block';
    }

    // Trigger change for initial scope
    const checkedScope = document.querySelector('input[name="scope"]:checked');
    if (checkedScope) {
        checkedScope.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection
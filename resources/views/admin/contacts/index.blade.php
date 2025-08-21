@extends('admin.layout')

@section('content')
<div class="container mx-auto px-4 py-4 sm:py-8">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 sm:mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2 sm:mb-0">Preview Kontak</h1>
        <p class="text-sm sm:text-base text-gray-600">Preview tampilan kontak yang akan muncul di halaman publik</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Preview Section -->
    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-6 sm:mb-8">
        <h2 class="text-lg sm:text-xl font-semibold mb-3 sm:mb-4">Preview Tampilan</h2>
        
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-4 sm:mb-6">
                <img src="{{ asset('images/logo/dishub.png') }}" 
                     alt="Logo Dishub Balikpapan" 
                     class="mx-auto w-20 h-20 sm:w-24 sm:h-24 mb-2 sm:mb-3">
                
                <h3 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-800 mb-2 px-2">
                    DINAS PERHUBUNGAN KOTA BALIKPAPAN
                </h3>
                
                <p class="text-sm sm:text-base text-gray-600 px-2">
                    Apabila anda mempunyai aduan, pertanyaan, saran atau keluhan atas penyelenggaraan pelayanan terkait perhubungan, silahkan sampaikan ke sini :
                </p>
            </div>

            <!-- Contact Buttons Preview -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 mb-4 sm:mb-6">
                @foreach($contacts as $contact)
                    <div class="group bg-white border border-gray-200 rounded-lg p-3 sm:p-4 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center space-x-2 sm:space-x-3">
                            <div class="bg-blue-100 rounded-full p-2">
                                @if($contact->type === 'phone')
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                @elseif($contact->type === 'email')
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                @elseif($contact->name === 'X (Twitter)')
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                    </svg>
                                @elseif($contact->name === 'Facebook')
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                @elseif($contact->name === 'Instagram')
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                @endif
                            </div>
                            
                            <div>
                                <h4 class="font-semibold text-gray-800 text-sm sm:text-base">{{ $contact->name }}</h4>
                                <p class="text-xs sm:text-sm text-gray-600">{{ $contact->value }}</p>
                            </div>
                            
                            <!-- Edit Button -->
                            <a href="{{ route('admin.contacts.edit', $contact) }}" 
                               class="ml-auto bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 sm:px-3 sm:py-1 rounded text-xs sm:text-sm">
                                Edit
                            </a>
                        </div>
                        
                    </div>
                @endforeach
            </div>

            <!-- Address Preview -->
            <div class="bg-gray-50 rounded-lg p-3 sm:p-4 mt-3 sm:mt-4">
                <h4 class="text-sm sm:text-base font-semibold text-gray-800 mb-1 sm:mb-2">Kantor:</h4>
                <p class="text-xs sm:text-sm text-gray-600">
                    Jl. Praja Bakti, Sepinggan, Balikpapan Sel., Kota Balikpapan, Kalimantan Timur 76115
                </p>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script>
// Optional: Add modal functionality for inline editing
function openEditModal(contactId) {
    // You can implement modal here if needed
    window.location.href = `/admin/contacts/${contactId}/edit`;
}
</script>
@endsection

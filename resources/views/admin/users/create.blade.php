@extends('admin.layout')

@section('title', 'Tambah User - Admin TMC')
@section('page-title', 'Tambah User Baru')

@section('content')
<div class="bg-white shadow-sm rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">
            Tambah User Baru
        </h3>

        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" name="name" id="name" 
                       class="mt-1 focus:ring-[#30318B] focus:border-[#30318B] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                       value="{{ old('name') }}" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username" 
                       class="mt-1 focus:ring-[#30318B] focus:border-[#30318B] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                       value="{{ old('username') }}" required>
                @error('username')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" 
                       class="mt-1 focus:ring-[#30318B] focus:border-[#30318B] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                       required>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" 
                       class="mt-1 focus:ring-[#30318B] focus:border-[#30318B] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                       required>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.users.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#30318B] hover:bg-[#FEC800] hover:text-black">
                    Simpan User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

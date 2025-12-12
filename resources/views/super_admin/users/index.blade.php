@extends('super_admin.layout')

@section('content')
<div class="p-4 xl:ml-0">
    {{-- HEADER --}}
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Kelola User</h2>
            <p class="text-sm font-semibold text-gray-600">
                Kelola semua user yang terdaftar di sistem
            </p>
        </div>
        <a href="{{ route('super_admin.users.create') }}" class="flex items-center gap-2 px-4 py-2.5 bg-linear-to-tr from-blue-600 to-blue-400 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah User
        </a>
    </div>

    {{-- TABLE USER --}}
    <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
        <div class="p-6 overflow-x-auto">
            @if($users->count() > 0)
                <table class="w-full min-w-max table-auto text-left">
                    <thead>
                        <tr>
                            <th class="border-b border-gray-200 bg-gray-50 p-4">
                                <p class="text-sm font-semibold text-gray-900">Nama</p>
                            </th>
                            <th class="border-b border-gray-200 bg-gray-50 p-4">
                                <p class="text-sm font-semibold text-gray-900">Email</p>
                            </th>
                            <th class="border-b border-gray-200 bg-gray-50 p-4 text-center">
                                <p class="text-sm font-semibold text-gray-900">Role</p>
                            </th>
                            <th class="border-b border-gray-200 bg-gray-50 p-4">
                                <p class="text-sm font-semibold text-gray-900">Toko</p>
                            </th>
                            <th class="border-b border-gray-200 bg-gray-50 p-4 text-center">
                                <p class="text-sm font-semibold text-gray-900">Terdaftar</p>
                            </th>
                            <th class="border-b border-gray-200 bg-gray-50 p-4 text-center">
                                <p class="text-sm font-semibold text-gray-900">Aksi</p>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="p-4 border-b border-gray-200">
                                    <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                                </td>
                                <td class="p-4 border-b border-gray-200">
                                    <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                </td>
                                <td class="p-4 border-b border-gray-200 text-center">
                                    @if($user->role === 'super_admin')
                                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">
                                            Super Admin
                                        </span>
                                    @elseif($user->role === 'admin')
                                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-orange-100 text-orange-800">
                                            Admin Toko
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800">
                                            Kasir
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 border-b border-gray-200">
                                    <p class="text-sm text-gray-600">
                                        {{ $user->toko ? $user->toko->nama_toko : '-' }}
                                    </p>
                                </td>
                                <td class="p-4 border-b border-gray-200 text-center">
                                    <p class="text-xs text-gray-500">
                                        {{ $user->created_at->format('d M Y') }}
                                    </p>
                                </td>
                                <td class="p-4 border-b border-gray-200">
                                    <div class="flex justify-center gap-2">
                                        {{-- TOMBOL EDIT --}}
                                        <a href="{{ route('super_admin.users.edit', $user->id) }}" class="px-3 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </a>
                                        
                                        {{-- TOMBOL DELETE --}}
                                        <form action="{{ route('super_admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- PAGINATION --}}
                <div class="mt-6">
                    {{ $users->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-gray-300 mb-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                    <p class="text-gray-500 font-semibold">Belum ada user terdaftar</p>
                    <p class="text-sm text-gray-400 mt-2">Klik tombol "Tambah User" untuk menambahkan user baru</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
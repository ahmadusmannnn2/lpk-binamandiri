<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Kelola Materi Kelas: ') }} {{ $kelas->nama_kelas }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="md:col-span-1">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-oranye p-6">
                    <h3 class="font-bold text-lg mb-4 border-b pb-2">Upload Materi Baru</h3>
                    
                    @if(session('success'))
                        <div class="text-green-600 text-sm font-bold mb-4">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('instruktur.materi.store', $kelas->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="judul_materi" :value="__('Judul Materi')" />
                            <x-text-input id="judul_materi" class="block mt-1 w-full text-sm" type="text" name="judul_materi" required />
                        </div>
                        <div>
                            <x-input-label for="deskripsi" :value="__('Deskripsi Singkat')" />
                            <textarea id="deskripsi" name="deskripsi" rows="2" class="block mt-1 w-full border-gray-300 rounded text-sm"></textarea>
                        </div>
                        <div>
                            <x-input-label for="file_materi" :value="__('File (PDF/ZIP/PPT, Max 5MB)')" />
                            <input id="file_materi" type="file" name="file_materi" class="block w-full text-sm mt-1 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-gray-200" required/>
                        </div>
                        <button type="submit" class="w-full bg-hitam text-white py-2 rounded hover:bg-oranye font-bold transition">Upload File</button>
                    </form>
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-hitam p-6">
                    <h3 class="font-bold text-lg mb-4 border-b pb-2">Daftar Materi yang Diunggah</h3>
                    
                    <div class="space-y-4">
                        @forelse($materi as $item)
                            <div class="flex items-center justify-between p-4 bg-gray-50 border rounded-lg">
                                <div>
                                    <h4 class="font-bold text-oranye">{{ $item->judul_materi }}</h4>
                                    <p class="text-xs text-gray-500 mt-1">{{ $item->deskripsi }}</p>
                                    <p class="text-xs text-gray-400 mt-2">Diunggah: {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ asset('storage/' . $item->file_materi) }}" target="_blank" class="text-blue-500 hover:underline text-sm font-bold">Lihat File</a>
                                    <span class="text-gray-300">|</span>
                                    <form action="{{ route('instruktur.materi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus materi ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline text-sm font-bold">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-6 italic">Belum ada materi yang diunggah untuk kelas ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
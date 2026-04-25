<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Buat Kelas Baru') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-oranye">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('admin.kelas.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="nama_kelas" :value="__('Nama Kelas (Misal: Angkatan 1 - Pagi)')" class="text-hitam font-bold" />
                                    <x-text-input id="nama_kelas" class="block mt-1 w-full focus:ring-oranye focus:border-oranye" type="text" name="nama_kelas" :value="old('nama_kelas')" required />
                                </div>
                                <div>
                                    <x-input-label for="program_pelatihan_id" :value="__('Pilih Program Pelatihan')" class="text-hitam font-bold" />
                                    <select name="program_pelatihan_id" id="program_pelatihan_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-oranye focus:ring-oranye" required>
                                        <option value="">-- Pilih Program --</option>
                                        @foreach($program as $prog)
                                            <option value="{{ $prog->id }}">{{ $prog->nama_program }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="instruktur_id" :value="__('Pilih Instruktur')" class="text-hitam font-bold" />
                                    <select name="instruktur_id" id="instruktur_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-oranye focus:ring-oranye" required>
                                        <option value="">-- Pilih Instruktur --</option>
                                        @foreach($instruktur as $ins)
                                            <option value="{{ $ins->id }}">{{ $ins->user->name }} ({{ $ins->spesialisasi_las }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="kuota_peserta" :value="__('Kuota Peserta')" class="text-hitam font-bold" />
                                    <x-text-input id="kuota_peserta" class="block mt-1 w-full focus:ring-oranye focus:border-oranye" type="number" name="kuota_peserta" :value="old('kuota_peserta', 20)" required />
                                </div>
                                <div>
                                    <x-input-label for="tanggal_mulai" :value="__('Tanggal Mulai')" class="text-hitam font-bold" />
                                    <x-text-input id="tanggal_mulai" class="block mt-1 w-full focus:ring-oranye focus:border-oranye" type="date" name="tanggal_mulai" :value="old('tanggal_mulai')" required />
                                </div>
                                <div>
                                    <x-input-label for="tanggal_selesai" :value="__('Tanggal Selesai')" class="text-hitam font-bold" />
                                    <x-text-input id="tanggal_selesai" class="block mt-1 w-full focus:ring-oranye focus:border-oranye" type="date" name="tanggal_selesai" :value="old('tanggal_selesai')" required />
                                </div>
                                <div>
                                    <x-input-label for="status_kelas" :value="__('Status Kelas')" class="text-hitam font-bold" />
                                    <select name="status_kelas" id="status_kelas" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-oranye focus:ring-oranye" required>
                                        <option value="menunggu">Menunggu</option>
                                        <option value="berjalan">Berjalan</option>
                                        <option value="selesai">Selesai</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 space-x-4">
                            <a href="{{ route('admin.kelas.index') }}" class="text-gray-500 hover:text-hitam font-semibold transition">Batal</a>
                            <button type="submit" class="bg-hitam text-white px-8 py-3 rounded-lg hover:bg-oranye transition duration-300 transform hover:-translate-y-1 shadow-lg font-bold">
                                Simpan Kelas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
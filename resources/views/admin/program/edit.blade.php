<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">
            {{ __('Edit Program Pelatihan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-oranye">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('admin.program.update', $program->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <x-input-label for="nama_program" :value="__('Nama Program Pelatihan')" class="text-hitam font-bold" />
                            <x-text-input id="nama_program" class="block mt-1 w-full focus:border-oranye focus:ring-oranye rounded-xl" type="text" name="nama_program" value="{{ old('nama_program', $program->nama_program) }}" required autofocus />
                            <x-input-error :messages="$errors->get('nama_program')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="harga_pelatihan" :value="__('Harga Pelatihan (Rp)')" class="text-hitam font-bold" />
                                <x-text-input id="harga_pelatihan" class="block mt-1 w-full focus:border-oranye focus:ring-oranye rounded-xl" type="number" name="harga_pelatihan" value="{{ old('harga_pelatihan', $program->harga_pelatihan) }}" required />
                                <x-input-error :messages="$errors->get('harga_pelatihan')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="durasi_hari" :value="__('Durasi Kelas (Hari Kerja)')" class="text-hitam font-bold" />
                                <x-text-input id="durasi_hari" class="block mt-1 w-full focus:border-oranye focus:ring-oranye rounded-xl" type="number" name="durasi_hari" value="{{ old('durasi_hari', $program->durasi_hari) }}" required />
                                <x-input-error :messages="$errors->get('durasi_hari')" class="mt-2" />
                            </div>
                        </div>

                        <div class="bg-orange-50 p-5 rounded-xl border border-orange-100">
                            <x-input-label for="parameter_penilaian" :value="__('Parameter Penilaian (Pisahkan dengan koma)')" class="text-oranye font-black text-lg mb-2" />
                            
                            <p class="text-sm text-gray-700 mb-3 font-medium">
                                Masukkan daftar kriteria kompetensi yang akan dinilai oleh instruktur pada akhir kelas. Setiap kriteria <strong>harus dipisahkan dengan tanda koma ( , )</strong>. Parameter ini akan muncul sebagai kolom penilaian di akun instruktur dan akan dicetak pada bagian belakang sertifikat.
                            </p>
                            
                            <x-text-input id="parameter_penilaian" class="block mt-2 w-full focus:border-oranye focus:ring-oranye rounded-xl border-orange-200" type="text" name="parameter_penilaian" value="{{ old('parameter_penilaian', is_array($program->parameter_penilaian) ? implode(', ', $program->parameter_penilaian) : '') }}" placeholder="Ketik di sini... (Pisahkan dengan koma)" required />
                            <x-input-error :messages="$errors->get('parameter_penilaian')" class="mt-2" />

                            <div class="mt-4 bg-white p-4 rounded-lg border border-orange-200 shadow-sm">
                                <span class="font-bold text-gray-800 text-sm block mb-2 underline decoration-oranye decoration-2 underline-offset-4">Contoh Pengisian Berdasarkan Program:</span>
                                
                                <ul class="list-disc pl-5 text-sm text-gray-600 space-y-1 mt-2">
                                    <li><strong>Program Pengelasan Dasar:</strong> <span class="italic text-gray-500">1F, 2F, 3F, Teori Dasar Las, Praktik K3</span></li>
                                    <li><strong>Program Sertifikasi SMAW:</strong> <span class="italic text-gray-500">1G, 2G, 3G, 4G, Inspeksi Visual (VT)</span></li>
                                    <li><strong>Program Pipe Welding (GTAW):</strong> <span class="italic text-gray-500">2G (Pipe), 5G (Pipe), 6G (Pipe), Pemahaman Blueprint</span></li>
                                    <li><strong>Program Umum (Selain Las):</strong> <span class="italic text-gray-500">Kehadiran Aktif, Ujian Tengah Semester, Ujian Praktik Akhir, Sikap & Etika</span></li>
                                </ul>
                            </div>
                        </div>

                        <div>
                            <x-input-label for="deskripsi" :value="__('Deskripsi Program')" class="text-hitam font-bold" />
                            <textarea id="deskripsi" name="deskripsi" rows="4" class="block mt-1 w-full border-gray-300 rounded-xl shadow-sm focus:border-oranye focus:ring-oranye">{{ old('deskripsi', $program->deskripsi) }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-100 space-x-4">
                            <a href="{{ route('admin.program.index') }}" class="text-gray-500 hover:text-hitam font-bold transition">Batal</a>
                            <button type="submit" class="bg-hitam text-white px-8 py-3 rounded-xl hover:bg-oranye transition duration-300 transform hover:-translate-y-1 shadow-lg font-bold">
                                Perbarui Program
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
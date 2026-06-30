<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ url()->previous() }}" class="text-gray-500 hover:text-oranye transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-hitam leading-tight">
                {{ __('Edit Data Instruktur') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-oranye">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('admin.instruktur.update', $instruktur->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            
                            <div class="space-y-5 bg-gray-50 p-6 rounded-2xl border border-gray-200 shadow-sm relative overflow-hidden">
                                <div class="absolute -right-4 -top-4 opacity-5 pointer-events-none">
                                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                </div>
                                
                                <h3 class="font-black text-xl border-b border-gray-200 pb-3 text-hitam">Informasi Akun (Login)</h3>
                                
                                <div class="relative z-10">
                                    <x-input-label for="name" :value="__('Nama Lengkap (Sesuai Gelar)')" class="text-hitam font-bold text-sm" />
                                    <x-text-input id="name" class="block mt-1 w-full focus:border-oranye focus:ring-oranye rounded-xl transition shadow-sm" type="text" name="name" value="{{ old('name', $instruktur->user->name) }}" required />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                <div class="relative z-10">
                                    <x-input-label for="email" :value="__('Alamat Email')" class="text-hitam font-bold text-sm" />
                                    <x-text-input id="email" class="block mt-1 w-full focus:border-oranye focus:ring-oranye rounded-xl transition shadow-sm" type="email" name="email" value="{{ old('email', $instruktur->user->email) }}" required />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                                
                                <div class="mt-6 pt-5 border-t border-gray-200 relative z-10">
                                    <p class="text-xs text-gray-500 mb-3 font-bold uppercase tracking-wider bg-gray-200/50 inline-block px-2 py-1 rounded">⚠️ Update Keamanan</p>
                                    <p class="text-xs text-gray-500 mb-3 italic">Kosongkan kolom kata sandi di bawah jika Anda tidak ingin mengubahnya.</p>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <x-input-label for="password" :value="__('Kata Sandi Baru (Opsional)')" class="text-hitam font-bold text-sm" />
                                            <x-text-input id="password" class="block mt-1 w-full focus:border-oranye focus:ring-oranye rounded-xl transition shadow-sm" type="password" name="password" placeholder="••••••••" />
                                        </div>
                                        <div>
                                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Sandi Baru')" class="text-hitam font-bold text-sm" />
                                            <x-text-input id="password_confirmation" class="block mt-1 w-full focus:border-oranye focus:ring-oranye rounded-xl transition shadow-sm" type="password" name="password_confirmation" placeholder="••••••••" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-5 bg-orange-50 p-6 rounded-2xl border border-orange-100 shadow-sm relative overflow-hidden">
                                <div class="absolute -right-4 -top-4 opacity-10 pointer-events-none">
                                    <svg class="w-32 h-32 text-oranye" fill="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>

                                <h3 class="font-black text-xl border-b border-orange-200 pb-3 text-oranye">Data Instruktur</h3>
                                
                                <div class="relative z-10">
                                    <x-input-label for="keahlian" :value="__('Spesialisasi Keahlian (Program)')" class="text-hitam font-bold text-sm" />
                                    <select id="keahlian" name="keahlian" class="block mt-1 w-full border-white rounded-xl shadow-sm focus:border-oranye focus:ring-oranye transition p-2.5 text-sm" required>
                                        <option value="" disabled>-- Pilih Program Pelatihan --</option>
                                        @foreach($programs as $program)
                                            <option value="{{ $program->nama_program }}" {{ old('keahlian', $instruktur->keahlian) == $program->nama_program ? 'selected' : '' }}>
                                                {{ $program->nama_program }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('keahlian')" class="mt-2" />
                                </div>
                                <div class="relative z-10">
                                    <x-input-label for="nomor_telepon" :value="__('Nomor WhatsApp / HP')" class="text-hitam font-bold text-sm" />
                                    <x-text-input id="nomor_telepon" class="block mt-1 w-full focus:border-oranye focus:ring-oranye rounded-xl transition shadow-sm border-white" type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $instruktur->nomor_telepon) }}" />
                                </div>
                                <div class="relative z-10">
                                    <x-input-label for="alamat" :value="__('Alamat Lengkap')" class="text-hitam font-bold text-sm" />
                                    <textarea id="alamat" name="alamat" rows="4" class="block mt-1 w-full border-white rounded-xl shadow-sm focus:border-oranye focus:ring-oranye transition p-3 text-sm">{{ old('alamat', $instruktur->alamat) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-10 pt-6 border-t border-gray-100 gap-4">
                            <a href="{{ route('admin.instruktur.index') }}" class="text-gray-500 hover:text-hitam font-bold transition px-4 py-2 rounded-lg hover:bg-gray-100">Batal</a>
                            <button type="submit" class="bg-hitam text-white px-8 py-3.5 rounded-xl hover:bg-oranye transition duration-300 transform hover:-translate-y-1 shadow-lg font-bold flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                Perbarui Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
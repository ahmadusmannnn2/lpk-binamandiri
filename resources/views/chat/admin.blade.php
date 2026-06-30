<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">
            {{ __('Pusat Obrolan (Live Chat)') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-hitam flex flex-col md:flex-row h-[75vh]">
                
                <!-- SIDEBAR: DAFTAR KONTAK -->
                <div class="w-full md:w-1/3 border-r border-gray-100 flex flex-col h-full bg-white">
                    <div class="p-4 border-b border-gray-100 shrink-0">
                        <h3 class="font-black text-hitam text-lg">Pesan Masuk</h3>
                        <p class="text-xs text-gray-500 font-medium">Klik pada peserta untuk membalas</p>
                    </div>
                    <div class="flex-1 overflow-y-auto">
                        @forelse($kontak as $k)
                            <a href="{{ route('chat.index', ['user_id' => $k->id]) }}" class="block p-4 border-b border-gray-50 hover:bg-orange-50/50 transition relative {{ $aktifUser && $aktifUser->id == $k->id ? 'bg-orange-50/50' : '' }}">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center font-bold text-gray-500 shrink-0">
                                        {{ substr($k->name, 0, 1) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-center mb-0.5">
                                            <p class="text-sm font-bold text-hitam truncate">{{ $k->name }}</p>
                                        </div>
                                        <p class="text-xs text-gray-500 truncate">{{ $k->email }}</p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="p-6 text-center text-sm text-gray-400">Belum ada peserta terdaftar.</div>
                        @endforelse
                    </div>
                </div>

                <!-- CHAT BOX UTAMA -->
                <div class="w-full md:w-2/3 flex flex-col h-full bg-gray-50/30">
                    @if($aktifUser)
                        <!-- Header Chat -->
                        <div class="bg-white border-b border-gray-100 p-4 flex items-center gap-4 shrink-0 shadow-sm">
                            <div class="w-10 h-10 bg-hitam rounded-full flex items-center justify-center text-white font-bold shrink-0">
                                {{ substr($aktifUser->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-black text-hitam text-base">{{ $aktifUser->name }}</h3>
                                <p class="text-[11px] text-gray-500 font-bold uppercase tracking-wider">{{ $aktifUser->peserta->nik ?? 'Calon Peserta' }}</p>
                            </div>
                        </div>

                        <!-- Chat Body -->
                        <div id="chat-body" class="flex-1 overflow-y-auto p-6 space-y-4">
                            <div class="text-center text-gray-400 text-sm py-4" id="loading-indicator">Memuat obrolan...</div>
                        </div>

                        <!-- Chat Footer -->
                        <div class="bg-white border-t border-gray-100 p-4 shrink-0">
                            <form id="chat-form" class="flex gap-2">
                                @csrf
                                <input type="hidden" id="penerima_id" value="{{ $aktifUser->id }}">
                                <input type="text" id="pesan_input" class="flex-1 rounded-xl border-gray-200 focus:border-hitam focus:ring focus:ring-gray-200 transition bg-gray-50 text-sm" placeholder="Balas pesan ${aktifUser->name}..." required autocomplete="off">
                                <button type="submit" class="bg-oranye hover:bg-[#c24b22] text-white p-3 rounded-xl transition shadow flex items-center justify-center" id="btn-send">
                                    <svg class="w-5 h-5 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex-1 flex flex-col items-center justify-center text-gray-400 p-8 text-center">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                            </div>
                            <h3 class="font-bold text-gray-500 mb-1">Tidak Ada Obrolan Dipilih</h3>
                            <p class="text-sm">Pilih peserta dari daftar di sebelah kiri untuk mulai membaca dan membalas pesan.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <!-- Script AJAX Polling Chat (Khusus Admin) -->
    @if($aktifUser)
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userId = document.getElementById('penerima_id').value;
            const chatBody = document.getElementById('chat-body');
            const chatForm = document.getElementById('chat-form');
            const pesanInput = document.getElementById('pesan_input');
            const btnSend = document.getElementById('btn-send');
            
            let lastMessageCount = 0;

            function renderMessages(messages) {
                if (messages.length === lastMessageCount) return;
                lastMessageCount = messages.length;
                
                chatBody.innerHTML = '';
                
                if (messages.length === 0) {
                    chatBody.innerHTML = '<div class="text-center text-gray-400 text-sm py-4">Belum ada obrolan dengan peserta ini.</div>';
                    return;
                }

                messages.forEach(msg => {
                    const isMe = msg.is_saya;
                    const alignClass = isMe ? 'justify-end' : 'justify-start';
                    const bubbleBg = isMe ? 'bg-hitam text-white shadow-md' : 'bg-white border border-gray-100 text-gray-800 shadow-sm';
                    const radiusClass = isMe ? 'rounded-2xl rounded-tr-sm' : 'rounded-2xl rounded-tl-sm';
                    
                    let cardHtml = '';
                    if (msg.kelas) {
                        const img = msg.kelas.gambar ? `<img src="${msg.kelas.gambar}" class="w-full h-24 object-cover rounded-t-xl">` : '';
                        cardHtml = `
                        <div class="mt-2 w-56 bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden text-left mb-2">
                            ${img}
                            <div class="p-2 bg-gray-50">
                                <p class="text-[9px] font-bold text-oranye uppercase tracking-wider">${msg.kelas.nama_program}</p>
                                <p class="text-xs font-black text-gray-800 leading-tight mt-0.5 line-clamp-2">${msg.kelas.nama_kelas}</p>
                            </div>
                        </div>`;
                    }

                    const tickHtml = isMe ? (msg.dibaca ? '<span class="text-blue-300 ml-1">✓✓</span>' : '<span class="text-gray-400 ml-1">✓</span>') : '';

                    const html = `
                    <div class="flex w-full ${alignClass}">
                        <div class="max-w-[75%]">
                            <div class="${bubbleBg} ${radiusClass} p-3 text-sm">
                                ${cardHtml}
                                ${msg.pesan}
                            </div>
                            <div class="text-[10px] text-gray-400 mt-1 ${isMe ? 'text-right' : 'text-left'}">
                                ${msg.waktu} ${tickHtml}
                            </div>
                        </div>
                    </div>`;
                    
                    chatBody.insertAdjacentHTML('beforeend', html);
                });

                chatBody.scrollTop = chatBody.scrollHeight;
            }

            function fetchMessages(markRead = true) {
                fetch(`{{ url('chat/messages') }}/${userId}?mark_read=${markRead}`)
                    .then(response => {
                        if (!response.ok) throw new Error("Gagal mengambil pesan");
                        return response.json();
                    })
                    .then(data => renderMessages(data))
                    .catch(err => console.error("Error fetching messages:", err));
            }

            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const text = pesanInput.value.trim();
                if (!text) return;

                btnSend.disabled = true;
                btnSend.innerHTML = '...';

                const csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : document.querySelector('input[name="_token"]').value;

                fetch(`{{ url('chat/send') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        penerima_id: userId,
                        pesan: text
                    })
                })
                .then(response => response.json())
                .then(data => {
                    pesanInput.value = '';
                    fetchMessages();
                })
                .finally(() => {
                    btnSend.disabled = false;
                    btnSend.innerHTML = '<svg class="w-5 h-5 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>';
                    pesanInput.focus();
                });
            });

            fetchMessages();
            setInterval(fetchMessages, 3000); // Admin poll tiap 3 detik
        });
    </script>
    @endpush
    @endif
</x-app-layout>

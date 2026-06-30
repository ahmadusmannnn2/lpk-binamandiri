@php
    $admin = \App\Models\User::where('role', 'admin')->first();
    // Hitung pesan yang belum dibaca (opsional)
    $unread = \App\Models\Pesan::where('pengirim_id', $admin->id)->where('penerima_id', Auth::id())->whereNull('dibaca_pada')->count();
@endphp

@if($admin)
<div x-data="{ chatOpen: false }" class="fixed bottom-6 right-6 z-[99]">
    
    <!-- Kotak Obrolan (Tampil Saat chatOpen = true) -->
    <div x-show="chatOpen" 
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-10 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-10 scale-95"
         class="bg-white rounded-2xl shadow-2xl mb-4 w-[90vw] sm:w-[400px] border border-gray-100 flex flex-col h-[65vh] sm:h-[500px]" 
         style="display: none;"
         @click.away="chatOpen = false">
        
        <!-- Chat Header -->
        <div class="bg-hitam text-white p-4 flex items-center justify-between rounded-t-2xl shrink-0">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center font-bold text-lg border border-white/30">
                        {{ substr($admin->name, 0, 1) }}
                    </div>
                    <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-hitam rounded-full"></span>
                </div>
                <div>
                    <h3 class="font-bold text-sm tracking-wide">{{ $admin->name }}</h3>
                    <p class="text-[10px] text-gray-300 font-medium">Admin LPK Bina Mandiri</p>
                </div>
            </div>
            <button @click="chatOpen = false" class="text-gray-400 hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Chat Body (Messages) -->
        <div id="fc-chat-body" class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50 text-sm no-scrollbar">
            <div class="text-center text-gray-400 text-xs py-4" id="fc-loading-indicator">Memuat obrolan...</div>
        </div>

        <!-- Chat Footer (Input) -->
        <div class="bg-white border-t border-gray-100 p-3 shrink-0 rounded-b-2xl">
            <form id="fc-chat-form" class="flex gap-2">
                @csrf
                <input type="hidden" id="fc-admin-id" value="{{ $admin->id }}">
                <input type="text" id="fc-pesan-input" class="flex-1 rounded-xl border-gray-200 focus:border-oranye focus:ring focus:ring-orange-200 transition bg-gray-50 text-xs px-4" placeholder="Ketik pesan Anda..." required autocomplete="off">
                <button type="submit" class="bg-hitam hover:bg-oranye text-white p-2.5 rounded-xl transition shadow flex items-center justify-center shrink-0" id="fc-btn-send">
                    <svg class="w-5 h-5 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Tombol Floating (Buka/Tutup) -->
    <button @click="chatOpen = !chatOpen" class="w-14 h-14 bg-oranye hover:bg-[#c24b22] text-white rounded-full shadow-2xl flex items-center justify-center transition-all duration-300 transform hover:scale-110 border-2 border-white/50 absolute bottom-0 right-0">
        <svg x-show="!chatOpen" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
        <svg x-show="chatOpen" style="display: none;" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        
        <!-- Notifikasi Badge Merah -->
        @if($unread > 0)
        <span x-show="!chatOpen" class="absolute -top-1 -right-1 flex h-4 w-4">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-4 w-4 bg-red-600 border border-white text-[9px] font-black items-center justify-center text-white">{{ $unread > 9 ? '9+' : $unread }}</span>
        </span>
        @endif
    </button>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const adminId = document.getElementById('fc-admin-id').value;
        const chatBody = document.getElementById('fc-chat-body');
        const chatForm = document.getElementById('fc-chat-form');
        const pesanInput = document.getElementById('fc-pesan-input');
        const btnSend = document.getElementById('fc-btn-send');
        
        let lastMessageCount = 0;

        function renderMessages(messages) {
            if (messages.length === lastMessageCount) return;
            lastMessageCount = messages.length;
            
            chatBody.innerHTML = '';
            
            if (messages.length === 0) {
                chatBody.innerHTML = '<div class="text-center text-gray-400 text-xs py-4">Belum ada obrolan. Sapa admin sekarang!</div>';
                return;
            }

            messages.forEach(msg => {
                const isMe = msg.is_saya;
                const alignClass = isMe ? 'justify-end' : 'justify-start';
                const bubbleBg = isMe ? 'bg-[#de5e2e] text-white shadow-md' : 'bg-white border border-gray-100 text-gray-800 shadow-sm';
                const radiusClass = isMe ? 'rounded-2xl rounded-tr-sm' : 'rounded-2xl rounded-tl-sm';
                
                let cardHtml = '';
                if (msg.kelas) {
                    const img = msg.kelas.gambar ? `<img src="${msg.kelas.gambar}" class="w-full h-24 object-cover rounded-t-xl">` : '';
                    cardHtml = `
                    <div class="mt-2 w-48 bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden text-left mb-2">
                        ${img}
                        <div class="p-2 bg-gray-50">
                            <p class="text-[9px] font-bold text-[#de5e2e] uppercase tracking-wider">${msg.kelas.nama_program}</p>
                            <p class="text-xs font-black text-gray-800 leading-tight mt-0.5 line-clamp-2">${msg.kelas.nama_kelas}</p>
                        </div>
                    </div>`;
                }

                const tickHtml = isMe ? (msg.dibaca ? '<span class="text-blue-300 ml-1 font-bold">✓✓</span>' : '<span class="text-orange-200 ml-1">✓</span>') : '';

                const html = `
                <div class="flex w-full ${alignClass}">
                    <div class="max-w-[85%]">
                        <div class="${bubbleBg} ${radiusClass} p-3 text-xs leading-relaxed">
                            ${cardHtml}
                            ${msg.pesan}
                        </div>
                        <div class="text-[9px] text-gray-400 mt-1 ${isMe ? 'text-right' : 'text-left'}">
                            ${msg.waktu} ${tickHtml}
                        </div>
                    </div>
                </div>`;
                
                chatBody.insertAdjacentHTML('beforeend', html);
            });

            chatBody.scrollTop = chatBody.scrollHeight;
        }

        function fetchMessages() {
            fetch(`{{ url('chat/messages') }}/${adminId}`)
                .then(response => {
                    if (!response.ok) throw new Error("Gagal");
                    return response.json();
                })
                .then(data => renderMessages(data))
                .catch(err => console.error("Error:", err));
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
                    penerima_id: adminId,
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
        setInterval(fetchMessages, 3000);
    });
</script>
@endpush
@endif

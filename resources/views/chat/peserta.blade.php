<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">
            {{ __('Hubungi Admin LPK') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-oranye flex flex-col h-[70vh]">
                
                <!-- Chat Header -->
                <div class="bg-white border-b border-gray-100 p-4 flex items-center gap-4 shrink-0">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center text-oranye font-bold text-xl">
                        A
                    </div>
                    <div>
                        <h3 class="font-black text-hitam text-lg">Admin LPK Bina Mandiri</h3>
                        <p class="text-xs text-green-500 font-bold flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-green-500 block"></span> Online
                        </p>
                    </div>
                </div>

                <!-- Chat Body (Messages) -->
                <div id="chat-body" class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-50/50">
                    <!-- Loading skeleton -->
                    <div class="text-center text-gray-400 text-sm py-4" id="loading-indicator">Memuat obrolan...</div>
                </div>

                <!-- Chat Footer (Input) -->
                <div class="bg-white border-t border-gray-100 p-4 shrink-0">
                    <form id="chat-form" class="flex gap-2">
                        @csrf
                        <input type="hidden" id="penerima_id" value="{{ $admin->id }}">
                        <input type="text" id="pesan_input" class="flex-1 rounded-xl border-gray-200 focus:border-oranye focus:ring focus:ring-orange-200 transition bg-gray-50 text-sm" placeholder="Ketik pesan Anda..." required autocomplete="off">
                        <button type="submit" class="bg-hitam hover:bg-oranye text-white p-3 rounded-xl transition shadow flex items-center justify-center" id="btn-send">
                            <svg class="w-5 h-5 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Script AJAX Polling Chat -->
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const adminId = document.getElementById('penerima_id').value;
            const chatBody = document.getElementById('chat-body');
            const chatForm = document.getElementById('chat-form');
            const pesanInput = document.getElementById('pesan_input');
            const btnSend = document.getElementById('btn-send');
            
            let lastMessageCount = 0;

            // Fungsi render pesan
            function renderMessages(messages) {
                if (messages.length === lastMessageCount) return; // Tidak ada pesan baru
                lastMessageCount = messages.length;
                
                chatBody.innerHTML = '';
                
                if (messages.length === 0) {
                    chatBody.innerHTML = '<div class="text-center text-gray-400 text-sm py-4">Belum ada obrolan. Mulai sapa admin sekarang!</div>';
                    return;
                }

                messages.forEach(msg => {
                    const isMe = msg.is_saya;
                    const alignClass = isMe ? 'justify-end' : 'justify-start';
                    const bubbleBg = isMe ? 'bg-oranye text-white' : 'bg-white border border-gray-100 text-gray-800 shadow-sm';
                    const radiusClass = isMe ? 'rounded-2xl rounded-tr-sm' : 'rounded-2xl rounded-tl-sm';
                    
                    let cardHtml = '';
                    if (msg.kelas) {
                        const img = msg.kelas.gambar ? `<img src="${msg.kelas.gambar}" class="w-full h-32 object-cover rounded-t-xl">` : `<div class="w-full h-24 bg-gray-200 rounded-t-xl flex items-center justify-center text-gray-400"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg></div>`;
                        cardHtml = `
                        <div class="mt-2 w-64 bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden text-left mb-2">
                            ${img}
                            <div class="p-3">
                                <p class="text-[10px] font-bold text-oranye uppercase tracking-wider">${msg.kelas.nama_program}</p>
                                <p class="text-sm font-black text-gray-800 leading-tight mt-1 mb-2 line-clamp-2">${msg.kelas.nama_kelas}</p>
                                <p class="text-xs font-bold text-red-500">Rp ${msg.kelas.harga}</p>
                            </div>
                        </div>`;
                    }

                    const tickHtml = isMe ? (msg.dibaca ? '<span class="text-blue-300 ml-1">✓✓</span>' : '<span class="text-orange-200 ml-1">✓</span>') : '';

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

                // Auto scroll ke bawah
                chatBody.scrollTop = chatBody.scrollHeight;
            }

            // Fungsi Ambil Pesan
            function fetchMessages() {
                fetch(`{{ url('chat/messages') }}/${adminId}`)
                    .then(response => {
                        if (!response.ok) throw new Error("Gagal mengambil pesan");
                        return response.json();
                    })
                    .then(data => renderMessages(data))
                    .catch(err => console.error("Error fetching messages:", err));
            }

            // Fungsi Kirim Pesan
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const text = pesanInput.value.trim();
                if (!text) return;

                btnSend.disabled = true;
                btnSend.innerHTML = '<svg class="animate-spin w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

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
                    fetchMessages(); // Refresh chat langsung
                })
                .catch(err => alert("Gagal mengirim pesan!"))
                .finally(() => {
                    btnSend.disabled = false;
                    btnSend.innerHTML = '<svg class="w-5 h-5 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>';
                    pesanInput.focus();
                });
            });

            // Jalankan pertama kali
            fetchMessages();

            // Polling setiap 3 detik
            setInterval(fetchMessages, 3000);
        });
    </script>
    @endpush
</x-app-layout>

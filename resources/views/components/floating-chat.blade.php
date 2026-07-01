@php
    $admin  = \App\Models\User::where('role', 'admin')->first();
    $unread = $admin
        ? \App\Models\Pesan::where('pengirim_id', $admin->id)
            ->where('penerima_id', Auth::id())
            ->whereNull('dibaca_pada')
            ->count()
        : 0;
@endphp

@if($admin)
{{-- id="fc-chat-wrapper" wajib ada agar Alpine.$data(chatWrap) bisa bekerja --}}
<div id="fc-chat-wrapper"
     x-data="{ chatOpen: false, unreadCount: {{ $unread }} }"
     x-init="$watch('chatOpen', function(val) {
         window._fcChatIsOpen = val;
         if (val) {
             if (typeof window.fetchMessages === 'function') fetchMessages(true);
             unreadCount = 0;
         }
     })"
     class="fixed bottom-6 right-6 z-[99]">

    {{-- Kotak Obrolan --}}
    <div x-show="chatOpen"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-10 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-10 scale-95"
         style="display: none;"
         class="bg-white rounded-2xl shadow-2xl mb-4 w-[90vw] sm:w-[400px] border border-gray-100 flex flex-col h-[65vh] sm:h-[500px]">

        {{-- Chat Header --}}
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

        {{-- Chat Body --}}
        <div id="fc-chat-body" class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50 text-sm no-scrollbar">
            <div class="text-center text-gray-400 text-xs py-4" id="fc-loading-indicator">Memuat obrolan...</div>
        </div>

        {{-- Chat Footer --}}
        <div class="bg-white border-t border-gray-100 p-3 shrink-0 rounded-b-2xl">
            <form id="fc-chat-form" class="flex gap-2">
                @csrf
                <input type="hidden" id="fc-admin-id" value="{{ $admin->id }}">
                <input type="text" id="fc-pesan-input"
                       class="flex-1 rounded-xl border-gray-200 focus:border-oranye focus:ring focus:ring-orange-200 transition bg-gray-50 text-xs px-4"
                       placeholder="Ketik pesan Anda..."
                       required autocomplete="off">
                <button type="submit"
                        class="bg-hitam hover:bg-oranye text-white p-2.5 rounded-xl transition shadow flex items-center justify-center shrink-0"
                        id="fc-btn-send">
                    <svg class="w-5 h-5 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </button>
            </form>
        </div>
    </div>

    {{-- Tombol Floating --}}
    <button @click="chatOpen = !chatOpen"
            class="w-14 h-14 bg-oranye hover:bg-[#c24b22] text-white rounded-full shadow-2xl flex items-center justify-center transition-all duration-300 transform hover:scale-110 border-2 border-white/50 absolute bottom-0 right-0">
        <svg x-show="!chatOpen" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
        <svg x-show="chatOpen" style="display:none;" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>

        {{-- Badge Notifikasi --}}
        <span x-show="!chatOpen && unreadCount > 0" style="display:none;"
              class="absolute -top-1 -right-1 flex h-4 w-4 pointer-events-none">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-4 w-4 bg-red-600 border border-white text-[9px] font-black items-center justify-center text-white"
                  x-text="unreadCount > 9 ? '9+' : unreadCount"></span>
        </span>
    </button>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const chatWrap   = document.getElementById('fc-chat-wrapper');
    const adminIdEl  = document.getElementById('fc-admin-id');

    // Guard: komponen tidak ada di halaman ini (misal halaman non-peserta)
    if (!chatWrap || !adminIdEl) return;

    const adminId    = adminIdEl.value;
    const chatBody   = document.getElementById('fc-chat-body');
    const chatForm   = document.getElementById('fc-chat-form');
    const pesanInput = document.getElementById('fc-pesan-input');
    const btnSend    = document.getElementById('fc-btn-send');

    let lastMessageCount = -1;
    // chatIsOpen dikelola via x-init Alpine, disimpan ke window._fcChatIsOpen
    window._fcChatIsOpen = false;

    // ─── Render pesan ke DOM ────────────────────────────────────────────────
    function renderMessages(messages) {
        // Hanya re-render jika jumlah pesan berubah (efisiensi)
        if (messages.length === lastMessageCount) return;
        lastMessageCount = messages.length;

        chatBody.innerHTML = '';

        if (messages.length === 0) {
            chatBody.innerHTML = '<div class="text-center text-gray-400 text-xs py-4">Belum ada obrolan. Sapa admin sekarang! 👋</div>';
            return;
        }

        messages.forEach(function (msg) {
            const isMe        = msg.is_saya;
            const alignClass  = isMe ? 'justify-end' : 'justify-start';
            const bubbleBg    = isMe
                ? 'bg-[#de5e2e] text-white shadow-md'
                : 'bg-white border border-gray-100 text-gray-800 shadow-sm';
            const radiusClass = isMe ? 'rounded-2xl rounded-tr-sm' : 'rounded-2xl rounded-tl-sm';

            let cardHtml = '';
            if (msg.kelas) {
                const img = msg.kelas.gambar
                    ? `<img src="${msg.kelas.gambar}" class="w-full h-24 object-cover rounded-t-xl">`
                    : '';
                cardHtml = `
                <div class="mt-2 w-48 bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden text-left mb-2">
                    ${img}
                    <div class="p-2 bg-gray-50">
                        <p class="text-[9px] font-bold text-[#de5e2e] uppercase tracking-wider">${msg.kelas.nama_program}</p>
                        <p class="text-xs font-black text-gray-800 leading-tight mt-0.5 line-clamp-2">${msg.kelas.nama_kelas}</p>
                    </div>
                </div>`;
            }

            const tickHtml = isMe
                ? (msg.dibaca
                    ? '<span class="text-blue-300 ml-1 font-bold">✓✓</span>'
                    : '<span class="text-orange-200 ml-1">✓</span>')
                : '';

            chatBody.insertAdjacentHTML('beforeend', `
            <div class="flex w-full ${alignClass}">
                <div class="max-w-[85%]">
                    <div class="${bubbleBg} ${radiusClass} p-3 text-xs leading-relaxed">
                        ${cardHtml}${msg.pesan}
                    </div>
                    <div class="text-[9px] text-gray-400 mt-1 ${isMe ? 'text-right' : 'text-left'}">
                        ${msg.waktu} ${tickHtml}
                    </div>
                </div>
            </div>`);
        });

        chatBody.scrollTop = chatBody.scrollHeight;
    }

    // ─── Fetch pesan dari server ────────────────────────────────────────────
    window.fetchMessages = function (markRead) {
        markRead = markRead === true;
        const shouldMarkRead = markRead || window._fcChatIsOpen;

        fetch(`{{ url('chat/messages') }}/${adminId}?mark_read=${shouldMarkRead}`)
            .then(function (res) {
                if (!res.ok) throw new Error('HTTP ' + res.status);
                return res.json();
            })
            .then(function (data) {
                // Update badge unread via Alpine v3 (hanya saat chat tertutup)
                if (!window._fcChatIsOpen && chatWrap && typeof Alpine !== 'undefined') {
                    try {
                        const unread = data.filter(function (m) { return !m.is_saya && !m.dibaca; }).length;
                        Alpine.$data(chatWrap).unreadCount = unread;
                    } catch (e) { /* Alpine belum siap, abaikan */ }
                }
                renderMessages(data);
            })
            .catch(function (err) { console.error('[FloatingChat] fetch error:', err); });
    };

    // ─── Kirim pesan ────────────────────────────────────────────────────────
    chatForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const text = pesanInput.value.trim();
        if (!text) return;

        btnSend.disabled    = true;
        btnSend.textContent = '...';

        const csrfMeta  = document.querySelector('meta[name="csrf-token"]');
        const csrfInput = document.querySelector('input[name="_token"]');
        const csrfToken = csrfMeta ? csrfMeta.content : (csrfInput ? csrfInput.value : '');

        fetch('{{ url("chat/send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ penerima_id: adminId, pesan: text })
        })
        .then(function (res) { return res.json(); })
        .then(function () {
            pesanInput.value = '';
            fetchMessages(true);
        })
        .catch(function (err) { console.error('[FloatingChat] send error:', err); })
        .finally(function () {
            btnSend.disabled  = false;
            btnSend.innerHTML = '<svg class="w-5 h-5 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>';
            pesanInput.focus();
        });
    });

    // ─── Polling tiap 3 detik ───────────────────────────────────────────────
    fetchMessages(false);
    setInterval(function () { fetchMessages(false); }, 3000);
});
</script>
@endpush
@endif

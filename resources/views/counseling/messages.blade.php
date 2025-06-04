@extends('layouts.app')

@section('title', 'Pesan')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Menu</h5>
                </div>
                <div class="list-group list-group-flush">
                    @if (Auth::user()->role === 'user')
                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                    <a href="{{ route('counseling.request') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-plus-circle me-2"></i> Ajukan Konseling
                    </a>
                    <a href="{{ route('counseling.my-requests') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-list me-2"></i> Permintaan Saya
                    </a>
                    <a href="{{ route('counseling.history') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-history me-2"></i> Riwayat Konseling
                    </a>
                    <a href="{{ route('counseling.reports') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-alt me-2"></i> Laporan
                    </a>
                    @endif
                    <!-- Update the messages link in the sidebar -->
                    <a href="{{ route('counseling.messages') }}" class="list-group-item list-group-item-action active d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-comments me-2"></i> Pesan</span>
                        <span class="badge bg-danger rounded-pill unread-count" style="display: none;">0</span>
                    </a>
                    <a href="{{ route('profile.settings') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-cog me-2"></i> Pengaturan
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9 col-md-8">
            <div class="row">
                <!-- Contacts List Column -->
                <div class="col-md-4 border-end">
                    <div class="contacts-header p-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Kontak</h5>
                        <button class="btn btn-primary btn-sm" id="addContactBtn" data-bs-toggle="modal" data-bs-target="#addContactModal">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>

                    <div class="contacts-list">
                        @forelse($conversations as $conversation)
                            @php
                                $otherUser = $conversation->sender_id === Auth::id() ? $conversation->receiver : $conversation->sender;
                            @endphp
                            <!-- Update the contact-item div in the contacts list -->
                            <div class="contact-item p-3 border-bottom contact-clickable" 
                                 data-conversation-id="{{ $conversation->id }}"
                                 style="cursor: pointer;">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ $otherUser->nama }}</h6>
                                        <small class="text-muted message-preview">
                                            {{ $conversation->messages->last()?->content ?? 'Mulai percakapan' }}
                                        </small>
                                    </div>
                                </div>
                                <span class="badge bg-primary unread-badge" style="display: none;">Baru</span>
                            </div>
                        @empty
                            <div class="text-center p-3">
                                <p class="text-muted">Belum ada percakapan</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Chat Area Column -->
                <div class="col-md-8">
                    <div id="emptyChatState" class="text-center p-5">
                        <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                        <h5>Pilih percakapan untuk memulai</h5>
                    </div>
                    
                    <div id="chatArea" style="display: none;">
                        <!-- Chat content will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Contact Modal -->
<div class="modal fade" id="addContactModal" tabindex="-1" aria-labelledby="addContactModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addContactModalLabel">Tambah Kontak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="contactSelect" class="form-label">Pilih Kontak</label>
                    <select class="form-select" id="contactSelect">
                        <option value="">Pilih kontak...</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="startConversation">Mulai Percakapan</button>
            </div>
        </div>
    </div>
</div>

<style>
    .contact-clickable:hover {
        background-color: #f8f9fa;
    }
    .contact-clickable.active {
        background-color: #e9ecef;
    }
    .message {
        max-width: 75%;
    }
    .message.sent {
        margin-left: auto;
    }
    .message.sent .message-content {
        background-color: #007bff;
        color: white;
    }
    .message.received .message-content {
        background-color: #e9ecef;
    }
    .chat-messages {
        height: 400px;
        overflow-y: auto;
    }
</style>
@endsection

@section('scripts')
@parent
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script src="{{ mix('js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    var pusher = new Pusher('12c72e9a9c9cab0a82e9', {
      cluster: 'ap1'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
      alert(JSON.stringify(data));
    });

    document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded');

    // Setup real-time message listener
    const userId = {{ auth()->id() }};
    let currentConversationId = null;
    
    if (window.Echo) {
        window.Echo.private(`messages.${userId}`)
            .listen('.NewMessageReceived', (data) => {
                console.log('Message received:', data);
                handleNewMessage(data);
            });
            
        // Also listen for message read events
        window.Echo.private(`user.${userId}`)
            .listen('.message.read', (data) => {
                console.log('Messages marked as read:', data);
                handleMessageRead(data);
            });
    } else {
        console.error('Echo not initialized');
    }

    // Initialize contacts click handlers
    setupContactClickHandlers();
    setupAddContactHandlers();
    requestNotificationPermission();
    initializeMessagePolling();

    // Event handler functions
    function handleNewMessage(data) {
        console.log('Handling new message:', data);
        
        // Update conversation preview regardless
        updateConversationPreview(data);
        
        // If this message is for the currently active conversation
        if (currentConversationId && currentConversationId == data.conversation_id) {
            // Only append if the message is not from the current user
            if (data.sender_id !== userId) {
                appendNewMessage(data);
                // Mark messages as read since user is viewing the conversation
                markConversationAsRead(data.conversation_id);
            }
        } else {
            // Show notification for messages not in current conversation
            if (data.sender_id !== userId) {
                showNotification(data);
            }
        }
    }
    
    function handleMessageRead(data) {
        // Update UI to show messages as read if needed
        console.log('Messages read:', data);
    }

    function setupContactClickHandlers() {
        document.querySelectorAll('.contact-clickable').forEach(contact => {
            contact.addEventListener('click', function() {
                const conversationId = this.getAttribute('data-conversation-id');
                console.log('Clicked conversation:', conversationId);
                
                // Update current conversation ID
                currentConversationId = conversationId;
                
                document.querySelectorAll('.contact-clickable').forEach(el => {
                    el.classList.remove('active');
                });
                this.classList.add('active');
                
                loadConversation(conversationId);
                
                // Mark messages as read when opening conversation
                markConversationAsRead(conversationId);
            });
        });
    }

    function setupAddContactHandlers() {
        const addContactBtn = document.getElementById('addContactBtn');
        const startConversationBtn = document.getElementById('startConversation');

        if (addContactBtn) {
            addContactBtn.addEventListener('click', fetchContacts);
        }

        if (startConversationBtn) {
            startConversationBtn.addEventListener('click', startNewConversation);
        }
    }

    function fetchContacts() {
        fetch('{{ route("messages.contacts") }}')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const contactSelect = document.getElementById('contactSelect');
                    contactSelect.innerHTML = '<option value="">Pilih kontak...</option>';
                    
                    data.contacts.forEach(user => {
                        contactSelect.innerHTML += `
                            <option value="${user.id}">${user.nama} (${user.role})</option>
                        `;
                    });
                } else {
                    console.error('API returned error:', data);
                    alert('Gagal memuat daftar kontak');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal memuat daftar kontak');
            });
    }

    function startNewConversation() {
        const selectedContactId = document.getElementById('contactSelect').value;
        if (!selectedContactId) {
            alert('Silakan pilih kontak terlebih dahulu');
            return;
        }

        fetch('{{ route("messages.start") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ receiver_id: selectedContactId })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('addContactModal'));
                modal.hide();
                window.location.reload();
            } else {
                throw new Error(data.message || 'Gagal memulai percakapan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal memulai percakapan: ' + error.message);
        });
    }

    function loadConversation(conversationId) {
        console.log('Loading conversation:', conversationId);
        
        fetch(`/messages/${conversationId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (!data.success) {
                    throw new Error(data.error || 'Failed to load conversation');
                }
                
                // Hide empty state and show chat area
                document.getElementById('emptyChatState').style.display = 'none';
                const chatArea = document.getElementById('chatArea');
                chatArea.style.display = 'block';
                chatArea.dataset.conversationId = conversationId;

                // Get other user's name
                const otherUser = data.conversation.sender_id === {{ Auth::id() }} 
                    ? data.conversation.receiver 
                    : data.conversation.sender;

                // Update chat area HTML
                chatArea.innerHTML = `
                    <div class="chat-header p-3 border-bottom">
                        <h6 class="mb-0">${otherUser.nama}</h6>
                    </div>
                    <div class="chat-messages p-3" id="messageContainer">
                        ${data.messages.map(message => `
                            <div class="message ${message.sender_id === {{ Auth::id() }} ? 'sent' : 'received'} mb-2">
                                <div class="message-content p-2 rounded">
                                    ${message.content}
                                </div>
                                <small class="text-muted">${moment(message.created_at).format('HH:mm')}</small>
                            </div>
                        `).join('')}
                    </div>
                    <div class="chat-input p-3 border-top">
                        <form id="messageForm">
                            <div class="input-group">
                                <input type="text" class="form-control" id="messageInput" placeholder="Ketik pesan...">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                `;

                // Setup message form handler
                const messageForm = document.getElementById('messageForm');
                messageForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const input = document.getElementById('messageInput');
                    const content = input.value.trim();
                    
                    if (!content) return;

                    // Disable form while sending
                    const submitBtn = messageForm.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;

                    fetch(`/messages/${conversationId}/send`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ content })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            input.value = '';
                            // Append the sent message immediately
                            appendSentMessage(data.message);
                        } else {
                            throw new Error(data.error || 'Failed to send message');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal mengirim pesan: ' + error.message);
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                    });
                });

                // Scroll to bottom of messages
                scrollToBottom();
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load conversation: ' + error.message
                });
            });
    }

    function appendNewMessage(message) {
        const messageContainer = document.getElementById('messageContainer');
        if (!messageContainer) return;

        const messageHtml = `
            <div class="message received mb-2">
                <div class="message-content p-2 rounded">
                    ${message.content}
                </div>
                <small class="text-muted">${moment(message.created_at).format('HH:mm')}</small>
            </div>
        `;
        messageContainer.insertAdjacentHTML('beforeend', messageHtml);
        scrollToBottom();
    }
    
    function appendSentMessage(message) {
        const messageContainer = document.getElementById('messageContainer');
        if (!messageContainer) return;

        const messageHtml = `
            <div class="message sent mb-2">
                <div class="message-content p-2 rounded">
                    ${message.content}
                </div>
                <small class="text-muted">${moment(message.created_at).format('HH:mm')}</small>
            </div>
        `;
        messageContainer.insertAdjacentHTML('beforeend', messageHtml);
        scrollToBottom();
    }
    
    function scrollToBottom() {
        const messageContainer = document.getElementById('messageContainer');
        if (messageContainer) {
            messageContainer.scrollTop = messageContainer.scrollHeight;
        }
    }

    function updateConversationPreview(message) {
        const conversationElement = document.querySelector(`[data-conversation-id="${message.conversation_id}"]`);
        if (!conversationElement) return;

        const previewElement = conversationElement.querySelector('.message-preview');
        const badgeElement = conversationElement.querySelector('.unread-badge');
        
        if (previewElement) {
            previewElement.textContent = message.content;
        }
        
        // Only show unread badge if message is not from current user and not in current conversation
        if (badgeElement && message.sender_id !== userId && currentConversationId != message.conversation_id) {
            badgeElement.style.display = 'block';
        }
    }
    
    function markConversationAsRead(conversationId) {
        fetch(`/messages/${conversationId}/mark-read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Messages marked as read:', data.marked_count);
                // Hide unread badge for this conversation
                const conversationElement = document.querySelector(`[data-conversation-id="${conversationId}"]`);
                if (conversationElement) {
                    const badgeElement = conversationElement.querySelector('.unread-badge');
                    if (badgeElement) {
                        badgeElement.style.display = 'none';
                    }
                }
            }
        })
        .catch(error => {
            console.error('Error marking as read:', error);
        });
    }

    function showNotification(message) {
        if (Notification.permission === 'granted') {
            const notification = new Notification('Pesan Baru', {
                body: `${message.sender_name}: ${message.content}`,
                icon: '/path/to/your/icon.png'
            });

            notification.onclick = function() {
                window.focus();
                // Find and click the conversation to load it
                const conversationElement = document.querySelector(`[data-conversation-id="${message.conversation_id}"]`);
                if (conversationElement) {
                    conversationElement.click();
                }
            };
        }
    }

    function requestNotificationPermission() {
        if ('Notification' in window) {
            if (Notification.permission !== 'granted' && Notification.permission !== 'denied') {
                Swal.fire({
                    title: 'Notifikasi Pesan',
                    text: 'Izinkan kami mengirim notifikasi ketika ada pesan baru?',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Izinkan',
                    cancelButtonText: 'Nanti saja'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Notification.requestPermission();
                    }
                });
            }
        }
    }

    function initializeMessagePolling() {
        // Reduced polling interval since we have real-time updates
        setInterval(checkNewMessages, 30000);
    }

    function checkNewMessages() {
        fetch('/messages/check-new')
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (!data.success) {
                    throw new Error(data.error || 'Failed to check new messages');
                }
                updateUnreadCount(data.unreadCount);
                updateUnreadConversations(data.unreadConversations);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function updateUnreadCount(count) {
        const unreadCountBadge = document.querySelector('.unread-count');
        if (count > 0) {
            unreadCountBadge.style.display = 'block';
            unreadCountBadge.textContent = count;
        } else {
            unreadCountBadge.style.display = 'none';
        }
    }

    function updateUnreadConversations(conversations) {
        document.querySelectorAll('.contact-clickable').forEach(contact => {
            const conversationId = contact.dataset.conversationId;
            const badge = contact.querySelector('.unread-badge');
            
            if (conversations.includes(parseInt(conversationId))) {
                badge.style.display = 'block';
            } else {
                badge.style.display = 'none';
            }
        });
    }
});
</script>
@endsection
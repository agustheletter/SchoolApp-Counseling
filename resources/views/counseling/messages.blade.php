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
                    
                    <!-- Replace the existing chatArea div with this -->
                    <div id="chatArea" style="display: none;" class="d-flex flex-column h-100">
                        <div class="chat-header p-3 border-bottom">
                            <h6 class="mb-0" id="chatUserName"></h6>
                        </div>
                        
                        <div class="chat-messages p-3 flex-grow-1 overflow-auto">
                            <!-- Messages will be loaded here -->
                        </div>
                        
                        <div class="chat-input p-3 border-top">
                            <form id="messageForm" class="d-flex">
                                <input type="text" id="messageInput" class="form-control me-2" placeholder="Ketik pesan...">
                                <button type="submit" class="btn btn-primary">Kirim</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Contact Modal -->
<div class="modal fade" id="addContactModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kontak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="contactSelect" class="form-label">Pilih Kontak</label>
                    <select id="contactSelect" class="form-select" style="width: 100%"></select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="startConversationBtn">Mulai Percakapan</button>
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

    /* Add this to your existing style section */
    .select2-container {
        width: 100% !important;
    }
    
    .select2-results__options {
        max-height: 200px;
        overflow-y: auto;
    }
    
    .select2-selection__rendered {
        line-height: 31px !important;
    }
    
    .select2-container .select2-selection--single {
        height: 35px !important;
    }
</style>
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
@endsection

@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ mix('js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="module">
    import { initializeApp } from 'https://www.gstatic.com/firebasejs/9.22.2/firebase-app.js';
    import { getDatabase, ref, onChildAdded, push, set, off } from 'https://www.gstatic.com/firebasejs/9.22.2/firebase-database.js';
    import { getAuth, signInWithCustomToken, setPersistence, browserLocalPersistence } from 'https://www.gstatic.com/firebasejs/9.22.2/firebase-auth.js';

    // Initialize Firebase
    const firebaseConfig = {
        apiKey: "AIzaSyBXgJzaeKW9VT42GWDUekLosTVNCNMKzCw",
        authDomain: "schoolapp-counseling.firebaseapp.com", // Change this back to Firebase default
        databaseURL: "https://schoolapp-counseling-default-rtdb.asia-southeast1.firebasedatabase.app",
        projectId: "schoolapp-counseling",
        storageBucket: "schoolapp-counseling.appspot.com",
        messagingSenderId: "1011035829400",
        appId: "1:1011035829400:web:c31c1f201ee8dec1f8cced"
    };

    // Add domain check for proper URL construction
    const isProduction = window.location.hostname === 'counseling.firaasraihansyah.my.id';
    const baseUrl = isProduction ? 
        'https://counseling.firaasraihansyah.my.id' : 
        'http://localhost:8000';

    const app = initializeApp(firebaseConfig);
    const database = getDatabase(app);
    const auth = getAuth(app);

    // Declare variables at the top level scope
    let currentConversationId = null;
    const userId = {{ auth()->id() }};

    // Add this function after your Firebase initialization and before the DOMContentLoaded event

    function setupChatHandlers() {
        // Message form submission
        document.querySelector('#messageForm')?.addEventListener('submit', async function(e) {
            e.preventDefault();
            const input = document.querySelector('#messageInput');
            const content = input.value.trim();

            if (!content || !currentConversationId) return;

            try {
                const response = await fetch(`/messages/${currentConversationId}/send`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ content })
                });

                const data = await response.json();
                if (!data.success) throw new Error(data.message || 'Failed to send message');

                // Push to Firebase
                const messagesRef = ref(database, `messages/${currentConversationId}`);
                const newMessageRef = push(messagesRef);
                await set(newMessageRef, {
                    id: data.message.id,
                    sender_id: userId,
                    content: content,
                    created_at: new Date().toISOString(),
                    is_sent: true
                });

                // Clear input
                input.value = '';
                
                // Immediately append the sent message
                appendMessage({
                    content: content,
                    sender_id: userId,
                    created_at: new Date().toISOString(),
                    is_sent: true
                });

            } catch (error) {
                console.error('Error sending message:', error);
                Swal.fire('Error', 'Failed to send message', 'error');
            }
        });

        // Contact click handlers
        document.querySelectorAll('.contact-clickable').forEach(contact => {
            contact.addEventListener('click', handleContactClick);
        });

        // Firebase message listener
        if (currentConversationId) {
            const messagesRef = ref(database, `messages/${currentConversationId}`);
            onChildAdded(messagesRef, (snapshot) => {
                const message = snapshot.val();
                if (message && message.sender_id !== userId) {
                    appendMessage(message);
                }
            });
        }
    }

    document.addEventListener('DOMContentLoaded', async function() {
        console.log('DOM loaded');

        try {
            // Set persistence first
            await setPersistence(auth, browserLocalPersistence);
            
            const tokenResponse = await fetch(`${baseUrl}/firebase/token`);
            if (!tokenResponse.ok) {
                throw new Error(`HTTP error! status: ${tokenResponse.status}`);
            }
            
            const data = await tokenResponse.json();
            if (!data.success) throw new Error(data.error || 'Failed to get token');

            // Sign in with custom token
            await signInWithCustomToken(auth, data.token);
            console.log('Firebase authentication successful');
            
            // Initialize chat components
            await loadContacts();
            setupChatHandlers();
            
        } catch (error) {
            console.error('Firebase initialization error:', error);
            Swal.fire({
                title: 'Error',
                text: 'Failed to initialize chat: ' + error.message,
                icon: 'error'
            });
        }
    });

    // Fix moment.js date formatting
    function formatTimestamp(timestamp) {
        if (!timestamp) return moment().format('HH:mm');
        return moment(timestamp).isValid() ? 
            moment(timestamp).format('HH:mm') : 
            moment().format('HH:mm');
    }

    function appendMessage(message) {
        const chatMessages = document.querySelector('.chat-messages');
        const isSender = message.sender_id === userId;
        const timestamp = moment(message.created_at).format('HH:mm');
        
        const messageHtml = `
            <div class="message mb-3 ${isSender ? 'sent' : 'received'}">
                <div class="message-content p-2 rounded">
                    <p class="mb-1">${message.content}</p>
                    <small class="text-muted">${timestamp}</small>
                </div>
            </div>
        `;
        
        chatMessages.insertAdjacentHTML('beforeend', messageHtml);
        
        // Scroll to bottom
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Replace the loadContacts function with this:
    async function loadContacts() {
        try {
            const response = await fetch('/messages/contacts');
            const data = await response.json();
            
            if (!data.success) throw new Error('Failed to load contacts');

            // Update contacts list in the main view
            const contactsList = document.querySelector('.contacts-list');
            if (contactsList) {
                contactsList.innerHTML = data.contacts.map(contact => `
                    <div class="contact-item p-3 border-bottom contact-clickable" 
                         data-contact-id="${contact.id}"
                         data-conversation-id="${contact.conversation_id || ''}"
                         style="cursor: pointer;">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">${contact.nama}</h6>
                                <small class="text-muted">${contact.role}</small>
                            </div>
                        </div>
                    </div>
                `).join('');

                // Add click handlers for contacts
                document.querySelectorAll('.contact-item').forEach(item => {
                    item.addEventListener('click', handleContactClick);
                });
            }

            // Update modal select
            const contactSelect = document.querySelector('#contactSelect');
            if (contactSelect) {
                contactSelect.innerHTML = `
                    <option value="">Pilih kontak...</option>
                    ${data.contacts.map(contact => `
                        <option value="${contact.id}">${contact.nama} (${contact.role})</option>
                    `).join('')}
                `;
            }

        } catch (error) {
            console.error('Error loading contacts:', error);
            Swal.fire('Error', 'Failed to load contacts', 'error');
        }
    }

    function handleContactClick(event) {
        const contactElement = event.currentTarget;
        const conversationId = contactElement.dataset.conversationId;
        const contactId = contactElement.dataset.contactId;

        if (conversationId) {
            loadConversation(conversationId);
        } else {
            startNewConversation(contactId);
        }
    }

    async function startNewConversation(contactId) {
        try {
            const response = await fetch('/messages/conversation/start', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ user_id: contactId })
            });

            const data = await response.json();
            if (!data.success) throw new Error(data.message || 'Failed to start conversation');

            // Load the new conversation
            await loadConversation(data.conversation.id);
            
            // Refresh contacts list to update conversation IDs
            await loadContacts();

        } catch (error) {
            console.error('Error starting conversation:', error);
            Swal.fire('Error', 'Failed to start conversation', 'error');
        }
    }

    // Add this function to handle real-time message updates
    function setupMessageListeners(conversationId) {
        // Remove any existing listeners
        if (currentConversationId) {
            const oldRef = ref(database, `messages/${currentConversationId}`);
            off(oldRef);
        }

        // Set up new listener
        const messagesRef = ref(database, `messages/${conversationId}`);
        onChildAdded(messagesRef, (snapshot) => {
            const message = snapshot.val();
            if (message && message.sender_id !== userId) {
                appendMessage(message);
            }
        });
    }

    // Update loadConversation function to set up listeners
    async function loadConversation(conversationId) {
        try {
            const response = await fetch(`${baseUrl}/messages/conversation/${conversationId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            if (response.status === 403) {
                throw new Error('You do not have permission to view this conversation');
            }
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            if (!data.success) throw new Error('Failed to load conversation');

            // Update UI
            document.querySelector('#emptyChatState').style.display = 'none';
            document.querySelector('#chatArea').style.display = 'flex';
            document.querySelector('#chatUserName').textContent = data.conversation.other_user_name;

            // Clear and load messages
            const chatMessages = document.querySelector('.chat-messages');
            chatMessages.innerHTML = '';
            data.messages.forEach(message => appendMessage(message));

            // Update current conversation ID and set up listeners
            currentConversationId = conversationId;
            setupMessageListeners(conversationId);

            // Update active contact
            document.querySelectorAll('.contact-clickable').forEach(item => {
                item.classList.remove('active');
                if (item.dataset.conversationId === conversationId) {
                    item.classList.add('active');
                }
            });

            // Scroll to bottom
            chatMessages.scrollTop = chatMessages.scrollHeight;

        } catch (error) {
            console.error('Error loading conversation:', error);
            Swal.fire('Error', error.message, 'error');
        }
    }

    // Add event listener for new contact button
    document.querySelector('#startNewChat')?.addEventListener('click', async function() {
        const contactSelect = document.querySelector('#contactSelect');
        const selectedId = contactSelect.value;
        
        if (!selectedId) {
            Swal.fire('Error', 'Please select a contact', 'warning');
            return;
        }

        try {
            const response = await fetch('/messages/conversation/start', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ user_id: selectedId })
            });

            const data = await response.json();
            if (!data.success) throw new Error(data.message || 'Failed to start conversation');

            // Close modal
            const modal = bootstrap.Modal.getInstance(document.querySelector('#newChatModal'));
            modal.hide();

            // Load the new conversation
            await loadConversation(data.conversation.id);
            
            // Refresh contacts list
            await loadContacts();

        } catch (error) {
            console.error('Error starting new conversation:', error);
            Swal.fire('Error', 'Failed to start conversation', 'error');
        }
    });

    // Add this helper function near the top of your script
    async function fetchWithError(url, options = {}) {
        try {
            const response = await fetch(url, {
                ...options,
                headers: {
                    ...options.headers,
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            if (!response.ok) {
                const errorData = await response.json().catch(() => ({}));
                throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            if (!data.success) {
                throw new Error(data.error || 'Operation failed');
            }

            return data;
        } catch (error) {
            console.error('Fetch error:', error);
            throw error;
        }
    }

    // Replace the existing Select2 initialization in your messages.blade.php with this:

// Replace the existing Select2 initialization in your messages.blade.php with this:

// Replace the Select2 initialization section in your messages.blade.php with this:

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 when modal is shown
    $('#addContactModal').on('shown.bs.modal', function() {
        if (!$('#contactSelect').data('select2')) {
            $('#contactSelect').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#addContactModal'),
                placeholder: 'Cari kontak...',
                allowClear: true,
                ajax: {
                    url: '/messages/contacts/available',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term || '',
                            page: params.page || 1
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.contacts
                        };
                    }
                },
                minimumInputLength: 0
            });
        }
    });

    // Handle start conversation button click
    document.getElementById('startConversationBtn').addEventListener('click', async function() {
        const selectedUserId = $('#contactSelect').val();
        
        if (!selectedUserId) {
            Swal.fire('Error', 'Please select a contact first', 'error');
            return;
        }

        try {
            const response = await fetch('/messages/conversation/start', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    user_id: selectedUserId
                })
            });

            const data = await response.json();
            
            if (!data.success) {
                throw new Error(data.message || 'Failed to start conversation');
            }

            // Close modal
            $('#addContactModal').modal('hide');

            // Load the new conversation
            await loadConversation(data.conversation.id);
            
            // Refresh contacts list
            await loadContacts();

        } catch (error) {
            console.error('Error starting conversation:', error);
            Swal.fire('Error', 'Failed to start conversation', 'error');
        }
    });
});
</script>
@endsection
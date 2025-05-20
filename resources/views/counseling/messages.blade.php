@extends('layouts.app')

@section('title', 'Pesan')

@section('styles')
<style>
    .messages-container {
        height: 650px;
        display: flex;
        flex-direction: column;
    }
    
    .contacts-list {
        height: 100%;
        overflow-y: auto;
    }
    
    .contact-item {
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .contact-item:hover {
        background-color: rgba(0, 0, 0, 0.03);
    }
    
    .contact-item.active {
        background-color: rgba(0, 0, 0, 0.05);
    }
    
    .contact-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
    }
    
    .contact-status {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        position: absolute;
        bottom: 0;
        right: 0;
        border: 2px solid white;
    }
    
    .status-online {
        background-color: #28a745;
    }
    
    .status-offline {
        background-color: #6c757d;
    }
    
    .chat-container {
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    
    .chat-header {
        padding: 15px;
        border-bottom: 1px solid #dee2e6;
    }
    
    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 15px;
        background-color: #f8f9fa;
    }
    
    .chat-input {
        padding: 15px;
        border-top: 1px solid #dee2e6;
        background-color: white;
    }
    
    .message {
        margin-bottom: 15px;
        max-width: 80%;
    }
    
    .message-content {
        padding: 10px 15px;
        border-radius: 18px;
        display: inline-block;
        word-break: break-word;
    }
    
    .message-time {
        font-size: 0.75rem;
        color: #6c757d;
        margin-top: 5px;
    }
    
    .message-outgoing {
        margin-left: auto;
    }
    
    .message-outgoing .message-content {
        background-color: #6c5ce7;
        color: white;
        border-bottom-right-radius: 5px;
    }
    
    .message-incoming {
        margin-right: auto;
    }
    
    .message-incoming .message-content {
        background-color: white;
        color: #212529;
        border-bottom-left-radius: 5px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .chat-date-divider {
        text-align: center;
        margin: 20px 0;
        position: relative;
    }
    
    .chat-date-divider span {
        background-color: #f8f9fa;
        padding: 0 10px;
        position: relative;
        z-index: 1;
        color: #6c757d;
        font-size: 0.875rem;
    }
    
    .chat-date-divider:before {
        content: "";
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background-color: #dee2e6;
        z-index: 0;
    }
    
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #6c757d;
        text-align: center;
        padding: 20px;
    }
    
    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        color: #dee2e6;
    }
    
    .unread-badge {
        background-color: #6c5ce7;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <!-- Sidebar Menu -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Menu Siswa</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                    <a href="{{ route('counseling.request') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-plus-circle me-2"></i> Ajukan Konseling
                    </a>
                    <a href="{{ route('counseling.my-requests') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-list me-2"></i> Permintaan Saya
                    </a>
                    <a href="{{ route('counseling.schedule') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-calendar-alt me-2"></i> Jadwal Konseling
                    </a>
                    <a href="{{ route('counseling.messages') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-envelope me-2"></i> Pesan
                    </a>
                    <a href="{{ route('counseling.reports') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-chart-bar me-2"></i> Laporan
                    </a>
                    <a href="{{ route('profile.settings') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-cog me-2"></i> Pengaturan
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Pesan</h5>
                </div>
                <div class="card-body p-0">
                    <div class="messages-container">
                        <div class="row g-0 h-100">
                            <!-- Contacts List -->
                            <div class="col-md-4 border-end">
                                <div class="p-3 border-bottom">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Cari kontak..." aria-label="Cari kontak">
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="contacts-list">
                                    <!-- Contact Item -->
                                    <div class="contact-item active p-3 border-bottom" data-contact-id="1">
                                        <div class="d-flex align-items-center">
                                            <div class="position-relative me-3">
                                                <img src="https://via.placeholder.com/100" alt="Dr. Andi Wijaya" class="contact-avatar">
                                                <span class="contact-status status-online"></span>
                                            </div>
                                            <div class="flex-grow-1 min-width-0">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0 text-truncate">Dr. Andi Wijaya</h6>
                                                    <small class="text-muted ms-2">10:05</small>
                                                </div>
                                                <p class="mb-0 text-truncate text-muted small">Baik, kita akan bahas konsep dasar integral terlebih dahulu.</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Contact Item with Unread Messages -->
                                    <div class="contact-item p-3 border-bottom" data-contact-id="2">
                                        <div class="d-flex align-items-center">
                                            <div class="position-relative me-3">
                                                <img src="https://via.placeholder.com/100" alt="Siti Rahayu, M.Psi" class="contact-avatar">
                                                <span class="contact-status status-offline"></span>
                                            </div>
                                            <div class="flex-grow-1 min-width-0">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0 text-truncate fw-bold">Siti Rahayu, M.Psi</h6>
                                                    <small class="text-muted ms-2">Kemarin</small>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p class="mb-0 text-truncate text-muted small fw-bold">Halo, saya sudah menyetujui permintaan konseling Anda.</p>
                                                    <span class="badge rounded-pill unread-badge ms-2">2</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- More Contact Items -->
                                    <div class="contact-item p-3 border-bottom" data-contact-id="3">
                                        <div class="d-flex align-items-center">
                                            <div class="position-relative me-3">
                                                <img src="https://via.placeholder.com/100" alt="Budi Santoso, S.Pd" class="contact-avatar">
                                                <span class="contact-status status-online"></span>
                                            </div>
                                            <div class="flex-grow-1 min-width-0">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0 text-truncate">Budi Santoso, S.Pd</h6>
                                                    <small class="text-muted ms-2">3 hari lalu</small>
                                                </div>
                                                <p class="mb-0 text-truncate text-muted small">Jangan lupa untuk membawa hasil tes minat bakat pada sesi konseling nanti.</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="contact-item p-3 border-bottom" data-contact-id="4">
                                        <div class="d-flex align-items-center">
                                            <div class="position-relative me-3">
                                                <img src="https://via.placeholder.com/100" alt="Dewi Lestari, M.Pd" class="contact-avatar">
                                                <span class="contact-status status-offline"></span>
                                            </div>
                                            <div class="flex-grow-1 min-width-0">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0 text-truncate">Dewi Lestari, M.Pd</h6>
                                                    <small class="text-muted ms-2">1 minggu lalu</small>
                                                </div>
                                                <p class="mb-0 text-truncate text-muted small">Terima kasih atas partisipasi aktif Anda dalam sesi konseling kemarin.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Chat Area -->
                            <div class="col-md-8">
                                <div class="chat-container">
                                    <!-- Chat Header -->
                                    <div class="chat-header">
                                        <div class="d-flex align-items-center">
                                            <div class="position-relative me-3">
                                                <img src="https://via.placeholder.com/100" alt="Dr. Andi Wijaya" class="contact-avatar">
                                                <span class="contact-status status-online"></span>
                                            </div>
                                            <div>
                                                <h5 class="mb-0">Dr. Andi Wijaya</h5>
                                                <small class="text-success">Online</small>
                                            </div>
                                            <div class="ms-auto">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary" type="button" id="chatOptionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="chatOptionsDropdown">
                                                        <li><a class="dropdown-item" href="#"><i class="fas fa-video me-2"></i> Mulai Video Call</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Lihat Profil</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="fas fa-search me-2"></i> Cari Pesan</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i> Unduh Percakapan</a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-flag me-2"></i> Laporkan</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Chat Messages -->
                                    <div class="chat-messages" id="chatMessages">
                                        <div class="chat-date-divider">
                                            <span>Hari ini</span>
                                        </div>
                                        
                                        <div class="message message-incoming">
                                            <div class="message-content">
                                                Halo Ahmad, bagaimana kabarmu hari ini?
                                            </div>
                                            <div class="message-time">09:30</div>
                                        </div>
                                        
                                        <div class="message message-outgoing">
                                            <div class="message-content">
                                                Halo Pak Andi, kabar saya baik. Terima kasih sudah bertanya.
                                            </div>
                                            <div class="message-time">09:32</div>
                                        </div>
                                        
                                        <div class="message message-incoming">
                                            <div class="message-content">
                                                Saya ingin mengingatkan tentang sesi konseling kita besok pukul 10:00. Apakah jadwal tersebut masih sesuai untuk Anda?
                                            </div>
                                            <div class="message-time">09:35</div>
                                        </div>
                                        
                                        <div class="message message-outgoing">
                                            <div class="message-content">
                                                Iya Pak, jadwal tersebut masih sesuai. Saya akan hadir tepat waktu.
                                            </div>
                                            <div class="message-time">09:40</div>
                                        </div>
                                        
                                        <div class="message message-incoming">
                                            <div class="message-content">
                                                Bagus. Untuk persiapan, apakah Anda sudah mencoba mengerjakan soal-soal latihan yang saya berikan sebelumnya?
                                            </div>
                                            <div class="message-time">09:42</div>
                                        </div>
                                        
                                        <div class="message message-outgoing">
                                            <div class="message-content">
                                                Sudah Pak, tapi saya masih kesulitan dengan beberapa soal, terutama nomor 3 dan 5. Saya akan membawa catatan kesulitan saya besok.
                                            </div>
                                            <div class="message-time">09:45</div>
                                        </div>
                                        
                                        <div class="message message-incoming">
                                            <div class="message-content">
                                                Baik, kita akan bahas konsep dasar integral terlebih dahulu, kemudian masuk ke soal-soal yang Anda kesulitan. Jangan lupa bawa buku catatan dan kalkulator.
                                            </div>
                                            <div class="message-time">10:05</div>
                                        </div>
                                    </div>
                                    
                                    <!-- Chat Input -->
                                    <div class="chat-input">
                                        <form id="chatForm">
                                            <div class="input-group">
                                                <button class="btn btn-outline-secondary" type="button">
                                                    <i class="far fa-smile"></i>
                                                </button>
                                                <button class="btn btn-outline-secondary" type="button">
                                                    <i class="fas fa-paperclip"></i>
                                                </button>
                                                <input type="text" class="form-control" placeholder="Ketik pesan..." id="messageInput">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatMessages = document.getElementById('chatMessages');
        const chatForm = document.getElementById('chatForm');
        const messageInput = document.getElementById('messageInput');
        const contactItems = document.querySelectorAll('.contact-item');
        
        // Auto scroll to bottom of chat
        chatMessages.scrollTop = chatMessages.scrollHeight;
        
        // Handle form submission
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const message = messageInput.value.trim();
            if (message) {
                // Create new message element
                const now = new Date();
                const hours = now.getHours().toString().padStart(2, '0');
                const minutes = now.getMinutes().toString().padStart(2, '0');
                const timeString = `${hours}:${minutes}`;
                
                const messageElement = document.createElement('div');
                messageElement.className = 'message message-outgoing';
                messageElement.innerHTML = `
                    <div class="message-content">
                        ${message}
                    </div>
                    <div class="message-time">${timeString}</div>
                `;
                
                // Add message to chat
                chatMessages.appendChild(messageElement);
                
                // Clear input
                messageInput.value = '';
                
                // Scroll to bottom
                chatMessages.scrollTop = chatMessages.scrollHeight;
                
                // Simulate response (in a real app, this would be handled by the server)
                setTimeout(() => {
                    const responseElement = document.createElement('div');
                    responseElement.className = 'message message-incoming';
                    responseElement.innerHTML = `
                        <div class="message-content">
                            Terima kasih atas informasinya. Sampai bertemu besok di sesi konseling.
                        </div>
                        <div class="message-time">${hours}:${(parseInt(minutes) + 1).toString().padStart(2, '0')}</div>
                    `;
                    
                    chatMessages.appendChild(responseElement);
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }, 2000);
            }
        });
        
        // Handle contact selection
        contactItems.forEach(item => {
            item.addEventListener('click', function() {
                // Remove active class from all contacts
                contactItems.forEach(contact => {
                    contact.classList.remove('active');
                });
                
                // Add active class to clicked contact
                this.classList.add('active');
                
                // In a real app, this would load the conversation with the selected contact
                // For demo purposes, we'll just show a loading indicator
                chatMessages.innerHTML = '<div class="d-flex justify-content-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
                
                // Simulate loading conversation
                setTimeout(() => {
                    // This would be replaced with actual conversation data
                    if (this.dataset.contactId === '2') {
                        // Show conversation with Siti Rahayu
                        chatMessages.innerHTML = `
                            <div class="chat-date-divider">
                                <span>Kemarin</span>
                            </div>
                            
                            <div class="message message-incoming">
                                <div class="message-content">
                                    Halo, saya sudah menyetujui permintaan konseling Anda untuk tanggal 22 Mei 2023.
                                </div>
                                <div class="message-time">14:30</div>
                            </div>
                            
                            <div class="message message-incoming">
                                <div class="message-content">
                                    Untuk persiapan, saya sarankan Anda mulai mencatat situasi yang membuat Anda cemas saat menghadapi ujian. Kita akan membahasnya dalam sesi nanti.
                                </div>
                                <div class="message-time">14:32</div>
                            </div>
                        `;
                        
                        // Update header
                        document.querySelector('.chat-header h5').textContent = 'Siti Rahayu, M.Psi';
                        document.querySelector('.chat-header small').textContent = 'Terakhir dilihat: Kemarin 15:45';
                        document.querySelector('.chat-header small').className = 'text-muted';
                        document.querySelector('.chat-header .contact-status').className = 'contact-status status-offline';
                        
                        // Remove unread badge
                        this.querySelector('.badge')?.remove();
                        this.querySelector('p').classList.remove('fw-bold');
                        this.querySelector('h6').classList.remove('fw-bold');
                    } else {
                        // Restore original conversation
                        location.reload();
                    }
                    
                    // Scroll to bottom
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }, 1000);
            });
        });
    });
</script>
@endsection
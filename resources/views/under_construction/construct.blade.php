@extends('layouts.app')

@section('title', 'Halaman Dalam Pengembangan')

@section('styles')
<style>
    .construction-container {
        text-align: center;
        padding: 50px 20px;
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
    }

    .construction-content {
        background-color: #fff;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        max-width: 600px;
        width: 100%;
    }

    .construction-icon {
        font-size: 80px;
        color: #ffc107;
        margin-bottom: 25px;
    }

    .construction-title {
        font-size: 32px;
        color: #333;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .construction-text {
        font-size: 18px;
        color: #666;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    .back-button {
        display: inline-block;
        padding: 12px 30px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .back-button:hover {
        background-color: #0056b3;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .construction-image {
        max-width: 300px;
        margin-bottom: 30px;
    }

    @media (max-width: 576px) {
        .construction-title {
            font-size: 24px;
        }
        
        .construction-text {
            font-size: 16px;
        }
    }
</style>
@endsection

@section('content')
<div class="construction-container">
    <div class="construction-content">
        <div class="construction-icon">
            <i class="fas fa-tools"></i>
        </div>
        <h1 class="construction-title">Halaman Dalam Pengembangan</h1>
        <p class="construction-text">
            Mohon maaf, halaman ini sedang dalam proses pengembangan.<br>
            Silakan kembali lagi nanti.
        </p>
        <div>
            <a href="{{ url()->previous() }}" class="back-button">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Daftar')

@section('content')
<div class="container">
    <div class="auth-form">
        <h2>Buat Akun Baru</h2>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required autofocus>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>
            
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Daftar</button>
            </div>
            
            <div class="text-center mt-3">
                <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
            </div>
        </form>
    </div>
</div>
@endsection
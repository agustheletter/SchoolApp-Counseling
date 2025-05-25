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
                <label for="name" class="form-label">Nama Lengkap dan Gelar</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus>
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
            
            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <div class="d-flex gap-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender-male" value="male" {{ old('gender') == 'male' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="gender-male">
                            Laki-laki
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender-female" value="female" {{ old('gender') == 'female' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="gender-female">
                            Perempuan
                        </label>
                    </div>
                </div>
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
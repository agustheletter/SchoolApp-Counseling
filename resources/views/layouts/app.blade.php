<!DOCTYPE html>
<html lang="id" data-bs-theme="{{ Auth::check() && Auth::user()->theme ? Auth::user()->theme : config('app.default_theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Konseling SMK NEGERI 1 CIMAHI - @yield('title', 'Beranda')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> 
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS (Animate On Scroll) CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
   
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* Base Variables */
        :root {
            --primary-light: #6c5ce7;
            --secondary-light: #ffc107;
            --light-bg: #f8f9fa;
            --dark-text: #343a40;
            --white-text: #ffffff;
            --primary-hover-light: #5649c0;
            --secondary-hover-light: #e0a800;

            --primary-dark: #8a7ff0; 
            --secondary-dark: #ffd043; 
            --dark-bg: #212529;  
            --dark-surface-bg: #343a40;  
            --light-text-dark-theme: #f8f9fa;  
            --muted-text-dark-theme: #adb5bd;  
            --primary-hover-dark: #796de0;
            --secondary-hover-dark: #f0c032;
        } 
        
        body {
            --app-primary: var(--primary-light);
            --app-secondary: var(--secondary-light);
            --app-body-bg: var(--light-bg);
            --app-body-color: var(--dark-text);
            --app-card-bg: var(--white-text);
            --app-card-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            --app-navbar-bg: var(--white-text);
            --app-navbar-color: var(--dark-text);
            --app-footer-bg: var(--dark-text);
            --app-footer-color: var(--white-text);
            --app-btn-primary-bg: var(--primary-light);
            --app-btn-primary-border: var(--primary-light);
            --app-btn-primary-hover-bg: var(--primary-hover-light);
            --app-btn-primary-hover-border: var(--primary-hover-light);
            --app-btn-secondary-bg: var(--secondary-light);
            --app-btn-secondary-border: var(--secondary-light);
            --app-btn-secondary-color: var(--dark-text);
            --app-btn-secondary-hover-bg: var(--secondary-hover-light);
            --app-btn-secondary-hover-border: var(--secondary-hover-light);
        }

        [data-bs-theme="dark"] body {
            --app-primary: var(--primary-dark);
            --prmimary-light: var(--primary-dark);
            --app-secondary: var(--secondary-dark);
            --app-body-bg: var(--dark-bg);
            --app-body-color: var(--light-text-dark-theme);
            --app-card-bg: var(--dark-surface-bg);
            --app-card-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            --app-navbar-bg: var(--dark-surface-bg);
            --app-navbar-color: var(--light-text-dark-theme);
            --app-footer-bg: var(--dark-surface-bg);
            --app-footer-color: var(--light-text-dark-theme);
            --app-btn-primary-bg: var(--primary-dark);
            --app-btn-primary-border: var(--primary-dark);
            --app-btn-primary-hover-bg: var(--primary-hover-dark);
            --app-btn-primary-hover-border: var(--primary-hover-dark);
            --app-btn-secondary-bg: var(--secondary-dark);
            --app-btn-secondary-border: var(--secondary-dark);
            --app-btn-secondary-color: var(--dark-text);
            --app-btn-secondary-hover-bg: var(--secondary-hover-dark);
            --app-btn-secondary-hover-border: var(--secondary-hover-dark);
        }
        
        /* Base Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--app-body-bg);
            color: var(--app-body-color);
            transition: background-color 0.3s ease, color 0.3s ease;
            overflow-x: hidden;
        }
        
        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }
        
        /* Custom animations for elements without AOS */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }
            50% {
                opacity: 1;
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        /* Navbar styling with animation */
        .navbar {
            background-color: var(--app-navbar-bg) !important;
            transition: all 0.3s ease;
            padding: 0.75rem 1rem;
            animation: fadeInDown 0.8s ease-out;
        }
        
        .navbar.scrolled {
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--app-primary) !important;
            font-size: 1.5rem;
            transition: transform 0.3s ease;
        }
        
        .navbar-brand:hover {
            transform: scale(1.05);
        }
        
        .navbar .nav-link {
            color: var(--app-navbar-color) !important;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .navbar .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: var(--app-primary);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .navbar .nav-link:hover::after,
        .navbar .nav-link.active::after {
            width: 80%;
        }
        
        .navbar .nav-link:hover {
            color: var(--app-primary) !important;
            transform: translateY(-2px);
        }
        
        .navbar-toggler {
            border: none;
            padding: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .navbar-toggler:focus {
            box-shadow: none;
            outline: none;
        }
        
        .navbar-toggler:hover {
            transform: scale(1.1);
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28var%28--app-navbar-color-rgb-tuple, 0, 0, 0%29, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        [data-bs-theme="dark"] .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28248, 249, 250, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Button styling with animations */
        .btn {
            border-radius: 8px;
            padding: 0.5rem 1.25rem;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .btn-primary {
            background-color: var(--app-btn-primary-bg);
            border-color: var(--app-btn-primary-border);
            color: var(--white-text);
        }
        
        .btn-primary:hover {
            background-color: var(--app-btn-primary-hover-bg);
            border-color: var(--app-btn-primary-hover-border);
        }
        
        .btn-secondary {
            background-color: var(--app-btn-secondary-bg);
            border-color: var(--app-btn-secondary-border);
            color: var(--app-btn-secondary-color);
        }
        
        .btn-secondary:hover {
            background-color: var(--app-btn-secondary-hover-bg);
            border-color: var(--app-btn-secondary-hover-border);
            color: var(--app-btn-secondary-color);
        }
        
        /* Hero section styling with animations */
        .hero-section {
            background-color: var(--app-primary);
            color: var(--white-text);
            padding: 60px 0;
            border-radius: 0 0 50px 50px;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before, 
        .hero-section::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            z-index: 0;
            animation: float 6s ease-in-out infinite;
        }
        
        .hero-section::before {
            top: -100px;
            right: -100px;
            animation-delay: 0s;
        }
        
        .hero-section::after {
            bottom: -100px;
            left: -100px;
            animation-delay: 3s;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        /* Feature card styling with hover animations */
        .feature-card {
            background-color: var(--app-card-bg);
            border-radius: 15px;
            padding: 25px;
            box-shadow: var(--app-card-shadow);
            transition: all 0.3s ease;
            height: 100%;
            color: var(--app-body-color);
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(108, 92, 231, 0.1), transparent);
            transition: left 0.5s;
        }
        
        .feature-card:hover::before {
            left: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        .feature-icon {
            background-color: var(--app-primary);
            color: var(--white-text);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        
        .feature-card:hover .feature-icon {
            transform: rotateY(360deg);
            background-color: var(--app-secondary);
            color: var(--dark-text);
        }
        
        /* Team member styling with animations */
        .team-member {
            text-align: center;
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }
        
        .team-member:hover {
            transform: translateY(-5px);
        }
        
        .team-member img {
            border: 5px solid var(--app-primary);
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }
        
        .team-member:hover img {
            border-color: var(--app-secondary);
            transform: scale(1.05);
        }
        
        /* Blog card styling with animations */
        .blog-card {
            background-color: var(--app-card-bg);
            color: var(--app-body-color);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--app-card-shadow);
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }
        
        .blog-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        .blog-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .blog-card:hover img {
            transform: scale(1.1);
        }
        
        .blog-content {
            padding: 20px;
        }
        
        /* Auth form styling */
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 15px;
            background: linear-gradient(135deg, var(--app-primary) 0%, var(--app-secondary) 100%);
        }
        
        .auth-form {
            background-color: var(--app-card-bg);
            color: var(--app-body-color);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
            border: none;
            transition: all 0.3s ease;
            animation: scaleIn 0.5s ease-out;
        }
        
        [data-bs-theme="dark"] .auth-form {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        .auth-form:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }
        
        [data-bs-theme="dark"] .auth-form:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        }
        
        .auth-form h2 {
            color: var(--app-primary);
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
            font-size: 1.8rem;
        }
        
        .auth-form .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background-color: var(--app-card-bg);
            color: var(--app-body-color);
            margin-bottom: 20px;
        }
        
        .auth-form .form-control:focus {
            border-color: var(--app-primary);
            box-shadow: 0 0 0 0.2rem rgba(108, 92, 231, 0.15);
            background-color: var(--app-card-bg);
            transform: translateY(-2px);
        }
        
        [data-bs-theme="dark"] .auth-form .form-control {
            border-color: #495057;
            background-color: var(--app-card-bg);
        }
        
        [data-bs-theme="dark"] .auth-form .form-control:focus {
            border-color: var(--app-primary);
            background-color: var(--app-card-bg);
        }
        
        .auth-form .btn-primary {
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            margin-top: 10px;
        }
        
        .auth-form .text-center a {
            color: var(--app-primary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .auth-form .text-center a:hover {
            color: var(--app-secondary);
            text-decoration: underline;
            transform: translateY(-1px);
        }
        
        .auth-back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 1000;
            animation: fadeInLeft 0.8s ease-out;
        }
        
        .auth-back-btn a {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .auth-back-btn a:hover {
            background-color: rgba(255, 255, 255, 0.3);
            color: white;
            transform: translateX(-5px);
        }
        
        .auth-back-btn i {
            margin-right: 8px;
        }
        
        /* Footer styling with animations */
        .footer {
            background-color: var(--app-footer-bg);
            color: var(--app-footer-color);
            padding: 50px 0 20px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        .footer a, 
        .footer a:hover {
            color: var(--app-footer-color) !important;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .footer a:hover {
            transform: translateX(5px);
        }
        
        .footer .social-icons a {
            color: var(--app-footer-color) !important;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            display: inline-block;
            margin-right: 15px;
        }
        
        .footer .social-icons a:hover {
            transform: translateY(-3px) scale(1.2);
            color: var(--app-secondary) !important;
        }
        
        .footer hr {
            background-color: rgba(255, 255, 255, 0.2);
            opacity: 0.2;
            margin: 2rem 0;
        }
        
        [data-bs-theme="dark"] .footer hr {
            background-color: rgba(248, 249, 250, 0.2);
        }
        
        /* Highlight and section title */
        .highlight {
            color: var(--app-secondary);
            font-weight: 600;
        }
        
        .section-title {
            position: relative;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: var(--app-primary);
            transition: width 0.3s ease;
        }
        
        .section-title:hover::after {
            width: 100px;
        }
        
        /* Dropdown menu styling */
        .dropdown-menu {
            --bs-dropdown-bg: var(--app-card-bg);
            --bs-dropdown-link-color: var(--app-body-color);
            --bs-dropdown-link-hover-bg: var(--app-primary);
            --bs-dropdown-link-hover-color: var(--white-text);
            --bs-dropdown-border-color: rgba(0,0,0,0.10);
            padding: 0.5rem;
            border-radius: 10px;
            margin-top: 0.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            animation: fadeInDown 0.3s ease-out;
        }
        
        [data-bs-theme="dark"] .dropdown-menu {
            --bs-dropdown-border-color: rgba(255,255,255,0.15);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        
        .dropdown-item {
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            transform: translateX(5px);
        }
        
        .nav-item.dropdown img {
            border: 2px solid var(--app-primary);
            transition: all 0.3s ease;
        }
        
        .nav-item.dropdown:hover img {
            border-color: var(--app-secondary);
            transform: scale(1.1);
        }
        
        /* Scroll to top button */
        .scroll-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background-color: var(--app-primary);
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        
        .scroll-to-top.show {
            opacity: 1;
            visibility: visible;
        }
        
        .scroll-to-top:hover {
            background-color: var(--app-secondary);
            color: var(--dark-text);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }
        
        /* Loading animation for page transitions */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(--app-body-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 1;
            visibility: visible;
            transition: all 0.5s ease;
        }
        
        .page-loader.hidden {
            opacity: 0;
            visibility: hidden;
        }
        
        .loader-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid var(--app-primary);
            border-top: 4px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Responsive Styles */
        @media (max-width: 1199.98px) {
            .navbar-brand {
                font-size: 1.4rem;
            }
            
            .hero-section {
                padding: 50px 0;
            }
        }
        
        @media (max-width: 991.98px) {
            .navbar .nav-link {
                padding: 0.5rem 0.75rem;
            }
            
            .navbar-collapse {
                padding: 1rem 0;
                animation: fadeInDown 0.3s ease-out;
            }
            
            .navbar-nav.mx-auto {
                margin-left: 0 !important;
                margin-right: 0 !important;
                margin-bottom: 1rem;
            }
            
            .navbar .btn {
                margin-top: 0.5rem;
                margin-left: 0 !important;
                display: inline-block;
            }
            
            .hero-section {
                padding: 40px 0;
                border-radius: 0 0 30px 30px;
            }
            
            .feature-card {
                margin-bottom: 25px;
            }
            
            .scroll-to-top {
                bottom: 20px;
                right: 20px;
                width: 45px;
                height: 45px;
                font-size: 18px;
            }
        }
        
        @media (max-width: 767.98px) {
            .navbar-brand {
                font-size: 1.3rem;
            }
            
            .hero-section {
                padding: 30px 0;
                border-radius: 0 0 25px 25px;
            }
            
            .hero-section h1 {
                font-size: 2rem;
            }
            
            .hero-section p {
                font-size: 1rem;
            }
            
            .section-title {
                font-size: 1.5rem;
            }
            
            .footer {
                padding: 40px 0 20px;
                text-align: center;
            }
            
            .footer .social-icons {
                margin-bottom: 20px;
            }
            
            .footer h5 {
                margin-top: 10px;
            }
        }
        
        @media (max-width: 575.98px) {
            .navbar {
                padding: 0.5rem 1rem;
            }
            
            .navbar-brand {
                font-size: 1.2rem;
            }
            
            .hero-section {
                padding: 25px 0;
                border-radius: 0 0 20px 20px;
            }
            
            .hero-section h1 {
                font-size: 1.75rem;
            }
            
            .hero-section p {
                font-size: 0.9rem;
            }
            
            .btn {
                padding: 0.4rem 1rem;
                font-size: 0.9rem;
            }
            
            .feature-icon {
                width: 50px;
                height: 50px;
                font-size: 20px;
            }
            
            .feature-card {
                padding: 20px;
            }
            
            .team-member img {
                width: 120px;
                height: 120px;
            }
            
            .auth-form {
                padding: 30px 25px;
                margin: 15px;
                max-width: 100%;
            }
            
            .auth-container {
                padding: 20px 10px;
            }
            
            .auth-back-btn {
                position: relative;
                top: auto;
                left: auto;
                margin-bottom: 20px;
                text-align: center;
            }
            
            .footer {
                padding: 30px 0 15px;
            }
            
            .scroll-to-top {
                bottom: 15px;
                right: 15px;
                width: 40px;
                height: 40px;
                font-size: 16px;
            }
        }
        
        /* Reduce motion for users who prefer it */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
            
            html {
                scroll-behavior: auto;
            }
        }
    </style>
    
    @yield('styles')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Debug CSS to ensure dropdown visibility -->
    <style>
        .dropdown-menu {
            z-index: 9999 !important;
            position: absolute !important;
        }
        
        .dropdown-menu.show {
            display: block !important;
        }
        
        /* Debug styles */
        .dropdown-toggle {
            cursor: pointer !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded');
            console.log('Bootstrap available:', typeof bootstrap !== 'undefined');
            
            const dropdownElement = document.getElementById('userDropdown');
            console.log('Dropdown element found:', dropdownElement !== null);
            
            if (dropdownElement) {
                // Remove any existing Bootstrap initialization first
                const existingDropdown = bootstrap.Dropdown.getInstance(dropdownElement);
                if (existingDropdown) {
                    existingDropdown.dispose();
                }
                
                // Manual click handler for debugging
                dropdownElement.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Dropdown clicked');
                    
                    const dropdownMenu = this.nextElementSibling;
                    console.log('Dropdown menu found:', dropdownMenu !== null);
                    
                    if (dropdownMenu) {
                        // Toggle show class manually
                        if (dropdownMenu.classList.contains('show')) {
                            dropdownMenu.classList.remove('show');
                            this.setAttribute('aria-expanded', 'false');
                            console.log('Dropdown hidden');
                        } else {
                            dropdownMenu.classList.add('show');
                            this.setAttribute('aria-expanded', 'true');
                            console.log('Dropdown shown');
                        }
                    }
                });
                
                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!dropdownElement.contains(e.target)) {
                        const dropdownMenu = document.querySelector('#userDropdown + .dropdown-menu');
                        if (dropdownMenu && dropdownMenu.classList.contains('show')) {
                            dropdownMenu.classList.remove('show');
                            dropdownElement.setAttribute('aria-expanded', 'false');
                            console.log('Dropdown closed by outside click');
                        }
                    }
                });
            }
        });
    </script>

@yield('scripts')
</head>
<body>
    <!-- Page Loader -->
    <div class="page-loader" id="pageLoader">
        <div class="loader-spinner"></div>
    </div>

    <!-- Scroll to Top Button -->
    <button class="scroll-to-top" id="scrollToTop" onclick="scrollToTop()">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg py-3 shadow-sm sticky-top" id="mainNavbar"> 
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}" data-aos="fade-right" data-aos-duration="800">STMCounseling</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item" data-aos="fade-down" data-aos-delay="100">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active fw-bold' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item" data-aos="fade-down" data-aos-delay="200">
                        <a class="nav-link {{ request()->routeIs('services') ? 'active fw-bold' : '' }}" href="{{ route('services') }}">Layanan</a>
                    </li>
                    <li class="nav-item" data-aos="fade-down" data-aos-delay="300">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active fw-bold' : '' }}" href="{{ route('about') }}">Tentang Kami</a>
                    </li>
                    <li class="nav-item" data-aos="fade-down" data-aos-delay="400">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active fw-bold' : '' }}" href="{{ route('contact') }}">Kontak</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item d-flex align-items-center" data-aos="fade-left" data-aos-delay="500">
                            <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                        </li>
                        <li class="nav-item d-flex align-items-center" data-aos="fade-left" data-aos-delay="600">
                            <a class="btn btn-primary" href="{{ route('register') }}">Daftar</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <button class="nav-link dropdown-toggle d-flex align-items-center border-0 bg-transparent" 
                                    type="button" 
                                    id="userDropdown" 
                                    data-bs-toggle="dropdown" 
                                    aria-expanded="false">
                                @if(Auth::user()->avatar_url)
                                    <img src="{{ Auth::user()->avatar_url }}" 
                                         alt="Profile" 
                                         class="rounded-circle me-2" 
                                         width="32" 
                                         height="32"
                                         style="object-fit: cover;">
                                @else
                                    <i class="fas fa-user-circle fa-lg me-2"></i>
                                @endif
                                {{ Auth::user()->nama }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                                @if(Auth::user()->role === 'guru')
                                    <li><a class="dropdown-item" href="{{ route('teacher.dashboard') }}">Dashboard Guru</a></li>
                                    <li><a class="dropdown-item" href="{{ route('counseling.messages') }}">Pesan</a></li>
                                @elseif(Auth::user()->role === 'admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
                                    <li><a class="dropdown-item" href="{{ route('counseling.messages') }}">Pesan</a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('dashboard') }}">Layanan Konseling</a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('profile.settings') }}">Pengaturan</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Keluar</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer mt-auto py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <h5>Konseling Sekolah</h5>
                    <p>Membantu siswa menemukan potensi terbaik mereka melalui layanan konseling yang profesional dan terpercaya.</p>
                    <div class="social-icons mt-3">
                        <a href="#" data-aos="zoom-in" data-aos-delay="200"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" data-aos="zoom-in" data-aos-delay="300"><i class="fab fa-twitter"></i></a>
                        <a href="#" data-aos="zoom-in" data-aos-delay="400"><i class="fab fa-instagram"></i></a>
                        <a href="#" data-aos="zoom-in" data-aos-delay="500"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <h5>Tautan Cepat</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="mb-2"><a href="{{ route('services') }}">Layanan</a></li>
                        <li class="mb-2"><a href="{{ route('about') }}">Tentang Kami</a></li>
                        <li class="mb-2"><a href="{{ route('contact') }}">Kontak</a></li>
                        <li class="mb-2"><a href="{{ route('aboutdev') }}">About Developer</a></li>
                    </ul>
                </div>
                <div class="col-md-5 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <h5>Hubungi Kami</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Jl. Mahar Martanegara No.48 Leuwigajah, Utama 40533 Cimahi West Java</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> (082)130886438</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> konseling@stmnpbdg.com</li>
                    </ul>
                </div>
            </div>
            <hr class="mt-4 mb-4">
            <div class="text-center" data-aos="fade-up" data-aos-delay="400">
                <p class="mb-0">© {{ date('Y') }} STMCounseling. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
    <!-- AOS (Animate On Scroll) JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Custom JavaScript for animations and interactions -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS
            AOS.init({
                duration: 800,
                easing: 'ease-out-cubic',
                once: true,
                offset: 100,
                delay: 100
            });
            
            // Hide page loader
            setTimeout(function() {
                const pageLoader = document.getElementById('pageLoader');
                if (pageLoader) {
                    pageLoader.classList.add('hidden');
                    setTimeout(() => {
                        pageLoader.style.display = 'none';
                    }, 500);
                }
            }, 1000);
            
            // Navbar scroll effect
            const navbar = document.getElementById('mainNavbar');
            let lastScrollTop = 0;
            
            window.addEventListener('scroll', function() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                // Add scrolled class for backdrop effect
                if (scrollTop > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
                
                // Show/hide scroll to top button
                const scrollToTopBtn = document.getElementById('scrollToTop');
                if (scrollTop > 300) {
                    scrollToTopBtn.classList.add('show');
                } else {
                    scrollToTopBtn.classList.remove('show');
                }
                
                lastScrollTop = scrollTop;
            });
            
            // Close navbar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                const navbarCollapse = document.getElementById('navbarNav');
                const navbarToggler = document.querySelector('.navbar-toggler');
                
                if (window.innerWidth < 992) {
                    if (navbarCollapse && navbarCollapse.classList.contains('show') && 
                        !navbarCollapse.contains(event.target) && 
                        !navbarToggler.contains(event.target)) {
                        new bootstrap.Collapse(navbarCollapse).hide();
                    }
                }
            });
            
            // Close navbar when clicking on a nav link on mobile
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
            const navbarCollapse = document.getElementById('navbarNav');
            
            navLinks.forEach(function(navLink) {
                navLink.addEventListener('click', function() {
                    if (window.innerWidth < 992 && navbarCollapse.classList.contains('show')) {
                        new bootstrap.Collapse(navbarCollapse).hide();
                    }
                });
            });
            
            // Add stagger animation to cards when they come into view
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const cards = entry.target.querySelectorAll('.feature-card, .team-member, .blog-card');
                        cards.forEach(function(card, index) {
                            setTimeout(function() {
                                card.style.opacity = '1';
                                card.style.transform = 'translateY(0)';
                            }, index * 100);
                        });
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);
            
            // Observe sections with cards
            const cardSections = document.querySelectorAll('.row');
            cardSections.forEach(function(section) {
                if (section.querySelector('.feature-card, .team-member, .blog-card')) {
                    observer.observe(section);
                }
            });
            
            // Add parallax effect to hero section
            const heroSection = document.querySelector('.hero-section');
            if (heroSection) {
                window.addEventListener('scroll', function() {
                    const scrolled = window.pageYOffset;
                    const rate = scrolled * -0.5;
                    heroSection.style.transform = `translateY(${rate}px)`;
                });
            }
            
            // Add typing effect to hero title (if exists)
            const heroTitle = document.querySelector('.hero-section h1');
            if (heroTitle) {
                const text = heroTitle.textContent;
                heroTitle.textContent = '';
                heroTitle.style.borderRight = '2px solid';
                
                let i = 0;
                const typeWriter = function() {
                    if (i < text.length) {
                        heroTitle.textContent += text.charAt(i);
                        i++;
                        setTimeout(typeWriter, 100);
                    } else {
                        heroTitle.style.borderRight = 'none';
                    }
                };
                
                setTimeout(typeWriter, 1500);
            }
            
            // Add hover effect to buttons
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(function(button) {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px) scale(1.05)';
                });
                
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
            
            buttons.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.classList.add('ripple');
                    
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });
        
        // Scroll to top function
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
        
        // Add smooth scrolling to anchor links
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Add CSS for ripple effect
        const style = document.createElement('style');
        style.textContent = `
            .btn {
                position: relative;
                overflow: hidden;
            }
            
            .ripple {
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.6);
                transform: scale(0);
                animation: ripple-animation 0.6s linear;
                pointer-events: none;
            }
            
            @keyframes ripple-animation {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
    
    @yield('scripts')
</body>
</html>
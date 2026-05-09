<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CuraSure: A Web-Based Walk-In Patient Management and Queue Monitoring System for Clinic Operations</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0f766e;
            --primary-dark: #0d9488;
            --secondary: #1e293b;
            --accent: #f0fdfa;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --bg-light: #f8fafc;
            --white: #ffffff;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
            overflow-x: hidden;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 600;
        }
        
        /* Navigation */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        .navbar-brand {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary);
            text-decoration: none;
        }
        
        .nav-link {
            color: var(--text-dark);
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            transition: color 0.3s;
        }
        
        .nav-link:hover {
            color: var(--primary);
        }
        
        .btn-primary-custom {
            background: var(--primary);
            color: white;
            padding: 0.625rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            border: none;
            transition: all 0.3s;
        }
        
        .btn-primary-custom:hover {
            background: var(--primary-dark);
            color: white;
            transform: translateY(-2px);
        }
        
        /* Hero Section */
        .hero-section {
            padding: 8rem 0 4rem;
            background: linear-gradient(135deg, #f0fdfa 0%, #f8fafc 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .hero-title {
            font-size: 3.5rem;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            color: var(--secondary);
        }
        
        .hero-title span {
            color: var(--primary);
        }
        
        .hero-description {
            font-size: 1.25rem;
            color: var(--text-muted);
            margin-bottom: 2rem;
            max-width: 540px;
        }
        
        .hero-buttons {
            display: flex;
            gap: 1rem;
            margin-bottom: 3rem;
        }
        
        .btn-outline-custom {
            padding: 0.625rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            border: 2px solid var(--primary);
            color: var(--primary);
            background: transparent;
            transition: all 0.3s;
        }
        
        .btn-outline-custom:hover {
            background: var(--primary);
            color: white;
        }
        
        .hero-visual {
            position: relative;
        }
        
        .dashboard-mockup {
            background: white;
            border-radius: 16px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15);
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        
        .mockup-header {
            background: #f1f5f9;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .mockup-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }
        
        .mockup-dot.red { background: #ef4444; }
        .mockup-dot.yellow { background: #eab308; }
        .mockup-dot.green { background: #22c55e; }
        
        .mockup-content {
            padding: 1.5rem;
        }
        
        .mockup-box {
            background: #f8fafc;
            border-radius: 16px;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border: 1px solid #e2e8f0;
            min-height: 115px;
        }
        
        .mockup-box i {
            font-size: 1.75rem;
            color: #0f766e;
        }
        
        .mockup-box span {
            font-weight: 600;
            color: #1e293b;
        }
        
        /* Features Section */
        .features-section {
            padding: 5rem 0;
            background: var(--white);
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }
        
        .section-title {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .section-subtitle {
            color: var(--text-muted);
            font-size: 1.125rem;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .feature-card {
            padding: 2rem;
            border-radius: 16px;
            background: var(--bg-light);
            height: 100%;
            transition: all 0.3s;
            border: 1px solid transparent;
        }
        
        .feature-card:hover {
            background: white;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            border-color: #e2e8f0;
            transform: translateY(-5px);
        }
        
        .feature-icon {
            width: 56px;
            height: 56px;
            background: var(--accent);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
            color: var(--primary);
            font-size: 1.5rem;
        }
        
        .feature-title {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }
        
        .feature-description {
            color: var(--text-muted);
            font-size: 0.95rem;
        }
        
        /* Problem & Solution */
        .problem-section {
            padding: 5rem 0;
            background: var(--secondary);
            color: white;
        }
        
        .problem-section .section-title {
            color: white;
        }
        
        .problem-section .section-subtitle {
            color: rgba(255,255,255,0.7);
        }
        
        .problem-card {
            background: rgba(255,255,255,0.1);
            border-radius: 16px;
            padding: 2rem;
            height: 100%;
            backdrop-filter: blur(10px);
        }
        
        .problem-card h4 {
            color: var(--primary-dark);
            margin-bottom: 1rem;
            font-size: 1.25rem;
        }
        
        .problem-card p {
            color: rgba(255,255,255,0.8);
            font-size: 0.95rem;
        }
        
        .solution-card {
            background: rgba(15, 118, 110, 0.2);
            border: 1px solid rgba(15, 118, 110, 0.3);
            border-radius: 16px;
            padding: 2rem;
            height: 100%;
        }
        
        .solution-card h4 {
            color: var(--primary-dark);
            margin-bottom: 1rem;
            font-size: 1.25rem;
        }
        
        .solution-card p {
            color: rgba(255,255,255,0.9);
            font-size: 0.95rem;
        }
        
        /* Preview Section */
        .preview-section {
            padding: 5rem 0;
            background: var(--bg-light);
        }
        
        .preview-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
        }
        
        .preview-image {
            background: linear-gradient(135deg, #e0f2f1 0%, #f0fdfa 100%);
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 3rem;
        }
        
        .preview-caption {
            padding: 1.25rem;
            border-top: 1px solid #e2e8f0;
        }
        
        .preview-caption h5 {
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }
        
        .preview-caption p {
            color: var(--text-muted);
            font-size: 0.875rem;
            margin: 0;
        }
        
        /* Workflow Section */
        .workflow-step {
            padding: 2rem 1rem;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            height: 100%;
            transition: transform 0.3s;
        }
        
        .workflow-step:hover {
            transform: translateY(-5px);
        }
        
        .step-number {
            width: 40px;
            height: 40px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin: 0 auto 1rem;
            font-size: 1.1rem;
        }
        
        .workflow-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }
        
        .workflow-step h5 {
            color: var(--secondary);
            margin-bottom: 0.5rem;
        }
        
        /* Tech Stack */
        .tech-section {
            padding: 5rem 0;
            background: var(--white);
        }
        
        .tech-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1rem;
        }
        
        .tech-badge {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 1.5rem;
            background: var(--bg-light);
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .tech-badge:hover {
            background: var(--primary);
            color: white;
            transform: scale(1.05);
        }
        
        .tech-badge i {
            font-size: 1.5rem;
        }
        
        /* Benefits */
        .benefits-section {
            padding: 5rem 0;
            background: linear-gradient(135deg, var(--primary) 0%, #0d9488 100%);
            color: white;
        }
        
        .benefits-section .section-title {
            color: white;
        }
        
        .benefits-section .section-subtitle {
            color: rgba(255,255,255,0.8);
        }
        
        .benefit-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .benefit-icon {
            width: 48px;
            height: 48px;
            background: rgba(255,255,255,0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.25rem;
        }
        
        .benefit-item h5 {
            font-size: 1.125rem;
            margin-bottom: 0.25rem;
        }
        
        .benefit-item p {
            color: rgba(255,255,255,0.8);
            font-size: 0.95rem;
            margin: 0;
        }
        
        /* About */
        .about-section {
            padding: 5rem 0;
            background: var(--bg-light);
        }
        
        .about-card {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        }
        
        .about-role {
            display: inline-block;
            background: var(--accent);
            color: var(--primary);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 1rem;
        }
        
        /* Contact */
        .contact-section {
            padding: 5rem 0;
            background: var(--secondary);
            color: white;
        }
        
        .contact-section .section-title {
            color: white;
        }
        
        .contact-section .section-subtitle {
            color: rgba(255,255,255,0.7);
        }
        
        .social-links {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 2rem;
        }
        
        .social-link {
            width: 56px;
            height: 56px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            transition: all 0.3s;
            text-decoration: none;
        }
        
        .social-link:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-5px);
        }
        
        /* Footer */
        .footer {
            padding: 2rem 0;
            background: var(--secondary);
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        
        .footer p {
            color: rgba(255,255,255,0.6);
            margin: 0;
            font-size: 0.875rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-section {
                padding: 6rem 0 3rem;
            }
            
            .hero-buttons {
                flex-direction: column;
            }
            
            .section-title {
                font-size: 2rem;
            }
        }
        
        /* Animations */
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
        
        .animate-fade-in {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar-custom">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="#" class="navbar-brand">
                     <img src="{{ asset('img/logo1.png') }}" alt="Laravel Clinic System" style="width:64px; height:64px; object-fit:contain; margin-right:8px;">
                    <span style="font-family: 'Space Grotesk', sans-serif; font-weight:600;">Clinic System</span>
                </a>
                <div class="d-flex align-items-center gap-3">
                    <a href="#features" class="nav-link d-none d-md-block">Features</a>
                    <a href="#preview" class="nav-link d-none d-md-block">Preview</a>
                    <a href="#tech" class="nav-link d-none d-md-block">Tech Stack</a>
                    <a href="{{ route('login') }}" class="btn btn-primary-custom">Get Started</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                     <div class="animate-fade-in">
                         <div class="hero-badge">
                             <i class="bi bi-check-circle-fill"></i>
                             Laravel Clinic Management System
                         </div>
                         <h1 class="hero-title">
                             <span style="color: var(--primary); display: block; font-size: 1.8rem; font-weight: 700; line-height: 1.3;">CuraSure:</span>
                             Clinic Walk-In <span>Management</span> System
                         </h1>
                         <p style="font-size: 1.1rem; color: var(--primary); font-weight: 500; margin-bottom: 1rem;">
                             A Web-Based Walk-In Patient Management and Queue Monitoring System for Clinic Operations
                         </p>
                         <p class="hero-description">
                             A comprehensive Laravel-based system for managing patient queues, medical records, 
                             and clinic operations with role-based access for staff, doctors, and administrators.
                         </p>
                         <div class="hero-buttons">
                             <a href="#demo" class="btn btn-primary-custom">
                                 <i class="bi bi-play-circle me-2"></i>View System Demo
                             </a>
                             <a href="#features" class="btn btn-outline-custom">
                                 Explore Features
                             </a>
                         </div>
                     </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-visual animate-fade-in delay-200">
                        <div class="dashboard-mockup">
                            <div class="mockup-header">
                                <span class="mockup-dot red"></span>
                                <span class="mockup-dot yellow"></span>
                                <span class="mockup-dot green"></span>
                            </div>
                            <div class="mockup-content">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 style="font-size: 1.1rem; margin: 0;">Today's Queue Status</h5>
                                    <span class="badge bg-success">Live System</span>
                                </div>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="mockup-box">
                                            <i class="bi bi-person-plus-fill"></i>
                                            <span>Patient Registration</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mockup-box">
                                            <i class="bi bi-list-ol"></i>
                                            <span>Queue: Q-001, Q-002</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mockup-box">
                                            <i class="bi bi-stethoscope"></i>
                                            <span>Doctor Consultation</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mockup-box">
                                            <i class="bi bi-file-earmark-medical-fill"></i>
                                            <span>Medical Records</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Core System Features</h2>
                <p class="section-subtitle">
                    Built with Laravel 12, featuring role-based access and real-time queue management
                </p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-person-plus-fill"></i>
                        </div>
                        <h4 class="feature-title">Smart Patient Registration</h4>
                        <p class="feature-description">
                            Duplicate prevention with multi-field validation. Automatic queue number generation (Q-001, Q-002) and priority handling for seniors, PWD, pregnant patients.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-list-ol"></i>
                        </div>
                        <h4 class="feature-title">Real-Time Queue Management</h4>
                        <p class="feature-description">
                            Live queue status updates (waiting → diagnosing → done). Priority-based ordering with public waiting area display for patient visibility.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-stethoscope"></i>
                        </div>
                        <h4 class="feature-title">Doctor Consultation Interface</h4>
                        <p class="feature-description">
                            Room-specific queue filtering, one-click patient calling, digital medical records with symptoms, diagnosis, prescription, and consultation notes.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>
                        <h4 class="feature-title">Role-Based Access Control</h4>
                        <p class="feature-description">
                            Three user roles: Admin (full access), Doctor (consultations), Staff (registration). Secure authentication with appropriate permissions.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-file-earmark-medical-fill"></i>
                        </div>
                        <h4 class="feature-title">Comprehensive Medical Records</h4>
                        <p class="feature-description">
                            Patient snapshots for data integrity, searchable medical history, PDF prescription generation, and consultation time tracking.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-bar-chart-line-fill"></i>
                        </div>
                        <h4 class="feature-title">Admin Dashboard & Reports</h4>
                        <p class="feature-description">
                            Real-time statistics, user management, system settings, daily/monthly reports with patient volume, consultation metrics, and performance analytics.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Problem & Solution Section -->
    <section class="problem-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">The Challenge & Our Solution</h2>
                <p class="section-subtitle">
                    Addressing real clinic management inefficiencies with digital transformation
                </p>
            </div>
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="problem-card">
                        <h4><i class="bi bi-exclamation-triangle me-2"></i>Traditional Clinic Challenges</h4>
                        <p>
                            Clinics struggle with manual patient registration, paper-based queue systems, 
                            inconsistent medical records, and lack of real-time visibility. Staff waste time 
                            on administrative tasks, patients experience long waits, and data accuracy suffers 
                            from manual entry errors and lost paperwork.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="solution-card">
                        <h4><i class="bi bi-lightbulb me-2"></i>Laravel-Powered Digital Solution</h4>
                        <p>
                            Our system automates patient registration with duplicate prevention, provides 
                            real-time queue management with priority handling, enables digital medical 
                            consultations, and offers comprehensive reporting. Built with Laravel 12, 
                            MySQL, and Bootstrap 5 for a robust, scalable healthcare management platform.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- System Demo Section -->
    <section id="demo" class="preview-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Live System Demonstration</h2>
                <p class="section-subtitle">
                    Experience the core functionality of our Laravel clinic management system
                </p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="preview-card">
                        <div class="preview-image">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <div class="preview-caption">
                            <h5>Role-Based Login</h5>
                            <p>Secure authentication for Admin, Doctor, and Staff roles</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="preview-card">
                        <div class="preview-image">
                            <i class="bi bi-person-plus"></i>
                        </div>
                        <div class="preview-caption">
                            <h5>Staff Dashboard</h5>
                            <p>Patient registration with duplicate prevention and queue management</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="preview-card">
                        <div class="preview-image">
                            <i class="bi bi-list-check"></i>
                        </div>
                        <div class="preview-caption">
                            <h5>Queue Management</h5>
                            <p>Real-time queue display with status: waiting → diagnosing → done</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="preview-card">
                        <div class="preview-image">
                            <i class="bi bi-stethoscope"></i>
                        </div>
                        <div class="preview-caption">
                            <h5>Doctor Interface</h5>
                            <p>Room-specific queue, patient calling, and medical record creation</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="preview-card">
                        <div class="preview-image">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <div class="preview-caption">
                            <h5>Medical Records</h5>
                            <p>Digital consultations with diagnosis, prescriptions, and patient history</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="preview-card">
                        <div class="preview-image">
                            <i class="bi bi-bar-chart"></i>
                        </div>
                        <div class="preview-caption">
                            <h5>Admin Dashboard</h5>
                            <p>System analytics, user management, and comprehensive reporting</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <a href="{{ route('login') }}" class="btn btn-primary-custom btn-lg">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Access Live System
                </a>
                <p class="text-muted mt-3">Login credentials available for demonstration</p>
            </div>
        </div>
    </section>

    <!-- Tech Stack Section -->
    <section id="tech" class="tech-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Technology Stack</h2>
                <p class="section-subtitle">
                    Built with Laravel 12 and modern web technologies for robust clinic management
                </p>
            </div>
            <div class="tech-grid">
                <div class="tech-badge">
                    <i class="bi bi-code-slash"></i>
                    PHP 8.2+
                </div>
                <div class="tech-badge">
                    <i class="bi bi-box-seam"></i>
                    Laravel 12 Framework
                </div>
                <div class="tech-badge">
                    <i class="bi bi-database"></i>
                    MySQL (Clever Cloud)
                </div>
                <div class="tech-badge">
                    <i class="bi bi-bootstrap"></i>
                    Bootstrap 5.3.3
                </div>
                <div class="tech-badge">
                    <i class="bi bi-braces"></i>
                    Tailwind CSS
                </div>
                <div class="tech-badge">
                    <i class="bi bi-hammer"></i>
                    Vite Build Tool
                </div>
                <div class="tech-badge">
                    <i class="bi bi-file-earmark-pdf"></i>
                    DomPDF (Reports)
                </div>
                <div class="tech-badge">
                    <i class="bi bi-shield-check"></i>
                    Laravel Breeze Auth
                </div>
            </div>
        </div>
    </section>

    <!-- System Workflow Section -->
    <section class="preview-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">System Workflow</h2>
                <p class="section-subtitle">
                    How the clinic management system operates from patient arrival to consultation completion
                </p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <div class="workflow-step">
                            <div class="step-number">1</div>
                            <i class="bi bi-person-plus-fill workflow-icon"></i>
                            <h5>Patient Registration</h5>
                            <p class="text-muted">Staff registers patient, prevents duplicates, assigns queue number</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <div class="workflow-step">
                            <div class="step-number">2</div>
                            <i class="bi bi-list-ol workflow-icon"></i>
                            <h5>Queue Management</h5>
                            <p class="text-muted">Patient joins queue with priority handling (senior, PWD, urgent)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <div class="workflow-step">
                            <div class="step-number">3</div>
                            <i class="bi bi-telephone-forward-fill workflow-icon"></i>
                            <h5>Doctor Calls Patient</h5>
                            <p class="text-muted">Doctor calls next patient, status changes to 'diagnosing'</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <div class="workflow-step">
                            <div class="step-number">4</div>
                            <i class="bi bi-check-circle-fill workflow-icon"></i>
                            <h5>Consultation Complete</h5>
                            <p class="text-muted">Medical record saved, patient marked as 'done', queue advances</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <div class="alert alert-info d-inline-block">
                    <strong>Real-time Updates:</strong> All users see live queue status changes across the system
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="benefits-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Benefits & Impact</h2>
                <p class="section-subtitle">
                    How CuraSure transforms clinic operations
                </p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div>
                            <h5>Reduced Wait Times</h5>
                            <p>Automated queue management ensures patients are seen promptly based on priority and arrival time.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div>
                            <h5>Improved Data Security</h5>
                            <p>Role-based access control protects sensitive patient information while enabling appropriate data sharing.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="bi bi-receipt"></i>
                        </div>
                        <div>
                            <h5>Accurate Billing</h5>
                            <p>Automated fee calculation based on checkup types eliminates human error and ensures consistent pricing.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="bi bi-person-check"></i>
                        </div>
                        <div>
                            <h5>Duplicate Patient Prevention</h5>
                            <p>Smart registration checks and validation prevent duplicate patient records, keeping the database clean and reliable.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="bi bi-bar-chart"></i>
                        </div>
                        <div>
                            <h5>Data-Driven Decisions</h5>
                            <p>Comprehensive reports provide insights into clinic performance, patient trends, and revenue analysis.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="about-card">
                        <span class="about-role">Laravel Full-Stack Project</span>
                        <h2 class="section-title mb-4">CuraSure: A Web-Based Walk-In Patient Management and Queue Monitoring System for Clinic Operations</h2>
                        <p class="text-muted mb-4">
                            This comprehensive clinic walk-in management system was developed using Laravel 12 
                            to demonstrate advanced web development skills including role-based authentication, 
                            real-time data management, and complex database relationships.
                        </p>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <h5><i class="bi bi-code-slash me-2 text-primary"></i>Technology</h5>
                                <p class="text-muted mb-0">Laravel 12, MySQL, Bootstrap 5, Vite</p>
                            </div>
                            <div class="col-md-6">
                                <h5><i class="bi bi-database me-2 text-primary"></i>Database</h5>
                                <p class="text-muted mb-0">8+ tables with complex relationships</p>
                            </div>
                            <div class="col-md-6">
                                <h5><i class="bi bi-people me-2 text-primary"></i>User Roles</h5>
                                <p class="text-muted mb-0">Admin, Doctor, Staff with specific permissions</p>
                            </div>
                            <div class="col-md-6">
                                <h5><i class="bi bi-check-circle me-2 text-primary"></i>Features</h5>
                                <p class="text-muted mb-0">CRUD operations, real-time updates, PDF generation</p>
                            </div>
                        </div>
                        <div class="mt-4 p-3 bg-light rounded">
                            <h6 class="text-primary mb-2"><i class="bi bi-lightbulb me-2"></i>Key Technical Achievements</h6>
                            <ul class="text-muted mb-0 small">
                                <li>Role-based middleware implementation</li>
                                <li>Real-time queue management with status tracking</li>
                                <li>Duplicate patient prevention algorithms</li>
                                <li>Database transactions for data integrity</li>
                                <li>PDF report generation with DomPDF</li>
                                <li>Responsive design with Bootstrap 5</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Get In Touch</h2>
                <p class="section-subtitle">
                    Interested in learning more about the Laravel 12 clinic system or collaborating on the project?
                </p>
            </div>
            <div class="social-links">
                <a href="https://github.com/meljimm17" class="social-link" title="GitHub" target="_blank" rel="noopener noreferrer">
                    <i class="bi bi-github"></i>
                </a>
                <a href="https://www.linkedin.com/in/mel-jimm-joves-7948103ba/" class="social-link" title="LinkedIn" traget="_blank" rel="noopener noreferrer">
                    <i class="bi bi-linkedin"></i>
                </a>
                <a href="https://mail.google.com/mail/?view=cm&to=jovesmeljimm@gmail.com" class="social-link" title="Email" target="_blank" rel="noopener noreferrer">
                    <i class="bi bi-envelope"></i>
                </a>
                <a href="https://www.instagram.com/melj_jvs" class="social-link" title="Instagram" target="_blank" rel="noopener noreferrer">
                    <i class="bi bi-instagram"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <p>&copy; 2026 CuraSure - Walk-In Patient Management System. All rights reserved.</p>
                <p>Built with <i class="bi bi-heart-fill text-danger"></i> using Laravel 12 & MySQL</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
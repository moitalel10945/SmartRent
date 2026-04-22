<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartRent – Tenant</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --font-ui: 'DM Sans', sans-serif;
            --font-display: 'Instrument Serif', serif;

            --bg-base:      #f5f5f4;
            --bg-surface:   #ffffff;
            --bg-overlay:   #fafaf9;
            --border:       #e7e5e4;
            --border-hover: #d6d3d1;
            --text-primary: #1c1917;
            --text-secondary: #78716c;
            --text-muted:   #a8a29e;
            --accent:       #0f172a;
            --accent-hover: #1e293b;
            --accent-text:  #ffffff;
            --nav-active-bg:   #0f172a;
            --nav-active-text: #ffffff;
            --nav-hover-bg:    #f5f5f4;
            --nav-text:        #57534e;
            --danger:       #dc2626;
            --danger-bg:    #fef2f2;
            --success:      #16a34a;
            --success-bg:   #f0fdf4;
            --warning:      #d97706;
            --warning-bg:   #fffbeb;
            --sidebar-w:    260px;
        }

        html.dark {
            --bg-base:      #0f0f0f;
            --bg-surface:   #1a1a1a;
            --bg-overlay:   #141414;
            --border:       #2a2a2a;
            --border-hover: #3a3a3a;
            --text-primary: #fafaf9;
            --text-secondary: #a8a29e;
            --text-muted:   #57534e;
            --accent:       #e7e5e4;
            --accent-hover: #ffffff;
            --accent-text:  #0f0f0f;
            --nav-active-bg:   #ffffff;
            --nav-active-text: #0f0f0f;
            --nav-hover-bg:    #222222;
            --nav-text:        #a8a29e;
            --danger:       #f87171;
            --danger-bg:    #1c0a0a;
            --success:      #4ade80;
            --success-bg:   #0a1c0f;
            --warning:      #fbbf24;
            --warning-bg:   #1c1400;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: var(--font-ui);
            background: var(--bg-base);
            color: var(--text-primary);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        .app-shell { display: flex; min-height: 100vh; }

        .sidebar {
            width: var(--sidebar-w);
            background: var(--bg-surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 50;
            transition: transform 0.25s cubic-bezier(0.4,0,0.2,1);
        }

        .sidebar-brand {
            padding: 1.5rem 1.5rem 1.25rem;
            border-bottom: 1px solid var(--border);
        }

        .brand-wordmark {
            font-family: var(--font-display);
            font-size: 1.35rem;
            color: var(--text-primary);
            letter-spacing: -0.01em;
            display: block;
            line-height: 1;
        }

        .brand-role {
            font-size: 0.65rem;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-top: 0.3rem;
            display: block;
        }

        .sidebar-nav {
            flex: 1;
            padding: 1rem 0.75rem;
            overflow-y: auto;
        }

        .nav-section-label {
            font-size: 0.65rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 0.75rem 0.75rem 0.4rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.8125rem;
            font-weight: 500;
            color: var(--nav-text);
            text-decoration: none;
            transition: background 0.15s, color 0.15s;
            margin-bottom: 1px;
        }

        .nav-link:hover {
            background: var(--nav-hover-bg);
            color: var(--text-primary);
        }

        .nav-link.active {
            background: var(--nav-active-bg);
            color: var(--nav-active-text);
        }

        .nav-icon {
            width: 1rem;
            height: 1rem;
            opacity: 0.7;
            flex-shrink: 0;
        }

        .nav-link.active .nav-icon { opacity: 1; }

        .sidebar-footer {
            padding: 0.75rem;
            border-top: 1px solid var(--border);
        }

        .user-block {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            margin-bottom: 0.25rem;
        }

        .user-avatar {
            width: 1.75rem;
            height: 1.75rem;
            border-radius: 50%;
            background: var(--accent);
            color: var(--accent-text);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.6875rem;
            font-weight: 600;
            flex-shrink: 0;
        }

        .user-name {
            font-size: 0.8125rem;
            font-weight: 500;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            width: 100%;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.8125rem;
            font-weight: 500;
            color: var(--danger);
            background: none;
            border: none;
            cursor: pointer;
            text-align: left;
            transition: background 0.15s;
        }

        .logout-btn:hover { background: var(--danger-bg); }

        .main-area {
            flex: 1;
            margin-left: var(--sidebar-w);
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .topbar {
            background: var(--bg-surface);
            border-bottom: 1px solid var(--border);
            padding: 0 2rem;
            height: 3.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .topbar-date {
            font-size: 0.8125rem;
            color: var(--text-muted);
            font-weight: 400;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .hamburger {
            display: none;
            flex-direction: column;
            gap: 4px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
        }

        .hamburger span {
            display: block;
            width: 20px;
            height: 1.5px;
            background: var(--text-primary);
            transition: all 0.2s;
            border-radius: 2px;
        }

        .theme-toggle {
            width: 2rem;
            height: 2rem;
            border-radius: 0.5rem;
            border: 1px solid var(--border);
            background: var(--bg-surface);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: border-color 0.15s, background 0.15s;
            color: var(--text-secondary);
        }

        .theme-toggle:hover {
            border-color: var(--border-hover);
            background: var(--bg-overlay);
            color: var(--text-primary);
        }

        .theme-toggle svg { width: 1rem; height: 1rem; }
        .icon-sun { display: none; }
        html.dark .icon-sun { display: block; }
        html.dark .icon-moon { display: none; }

        .page-content {
            flex: 1;
            padding: 2rem;
            max-width: 1200px;
            width: 100%;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 45;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
                box-shadow: 0 0 40px rgba(0,0,0,0.2);
            }

            .main-area {
                margin-left: 0;
            }

            .topbar {
                padding: 0 1rem;
            }

            .hamburger {
                display: flex;
            }

            .page-content {
                padding: 1.25rem 1rem;
            }

            .sidebar-overlay.open {
                display: block;
            }
        }
    </style>
</head>
<body>

<div class="app-shell">

    <div class="sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <span class="brand-wordmark">SmartRent</span>
            <span class="brand-role">Tenant Portal</span>
        </div>

        <nav class="sidebar-nav">
            <span class="nav-section-label">My Home</span>

            <a href="{{ route('tenant.dashboard.index') }}"
               class="nav-link {{ request()->routeIs('tenant.dashboard*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>

            <a href="{{ route('tenant.unit') }}"
               class="nav-link {{ request()->routeIs('tenant.unit') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                </svg>
                My Unit
            </a>

            <span class="nav-section-label" style="margin-top:0.5rem">Payments</span>

            <a href="{{ route('tenant.payments.index') }}"
               class="nav-link {{ request()->routeIs('tenant.payments*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                My Payments
            </a>
        </nav>

        <a href="{{ route('profile.edit') }}"
            class="nav-link {{ request()->routeIs('profile*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                My Profile
        </a>
        <div class="sidebar-footer">
            <div class="user-block">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <span class="user-name">{{ auth()->user()->name }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <svg style="width:1rem;height:1rem;opacity:0.7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Sign out
                </button>
            </form>
        </div>
    </aside>

    <div class="main-area">
        <header class="topbar">
            <div style="display:flex;align-items:center;gap:0.75rem">
                <button class="hamburger" onclick="openSidebar()" aria-label="Open menu">
                    <span></span><span></span><span></span>
                </button>
                <span class="topbar-date">{{ now()->format('l, d F Y') }}</span>
            </div>
            <div class="topbar-actions">
                <button class="theme-toggle" onclick="toggleTheme()" aria-label="Toggle theme">
                    <svg class="icon-moon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                    <svg class="icon-sun" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </button>
            </div>
        </header>

        <main class="page-content">
            {{ $slot }}
        </main>
    </div>

</div>

<script>
    (function() {
        const saved = localStorage.getItem('sr-theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (saved === 'dark' || (!saved && prefersDark)) {
            document.documentElement.classList.add('dark');
        }
    })();

    function toggleTheme() {
        const isDark = document.documentElement.classList.toggle('dark');
        localStorage.setItem('sr-theme', isDark ? 'dark' : 'light');
    }

    function openSidebar() {
        document.getElementById('sidebar').classList.add('open');
        document.getElementById('sidebar-overlay').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebar-overlay').classList.remove('open');
        document.body.style.overflow = '';
    }

    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', closeSidebar);
    });
</script>

</body>
</html>
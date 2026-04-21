<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartRent – Tenant</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 bg-white border-r border-gray-100 flex flex-col shrink-0">
            <div class="px-6 py-5 border-b border-gray-100">
                <span class="text-lg font-bold text-gray-900">SmartRent</span>
                <span class="ml-2 text-xs text-gray-400 font-medium uppercase tracking-wide">Tenant</span>
            </div>

            <nav class="flex-1 px-4 py-4 space-y-1">
                <a href="{{ route('tenant.dashboard.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                          {{ request()->routeIs('tenant.dashboard*') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition">
                    Dashboard
                </a>
                <a href="{{ route('tenant.unit') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                          {{ request()->routeIs('tenant.unit') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition">
                    My Unit
                </a>
                <a href="{{ route('tenant.payments.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                          {{ request()->routeIs('tenant.payments*') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition">
                    My Payments
                </a>
            </nav>

            <div class="px-4 py-4 border-t border-gray-100">
                <p class="text-xs text-gray-500 mb-2 px-3">{{ auth()->user()->name }}</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-3 py-2 rounded-lg text-sm font-medium text-red-500 hover:bg-red-50 transition">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main content --}}
        <div class="flex-1 flex flex-col min-w-0">
            <header class="bg-white border-b border-gray-100 px-8 py-4">
                <h1 class="text-sm font-medium text-gray-500">
                    {{ now()->format('l, d F Y') }}
                </h1>
            </header>

            <main class="flex-1 px-8 py-6">
                {{ $slot }}
            </main>
        </div>

    </div>

</body>
</html>
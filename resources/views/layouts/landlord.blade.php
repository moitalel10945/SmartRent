<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Landlord Portal</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="flex min-h-screen bg-gray-100">
  <!--Sidebar-->
  <aside class="w-64 bg-white shadow-md p-4">
    <h2 class="text-xl font-bold mb-6">Landlord Panel</h2>

        <nav class="space-y-2">
            <a href="{{ route('landlord.dashboard') }}">Dashboard</a><br>
            <a href="{{ route('landlord.properties.index') }}">Properties</a><br>
            <a href="{{ route('landlord.units') }}">Units</a><br>
            <a href="{{ route('landlord.tenancies') }}">Tenancies</a><br>
            <a href="{{ route('landlord.payments') }}">Payments</a><br>
            <a href="{{ route('landlord.reports') }}">Reports</a><br>
        </nav>
  </aside>

  <div class="flex-1 flex flex-col">

    <!-- Topbar -->
    <header class="bg-white shadow p-4 flex justify-between">
        <div>Landlord Portal</div>
        <div>
            {{ auth()->user()->name }}
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </header>

    <!-- Content -->
    <main class="p-6">
        {{ $slot }}
    </main>
</body>
</html>
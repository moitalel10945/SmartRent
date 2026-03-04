<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Tenant Portal</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex bg-gray-100 min-h-screen">
  <aside class="w-64 bg-white shadow-md p-4">
    <h2 class="text-xl font-bold mb-6">Tenant Panel</h2>
    <nav class="space-y-2">
      <a href="{{ route('tenant.dashboard') }}">Dashboard</a><br>
      <a  href="{{ route('tenant.unit') }}">My Unit</a><br>
      <a href=" {{ route('tenant.payment') }} ">My Payments</a><br>
      <a   href="{{ route('tenant.pay') }}">Pay Rent</a><br>
  </nav>
  </aside>
  <div class="flex flex-col flex-1">
    <header class="bg-white shadow p-4 flex justify-between">
      <div>Tenant Portal</div>
      <div>
        {{ auth()->user()->name }}
      </div>
      <form method="POST" action="{{ route('logout') }}" class="inline">
        @csrf
        <button class="text-red-500 text-sm font-bold" type="submit">Logout</button>
    </form>
    </header>
    <main>{{ $slot }}</main>
  </div>
</body>
</html>
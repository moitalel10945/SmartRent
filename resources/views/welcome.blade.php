<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartRent</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 text-gray-800">

<!-- NAVBAR -->
<nav class="fixed w-full z-50 bg-white/80 backdrop-blur border-b border-gray-200">
    <div class="max-w-6xl mx-auto flex justify-between items-center px-6 py-4">
        <h1 class="text-2xl font-bold text-indigo-600">SmartRent</h1>

        <div class="space-x-4">
            <a href="/login" class="text-gray-600 hover:text-indigo-600">Login</a>
            <a href="/register" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 shadow">
                Get Started
            </a>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="relative min-h-screen flex items-center justify-center text-center px-6">

  <!-- Background Image -->
  <div class="absolute inset-0">
      <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2"
           class="w-full h-full object-cover">
      
      <!-- Overlay -->
      <div class="absolute inset-0 bg-black/60"></div>
  </div>

  <!-- Content -->
  <div class="relative max-w-3xl text-white">
      <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-6">
          Smart Rent Collection Made Simple
      </h1>

      <p class="text-lg md:text-xl text-gray-200 mb-8">
          Automate rent payments with M-Pesa, manage tenants, and track everything in one place.
      </p>

      <div class="flex justify-center gap-4">
          <a href="/register"
             class="bg-indigo-600 px-6 py-3 rounded-lg hover:bg-indigo-700 shadow-lg">
              Get Started
          </a>

          <a href="/login"
             class="bg-white text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-100">
              Login
          </a>
      </div>
  </div>

</section>

<!-- FEATURES -->
<section class="py-20 px-6">
    <div class="max-w-6xl mx-auto text-center mb-12">
        <h2 class="text-3xl font-bold mb-4">Everything You Need</h2>
        <p class="text-gray-600">Powerful tools designed for landlords.</p>
    </div>

    <div class="max-w-6xl mx-auto grid md:grid-cols-4 gap-6">

        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <h3 class="font-bold text-lg mb-2">M-Pesa Payments</h3>
            <p class="text-gray-600 text-sm">
                Receive rent instantly via mobile payments.
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <h3 class="font-bold text-lg mb-2">Real-Time Tracking</h3>
            <p class="text-gray-600 text-sm">
                Monitor all transactions automatically.
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <h3 class="font-bold text-lg mb-2">Tenant Management</h3>
            <p class="text-gray-600 text-sm">
                Organize all tenant data in one place.
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <h3 class="font-bold text-lg mb-2">Reports</h3>
            <p class="text-gray-600 text-sm">
                Get insights into your rental income.
            </p>
        </div>

    </div>
</section>

<!-- HOW IT WORKS -->
<section class="py-20 bg-gray-100 px-6">
    <div class="max-w-6xl mx-auto text-center mb-12">
        <h2 class="text-3xl font-bold mb-4">How It Works</h2>
    </div>

    <div class="max-w-4xl mx-auto grid md:grid-cols-3 gap-8 text-center">

        <div class="bg-white p-6 rounded-xl shadow">
            <div class="text-indigo-600 text-3xl font-bold mb-2">1</div>
            <p>Add properties & tenants</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <div class="text-indigo-600 text-3xl font-bold mb-2">2</div>
            <p>Tenants pay via M-Pesa</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <div class="text-indigo-600 text-3xl font-bold mb-2">3</div>
            <p>Track everything automatically</p>
        </div>

    </div>
</section>

<!-- CTA -->
<section class="py-20 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-center px-6">
    <div class="max-w-3xl mx-auto">
        <h2 class="text-3xl font-bold mb-4">
            Ready to simplify your rental business?
        </h2>

        <a href="/register"
           class="bg-white text-indigo-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 shadow">
            Get Started Now
        </a>
    </div>
</section>

<!-- FOOTER -->
<footer class="py-6 text-center text-gray-500 text-sm">
    © {{ date('Y') }} SmartRent. All rights reserved.
</footer>

</body>
</html>
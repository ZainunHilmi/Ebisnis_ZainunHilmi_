{{-- resources/views/layouts/admin.blade.php --}}
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>@yield('title', 'Admin Dashboard')</title>

  <!-- Tailwind CDN (quick dev) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" />
</head>
<body class="bg-gray-100 min-h-screen">
  <div class="flex">
    @include('partials.admin.sidebar')

    <div class="flex-1 flex flex-col min-h-screen">
      <header class="bg-white shadow px-4 py-3 flex justify-between items-center">
        <div class="flex items-center gap-4">
          <button id="btn-toggle-sidebar" class="md:hidden p-2 rounded hover:bg-gray-100">
            <i class='bx bx-menu text-2xl'></i>
          </button>
          <h1 class="text-lg font-semibold">@yield('title','Dashboard')</h1>
        </div>

        <div class="flex items-center gap-4">
          <span class="hidden md:inline text-sm text-gray-600">Hi, {{ auth()->user()->name ?? 'Admin' }}</span>
          <form method="POST" action="{{ route('logout') }}"> @csrf
            <button class="text-sm text-red-500">Logout</button>
          </form>
        </div>
      </header>

      <main class="p-6 flex-1">
        @yield('content')
      </main>

      <footer class="mt-auto text-center text-sm text-gray-500 py-4">
        &copy; {{ date('Y') }} MyMarketplace
      </footer>
    </div>
  </div>

<script>
  const btn = document.getElementById('btn-toggle-sidebar');
  const sidebar = document.getElementById('admin-sidebar');
  btn?.addEventListener('click', ()=> {
    sidebar.classList.toggle('hidden');
  });
</script>
</body>
</html>

{{-- resources/views/partials/admin/sidebar.blade.php --}}
<aside id="admin-sidebar" class="w-64 bg-white border-r min-h-screen p-4 hidden md:block">
  <div class="mb-6 text-xl font-bold"><a href="{{ route('admin.dashboard') }}">MyMarketplace</a></div>
  <nav class="space-y-2">
    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-50 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 font-semibold' : '' }}">
      <i class='bx bx-home mr-2 align-middle'></i> Dashboard
    </a>
    <a href="#" class="block px-3 py-2 rounded hover:bg-gray-50"><i class='bx bx-box mr-2'></i> Products</a>
    <a href="#" class="block px-3 py-2 rounded hover:bg-gray-50"><i class='bx bx-receipt mr-2'></i> Orders</a>
    <a href="#" class="block px-3 py-2 rounded hover:bg-gray-50"><i class='bx bx-user mr-2'></i> Sellers</a>
    <a href="#" class="block px-3 py-2 rounded hover:bg-gray-50"><i class='bx bx-line-chart mr-2'></i> Analytics</a>
  </nav>
</aside>

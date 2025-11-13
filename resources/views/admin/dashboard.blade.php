{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title','Overview')

@section('content')
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white p-4 rounded shadow">
      <div class="text-sm text-gray-500">Total Orders</div>
      <div class="text-2xl font-bold">{{ $totalOrders ?? 0 }}</div>
    </div>
    <div class="bg-white p-4 rounded shadow">
      <div class="text-sm text-gray-500">Active Sellers</div>
      <div class="text-2xl font-bold">{{ $activeSellers ?? 0 }}</div>
    </div>
    <div class="bg-white p-4 rounded shadow">
      <div class="text-sm text-gray-500">Total Revenue</div>
      <div class="text-2xl font-bold">{{ $totalRevenue ?? 'Rp 0' }}</div>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div class="bg-white p-4 rounded shadow">
      <h3 class="font-semibold mb-3">Recent Orders</h3>
      <table class="w-full text-sm">
        <thead class="text-left text-gray-500">
          <tr><th>Order</th><th>Buyer</th><th>Total</th></tr>
        </thead>
        <tbody>
          <tr class="border-t"><td>#1023</td><td>Ani</td><td>Rp 150.000</td></tr>
          <tr class="border-t"><td>#1022</td><td>Budi</td><td>Rp 80.000</td></tr>
        </tbody>
      </table>
    </div>

    <div class="bg-white p-4 rounded shadow">
      <h3 class="font-semibold mb-3">Top Products</h3>
      <ul class="space-y-2">
        <li class="flex justify-between"><span>Product A</span><span class="text-gray-600">320 sold</span></li>
        <li class="flex justify-between"><span>Product B</span><span class="text-gray-600">210 sold</span></li>
      </ul>
    </div>
  </div>
@endsection

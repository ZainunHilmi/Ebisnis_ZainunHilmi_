{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
  {{-- Page Heading --}}
  <div class="d-sm-flex align-items-center justify-content-between mb-4 flex justify-between items-center">
    <h1 class="h3 mb-0 text-gray-800 text-2xl font-normal">Dashboard</h1>
    <a href="#"
      class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm bg-blue-600 text-white px-3 py-1 rounded-md text-sm hover:bg-blue-700 transition-colors flex items-center">
      <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
      </svg>
      Generate Report
      <div class="col mr-2 w-full">
        <div class="text-xs font-bold text-cyan-400 uppercase mb-1">Tasks
        </div>
        <div class="row no-gutters align-items-center flex items-center">
          <div class="col-auto">
            <div class="h5 mb-0 mr-3 font-bold text-gray-800 text-xl">50%</div>
          </div>
          <div class="col flex-1 ml-2">
            <div class="w-full bg-gray-200 rounded-full h-2">
              <div class="bg-cyan-400 h-2 rounded-full" style="width: 50%"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-auto ml-4">
        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
          </path>
        </svg>
      </div>
  </div>
  </div>
  </div>

  {{-- Pending Requests Card Example --}}
  <div class="card border-l-4 border-yellow-400 shadow h-100 py-2 bg-white rounded-md">
    <div class="card-body px-4">
      <div class="row no-gutters align-items-center flex justify-between items-center">
        <div class="col mr-2">
          <div class="text-xs font-bold text-yellow-400 uppercase mb-1">
            Pending Requests</div>
          <div class="h5 mb-0 font-bold text-gray-800 text-xl">18</div>
        </div>
        <div class="col-auto">
          <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
            </path>
          </svg>
        </div>
      </div>
    </div>
  </div>
  </div>

  {{-- Content Row --}}

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Area Chart --}}
    <div class="lg:col-span-2">
      <div class="card shadow mb-4 bg-white rounded-md overflow-hidden">
        {{-- Card Header - Dropdown --}}
        <div class="card-header py-3 px-4 flex flex-row items-center justify-between bg-gray-50 border-b border-gray-200">
          <h6 class="m-0 font-bold text-blue-600">Earnings Overview</h6>
          <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              <svg class="w-4 h-4 text-gray-400 hover:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z">
                </path>
              </svg>
            </a>
          </div>
        </div>
        {{-- Card Body --}}
        <div class="card-body p-4">
          <div
            class="chart-area relative h-80 w-full bg-gray-50 rounded flex items-center justify-center border border-dashed border-gray-300">
            <p class="text-gray-400 italic">Area Chart Placeholder</p>
            {{-- In a real app, you'd use Chart.js here --}}
          </div>
        </div>
      </div>
    </div>

    {{-- Pie Chart --}}
    <div class="lg:col-span-1">
      <div class="card shadow mb-4 bg-white rounded-md overflow-hidden">
        {{-- Card Header - Dropdown --}}
        <div class="card-header py-3 px-4 flex flex-row items-center justify-between bg-gray-50 border-b border-gray-200">
          <h6 class="m-0 font-bold text-blue-600">Revenue Sources</h6>
          <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              <svg class="w-4 h-4 text-gray-400 hover:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z">
                </path>
              </svg>
            </a>
          </div>
        </div>
        {{-- Card Body --}}
        <div class="card-body p-4">
          <div
            class="chart-pie relative h-64 w-full bg-gray-50 rounded flex items-center justify-center border border-dashed border-gray-300">
            <p class="text-gray-400 italic">Donut Chart Placeholder</p>
            {{-- In a real app, you'd use Chart.js here --}}
          </div>
          <div class="mt-4 text-center small text-xs text-gray-500">
            <span class="mr-2">
              <span class="inline-block w-3 h-3 rounded-full bg-blue-500 mr-1"></span> Direct
            </span>
            <span class="mr-2">
              <span class="inline-block w-3 h-3 rounded-full bg-green-500 mr-1"></span> Social
            </span>
            <span class="mr-2">
              <span class="inline-block w-3 h-3 rounded-full bg-cyan-400 mr-1"></span> Referral
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
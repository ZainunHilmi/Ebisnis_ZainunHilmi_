<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl">
                <div class="p-8 lg:p-12 bg-white border-b border-gray-100">

                    {{-- Order Header --}}
                    <div class="text-center mb-10">
                        <div
                            class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-6 animate-pulse">
                            <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Order Confirmed!</h2>
                        <p class="mt-2 text-gray-500 text-lg">Order ID: <span
                                class="font-mono font-bold text-gray-700">#{{ $order->id }}</span></p>
                    </div>

                    {{-- Amount Display --}}
                    <div
                        class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-8 mb-10 text-center border border-gray-200">
                        <p class="text-gray-500 mb-2 font-medium uppercase tracking-wider text-sm">Total Amount to Pay
                        </p>
                        <p class="text-5xl font-extrabold text-gray-900 tracking-tight">Rp
                            {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        <p
                            class="text-indigo-600 font-semibold mt-2 text-sm bg-indigo-50 inline-block px-3 py-1 rounded-full">
                            Secure Payment</p>
                    </div>

                    {{-- Payment Methods --}}
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                            </path>
                        </svg>
                        Select Payment Method
                    </h3>

                    <div class="space-y-4 mb-10">
                        {{-- Virtual Account --}}
                        <div
                            class="border rounded-xl p-5 hover:border-indigo-500 hover:shadow-md transition-all cursor-pointer group bg-white">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-xs">
                                        BCA</div>
                                    <div>
                                        <p class="font-bold text-gray-900">BCA Virtual Account</p>
                                        <p class="text-sm text-gray-500 group-hover:text-indigo-600 transition-colors">
                                            Automatic verification</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-mono font-bold text-lg text-gray-800">8801 2345 6789 000</p>
                                    <p class="text-xs text-gray-400">Copy Number</p>
                                </div>
                            </div>
                        </div>

                        {{-- QRIS --}}
                        <div
                            class="border rounded-xl p-5 hover:border-indigo-500 hover:shadow-md transition-all cursor-pointer group bg-white">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="w-12 h-12 bg-gray-900 rounded-lg flex items-center justify-center text-white font-bold text-xs">
                                        QRIS</div>
                                    <div>
                                        <p class="font-bold text-gray-900">QRIS (Gopay/OVO/Dana)</p>
                                        <p class="text-sm text-gray-500 group-hover:text-indigo-600 transition-colors">
                                            Scan to pay</p>
                                    </div>
                                </div>
                                <div>
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Button --}}
                    <div class="text-center">
                        <form action="{{ route('user.payment.process', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-bold rounded-xl shadow-lg text-white bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform hover:-translate-y-1 transition-all">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                I Have Completed Payment
                            </button>
                            <p class="mt-4 text-sm text-gray-500">
                                This is a simulation. Clicking the button will mark the order as <span
                                    class="font-bold text-green-600">PAID</span>.
                            </p>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-6 animate-fade-in">
            <div
                class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-900 shadow-xl shadow-slate-200/50 dark:shadow-black/20 flex items-center justify-center text-emerald-500 border border-slate-100 dark:border-slate-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <nav class="flex mb-1" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-2">
                        <li class="inline-flex items-center">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Order
                                Context</span>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span
                                    class="ml-1 text-[10px] font-black uppercase tracking-widest text-slate-500">Settlement
                                    Protocol</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white leading-tight tracking-tight">
                    Transaction <span class="text-gradient">Settlement</span>
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card p-8 lg:p-12 !rounded-[3rem] relative overflow-hidden">
                {{-- Decorative Background --}}
                <div class="absolute -top-32 -right-32 w-64 h-64 bg-primary-500/5 rounded-full blur-3xl"></div>

                {{-- Status Header --}}
                <div class="text-center mb-12 relative z-10">
                    <div
                        class="inline-flex items-center px-4 py-2 rounded-2xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-[10px] font-black uppercase tracking-widest mb-6 border border-emerald-500/20 shadow-glow-emerald">
                        Access Key Staged
                    </div>
                    <h2 class="text-4xl font-black text-slate-900 dark:text-white tracking-tighter mb-2">Order
                        Finalization</h2>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Transaction ID:
                        #{{ str_pad($order->id, 10, '0', STR_PAD_LEFT) }}</p>
                </div>

                {{-- Valuation Shield --}}
                <div
                    class="bg-slate-50 dark:bg-slate-900/50 rounded-[2.5rem] p-10 mb-12 text-center border-2 border-slate-100 dark:border-slate-800 relative group overflow-hidden">
                    <div
                        class="absolute inset-0 bg-gradient-to-tr from-primary-500/5 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                    </div>

                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4 relative z-10">
                        Mandatory Settlement Amount</p>
                    <div class="flex items-baseline justify-center space-x-2 relative z-10">
                        <span class="text-2xl font-bold text-slate-400 italic">Rp</span>
                        <h3 class="text-6xl font-black text-slate-900 dark:text-white tracking-tighter">
                            {{ number_format($order->total_amount, 0, ',', '.') }}
                        </h3>
                    </div>

                    <div class="mt-8 flex justify-center space-x-2 relative z-10">
                        @foreach(['Encrypted', 'Instant Verification', 'Official Receipt'] as $tag)
                            <span
                                class="px-3 py-1 rounded-lg bg-white dark:bg-slate-800 text-[8px] font-black text-slate-500 uppercase tracking-widest border border-slate-100 dark:border-slate-700 shadow-sm">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>

                {{-- Channel Selection --}}
                <div class="mb-12 relative z-10">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center">
                        <span
                            class="w-6 h-6 rounded-lg bg-primary-500/10 text-primary-500 flex items-center justify-center mr-3">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                </path>
                            </svg>
                        </span>
                        Payment Channel Routing
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Virtual Account --}}
                        <div
                            class="group p-6 rounded-2xl border-2 border-slate-100 dark:border-slate-800 hover:border-primary-500 transition-all duration-300 bg-white dark:bg-slate-900 shadow-sm hover:shadow-xl hover:shadow-primary-500/5 cursor-pointer">
                            <div class="flex items-start justify-between mb-4">
                                <div
                                    class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white text-[8px] font-black">
                                    BCA</div>
                                <span
                                    class="text-[8px] font-black text-emerald-500 uppercase tracking-widest">Active</span>
                            </div>
                            <h4
                                class="text-xs font-black text-slate-900 dark:text-white uppercase tracking-widest mb-1">
                                Virtual Account</h4>
                            <p class="text-[10px] font-mono font-bold text-slate-400 tracking-wider">8801 2345 6789 000
                            </p>
                        </div>

                        {{-- QRIS --}}
                        <div
                            class="group p-6 rounded-2xl border-2 border-slate-100 dark:border-slate-800 hover:border-primary-500 transition-all duration-300 bg-white dark:bg-slate-900 shadow-sm hover:shadow-xl hover:shadow-primary-500/5 cursor-pointer text-right">
                            <div class="flex items-start justify-between mb-4">
                                <span
                                    class="text-[8px] font-black text-emerald-500 uppercase tracking-widest">Active</span>
                                <div
                                    class="w-10 h-10 bg-slate-900 rounded-xl flex items-center justify-center text-white text-[8px] font-black">
                                    QRIS</div>
                            </div>
                            <h4
                                class="text-xs font-black text-slate-900 dark:text-white uppercase tracking-widest mb-1">
                                QRIS Unified</h4>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Gopay / OVO / Dana
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Action HUD --}}
                <div class="relative z-10">
                    <form action="{{ route('user.payment.process', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full btn-primary !py-5 shadow-primary-500/30 flex items-center justify-center text-base">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Confirm Settlement Protocol
                        </button>
                    </form>

                    <div
                        class="mt-8 p-6 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                        <div class="flex items-center justify-center space-x-2 text-slate-400 mb-2">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-[8px] font-black uppercase tracking-[0.2em]">Simulation Disclosure</p>
                        </div>
                        <p class="text-[10px] text-slate-500 font-medium text-center leading-relaxed">
                            This is a secure simulation environment. Confirming payment will immediately transition the
                            order status to <span class="text-emerald-500 font-bold">SETTLED (PAID)</span> within the
                            system registry.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
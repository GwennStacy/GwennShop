@extends('layouts.app')

@section('title', 'Order Success')

@section('content')
<style>
    .animate-details {
        animation: slideUp 0.6s ease-out forwards;
        animation-delay: 0.8s;
        transform: translateY(20px);
        opacity: 0;
    }
    @keyframes slideUp {
        0% { transform: translateY(20px); opacity: 0; }
        100% { transform: translateY(0); opacity: 1; }
    }

    /* ABA Style Animated Checkmark */
    .success-animation {
        margin: 40px auto;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .checkmark {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        display: block;
        stroke-width: 4;
        stroke: #fff;
        stroke-miterlimit: 10;
        box-shadow: inset 0px 0px 0px #00BFA5;
        animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
        background-color: #00BFA5; /* ABA Greenish Cyan */
    }
    .checkmark__circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 4;
        stroke-miterlimit: 10;
        stroke: #00BFA5;
        fill: none;
        animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }
    .checkmark__check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.6s forwards;
    }
    @keyframes stroke {
        100% { stroke-dashoffset: 0; }
    }
    @keyframes scale {
        0%, 100% { transform: none; }
        50% { transform: scale3d(1.1, 1.1, 1); }
    }
    @keyframes fill {
        100% { box-shadow: inset 0px 0px 0px 60px #00BFA5; }
    }
</style>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 min-h-[70vh] flex flex-col items-center justify-center">
    
    <!-- Big ABA Style Checkmark -->
    <div class="success-animation">
        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
            <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
        </svg>
    </div>

    <div class="text-center animate-details w-full">
        <h1 class="text-3xl font-serif text-gray-900 mb-2">Payment Successful!</h1>
        <p class="text-gray-500 mb-10">Thank you for your purchase. Your order has been confirmed.</p>

        <div class="bg-gray-50 border border-gray-100 rounded-xl p-8 max-w-lg mx-auto text-left shadow-sm">
            <h2 class="text-lg font-medium border-b pb-4 mb-4 uppercase tracking-wider text-gray-900">Order Details</h2>
            
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Order ID</span>
                    <span class="font-medium text-gray-900">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Transaction ID</span>
                    <span class="font-medium text-gray-900">{{ $order->transaction_id ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Date</span>
                    <span class="font-medium text-gray-900">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Payment Method</span>
                    <span class="font-medium text-gray-900">{{ $order->payment_method }}</span>
                </div>
                
                <div class="border-t pt-3 mt-3 flex justify-between items-center">
                    <span class="text-gray-900 font-medium text-base">Total Amount</span>
                    <span class="font-bold text-xl text-[#00BFA5]">${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="mt-10">
            <a href="{{ url('/') }}" class="inline-block bg-black text-white px-8 py-3 uppercase tracking-widest text-sm hover:bg-gray-800 transition-colors">
                Continue Shopping
            </a>
        </div>
    </div>
</div>

<!-- Confetti JS -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var duration = 2.5 * 1000;
            var end = Date.now() + duration;

            (function frame() {
                confetti({
                    particleCount: 5,
                    angle: 60,
                    spread: 55,
                    origin: { x: 0 },
                    colors: ['#00BFA5', '#111111', '#dddddd']
                });
                confetti({
                    particleCount: 5,
                    angle: 120,
                    spread: 55,
                    origin: { x: 1 },
                    colors: ['#00BFA5', '#111111', '#dddddd']
                });

                if (Date.now() < end) {
                    requestAnimationFrame(frame);
                }
            }());
        }, 500);
    });
</script>
@endsection

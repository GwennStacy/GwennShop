@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative">
    <div class="mb-8 border-b pb-4">
        <h1 class="text-3xl font-serif text-gray-900">Checkout</h1>
        <p class="text-gray-500 mt-2">Please fill in your details to complete the order.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-12">
        
        <div class="lg:w-2/3">
            <form id="checkout-form" action="{{ route('aba.checkout') }}" method="POST">
                @csrf
                <h2 class="text-xl font-medium text-gray-900 mb-6">Shipping Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                        <input type="text" name="first_name" required class="w-full border border-gray-300 rounded p-3 focus:outline-none focus:ring-2 focus:ring-black">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                        <input type="text" name="last_name" required class="w-full border border-gray-300 rounded p-3 focus:outline-none focus:ring-2 focus:ring-black">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <input type="tel" name="phone" required class="w-full border border-gray-300 rounded p-3 focus:outline-none focus:ring-2 focus:ring-black">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Address</label>
                    <textarea name="address" rows="3" required class="w-full border border-gray-300 rounded p-3 focus:outline-none focus:ring-2 focus:ring-black"></textarea>
                </div>
                
                <div class="mt-6 mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Payment Method</h3>
                    <div class="space-y-3 p-4 border border-gray-200 rounded bg-gray-50">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="payment_method" value="COD" checked class="w-5 h-5 text-black border-gray-300 focus:ring-black">
                            <span class="ml-3 text-gray-800 font-medium">Cash on Delivery (បង់ប្រាក់ពេលទទួលឥវ៉ាន់)</span>
                        </label>
                        <div class="border-t border-gray-200 my-2"></div>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="payment_method" value="Bank Transfer" class="w-5 h-5 text-black border-gray-300 focus:ring-black">
                            <span class="ml-3 text-gray-800 font-medium">Bank Transfer (ស្កេន KHQR)</span>
                        </label>
                    </div>
                </div>
                
                <button type="submit" id="main-submit-btn" class="w-full bg-black text-white text-center py-4 text-sm uppercase tracking-widest font-semibold hover:bg-gray-800 transition-colors mt-4 shadow-lg">
                    Place Order Now
                </button>
            </form>
        </div>

        <div class="lg:w-1/3">
            <div class="bg-white p-8 rounded border border-gray-200 shadow-sm sticky top-10">
                <h2 class="text-lg font-medium text-gray-900 mb-6 uppercase tracking-wider">Your Order</h2>
                
                <div class="divide-y divide-gray-100">
                    @php $total = 0; @endphp
                    @if(session('cart'))
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity']; @endphp
                            <div class="py-4 flex justify-between items-center text-sm">
                                <div class="flex-1 pr-4">
                                    <span class="font-medium text-gray-900">{{ $details['name'] }}</span>
                                    <span class="text-gray-500"> x {{ $details['quantity'] }}</span>
                                </div>
                                <span class="text-gray-900 font-medium">${{ number_format($details['price'] * $details['quantity'], 2) }}</span>
                            </div>
                        @endforeach
                    @endif
                </div>
                
                <div class="border-t border-gray-200 pt-4 mt-2">
                    <div class="flex justify-between mb-2 text-sm text-gray-600">
                        <span>Subtotal</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between mb-4 text-sm text-gray-600">
                        <span>Shipping</span>
                        <span class="text-green-600 font-medium">Free</span>
                    </div>
                    <div class="border-t border-gray-200 pt-4 flex justify-between items-center">
                        <span class="text-lg font-bold text-gray-900">Total</span>
                        <span class="text-xl font-bold text-black" id="total-amount">${{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div id="bakong-qr-modal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-80 flex items-center justify-center backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full text-center border-t-4 border-red-600 p-8 transform transition-all scale-95 opacity-0" id="qr-modal-content">
        
        <div class="flex justify-center items-center gap-2 mb-2">
            <h2 class="text-3xl font-black text-red-600 tracking-wider">KHQR</h2>
        </div>
        
        <p class="text-gray-500 mb-2 text-sm font-medium">Scan with any Bank App</p>
        
        <div class="mb-4 text-red-600 font-bold text-lg" id="countdown-timer">03:00</div>

        <div class="flex justify-center mb-6 relative">
            <div class="p-2 border-2 border-dashed border-red-600 rounded-xl shadow-sm bg-white relative" id="qr-container">
                <svg class="animate-spin h-8 w-8 text-red-600 mx-auto my-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            </div>
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none hidden" id="khqr-logo">
                <div class="bg-black text-white w-10 h-10 rounded-full flex items-center justify-center font-bold text-xl border-4 border-white shadow-sm">៛</div>
            </div>
        </div>

        <p class="text-sm text-gray-500 uppercase tracking-widest font-semibold mb-1">Total Payment</p>
        <p class="text-4xl font-bold text-red-600 mb-6" id="qr-amount">$0.00</p>

    </div>
</div>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://khqr.cc/khqrcc-plugin.js"></script>

<script>
    $('#checkout-form').on('submit', function(e) {
        e.preventDefault();
        let formActionUrl = $(this).attr('action'); 
        let method = $('input[name="payment_method"]:checked').val();
        let btn = $('#main-submit-btn');
        let originalText = btn.text();
        
        btn.text('PROCESSING...').prop('disabled', true);

        if (method === 'Bank Transfer') {
            $.ajax({
                url: formActionUrl, 
                method: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.success && response.checkout_url) {
                        // បើកផ្ទាំង ABA Payway រក្សាសិទ្ធិពី KHQRcc តែម្តង
                        let checkInterval; // ប្រកាសអថេរសម្រាប់ទុក Polling

                        KhqrPayway.openCheckout({
                            checkout_url: response.checkout_url,
                            onSuccess: function(res) {
                                // ពេល Plugin ដំណើរការ onSuccess បានត្រឹមត្រូវ
                                clearInterval(checkInterval); // ឈប់ Polling
                                window.location.href = '/aba/verify?transaction_id=' + (res.transaction_id || ''); // ឬឆែកកូដ Verification បន្ត
                            },
                            onError: function(err) {
                                // ពេលអតិថិជនចុចខ្វែង (X) ឬមានបញ្ហា
                                clearInterval(checkInterval); // ឈប់ Polling
                                btn.text(originalText).prop('disabled', false); // បើកប៊ូតុងអោយចុចបានវិញ
                                Swal.fire('Cancelled', 'ការបង់ប្រាក់ត្រូវបានបោះបង់!', 'info');
                            }
                        });

                        // ដោយសារ Plugin ពេលខ្លះមិនបិទខ្លួនឯង ពួកយើងត្រូវឆែកមើលរៀងរាល់ ៣ វិនាទី (Polling Fallback)
                        let txId = response.checkout_url.match(/transaction_id=([^&]+)/);
                        if (txId && txId[1]) {
                            checkInterval = setInterval(function() {
                                $.ajax({
                                    url: '/aba/verify',
                                    method: 'POST',
                                    data: {
                                        _token: $('input[name="_token"]').val(),
                                        transaction_id: txId[1]
                                    },
                                    success: function(verifyRes) {
                                        if (verifyRes.success) {
                                            clearInterval(checkInterval); // ឈប់ឆែក
                                            
                                            // បិទផ្ទាំង KhqrPayway ដោយកូដ
                                            if (typeof KhqrPayway !== 'undefined') {
                                                KhqrPayway.closeCheckoutByContinueUrl();
                                            }
                                            
                                            // លោតទៅទំព័រវិក្កយបត្រ
                                            if (verifyRes.order_id) {
                                                window.location.href = '/order-success/' + verifyRes.order_id;
                                            } else {
                                                window.location.href = '/';
                                            }
                                        }
                                    }
                                });
                            }, 3000); // ឆែករាល់ 3 វិនាទី
                        }
                    } else {
                        Swal.fire('Error', response.message || 'Payment Failed', 'error');
                        btn.text(originalText).prop('disabled', false); 
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    Swal.fire('Error', 'ប្រព័ន្ធទូទាត់មានបញ្ហា!', 'error');
                    btn.text(originalText).prop('disabled', false); 
                }
            });
        } else {
            // (កូដ COD សរសេរធម្មតាទុកដដែល)
            $.ajax({
                url: '/checkout',
                method: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.success) {
                        Swal.fire({
                            title: 'Order Successful!',
                            text: 'Thank you for your order.',
                            icon: 'success',
                            confirmButtonColor: '#000',
                        }).then(() => window.location.href = '/');
                    }
                }
            });
        }
    });
</script>
@endsection
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function index()
    {
        return view('cart.index');
    }

    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }

    public function checkout()
    {
        if (!session('cart') || count(session('cart')) == 0) {
            return redirect('/cart')->with('error', 'Your cart is empty!');
        }
        return view('cart.checkout');
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'phone'      => 'required|string',
            'address'    => 'required|string',
            'payment_method' => 'required|string', 
            'payment_receipt' => 'nullable|image|max:2048' 
        ]);

        $receiptPath = null;
        if ($request->hasFile('payment_receipt')) {
            $receiptPath = $request->file('payment_receipt')->store('receipts', 'public');
        }

        $total = 0;
        if(session('cart')) {
            foreach(session('cart') as $id => $details) {
                $total += $details['price'] * $details['quantity'];
            }
        } 

        $order = new \App\Models\Order();
        $order->first_name = $request->first_name;
        $order->last_name = $request->last_name;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->total_amount = $total;
        $order->status = 'Pending';
        $order->payment_method = $request->payment_method; 
        $order->payment_receipt = $receiptPath; 
        $order->save();

        session()->forget('cart');

        try {
            $telegramToken = "8779090043:AAHS-DUFAWBxhtCYoxYV5R1w_4SOsRi384I"; 
            $chatId = "1273987367";

            $message = "🎉 មានការកម្ម៉ង់ថ្មី (New Order)!\n";
            $message .= "-----------------------------------\n";
            $message .= "📦 លេខកូដ: #ORD-00" . $order->id . "\n";
            $message .= "👤 ឈ្មោះ: " . $order->first_name . " " . $order->last_name . "\n";
            $message .= "📞 ទូរស័ព្ទ: " . $order->phone . "\n";
            $message .= "💰 សរុប: $" . number_format($order->total_amount, 2) . "\n";
            $message .= "💳 បង់តាម: " . $order->payment_method . "\n"; 
            $message .= "-----------------------------------\n";
            $message .= "សូមចូលទៅកាន់ Admin Dashboard ដើម្បីមើលលម្អិត។";

            $url = "https://api.telegram.org/bot" . $telegramToken . "/sendMessage";
            \Illuminate\Support\Facades\Http::withoutVerifying()->post($url, [
                'chat_id' => $chatId,
                'text' => $message,
            ]);
        } catch (\Exception $e) {
            Log::error('Telegram Error: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully!'
        ]);
    }

     public function payWithAbaPayway(Request $request)
    {
        try {
            $total = 0;
            if (session('cart')) {
                foreach (session('cart') as $details) {
                    $total += $details['price'] * $details['quantity'];
                }
            }
            
            // Remove the 1 dollar limit so user can test with 0.01
            $amount = number_format((float)$total, 2, '.', '');

            $token = env('KHQRPAY_API_TOKEN');
            $apiUrl = env('KHQRPAY_API_URL', 'https://api.khqr.cc/v1/generate');
            
            $firstName  = $request->first_name ?? 'Guest';
            $lastName   = $request->last_name ?? 'User';
            $phone      = $request->phone ?? '012345678';
            $email      = 'skimheng47@gmail.com'; 

            // 🚀 បង្កើត URL សម្រាប់ទូទាត់ប្រាក់តាមរយៈ KHQRcc (Checkout Plugin)
            $transaction_id = 'ORD_' . time() . rand(100, 999);
            $success_url = ''; // Let JS handle the redirect
            $remark = 'Lumiere Store Order';
            $amountStr = number_format((float)$total, 2, '.', ''); // format to 0.00

            $secret_key = env('KHQRPAY_API_SECRET', 'YOUR_SECRET_HERE');
            $profile_id = '5naBW0cACcdMewjeavsGmbvR9Fvv0PAz'; // Profile ID from screenshot
            $gateway_url = 'https://khqr.cc/api/payment/requestv2';

            $payment_data = [
                "transaction_id" => $transaction_id,
                "amount"         => $amountStr,
                "success_url"    => $success_url,
                "remark"         => $remark
            ];

            // គណនា Security Hash (sha1)
            $payment_data['hash'] = sha1(
                $secret_key
                . $payment_data['transaction_id']
                . $payment_data['amount']
                . $payment_data['success_url']
                . $payment_data['remark']
            );

            // Generate Checkout URL
            $checkout_url = $gateway_url . "/" . $profile_id . "?" . http_build_query($payment_data);

            // Save Order ចូល Database
            $order = new \App\Models\Order();
            $order->first_name = $firstName;
            $order->last_name = $lastName;
            $order->phone = $phone;
            $order->address = $request->address ?? 'Phnom Penh';
            $order->total_amount = $total;
            $order->payment_method = 'ABA / KHQRPay';
            $order->status = 'Pending';
            $order->transaction_id = $transaction_id;
            $order->save();

            session()->forget('cart');

            // បោះ Checkout URL ត្រឡប់ទៅ Frontend វិញ
            return response()->json([
                'success'      => true,
                'checkout_url' => $checkout_url
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Exception: ' . $e->getMessage()]);
        }
    }

    public function verifyPayment(Request $request)
    {
        try {
            $txId = $request->input('transaction_id');
            if (!$txId) {
                return response()->json(['success' => false, 'message' => 'No transaction ID']);
            }

            $profile_id = '5naBW0cACcdMewjeavsGmbvR9Fvv0PAz';
            $verify_url = "https://khqr.cc/api/{$profile_id}/payment-gateway/v1/payments/check-trans";
            
            // Security Hash using profile_key (which is the same as profile_id for this API)
            $hash = sha1($profile_id . $txId);

            $postData = [
                'transaction_id' => $txId,
                'hash' => $hash
            ];

            $response = \Illuminate\Support\Facades\Http::asForm()->post($verify_url, $postData);
            $result = $response->json();
            
            \Illuminate\Support\Facades\Log::info('KHQR Verify Response:', ['url' => $verify_url, 'data' => $postData, 'result' => $result]);

            // ✅ Real success condition
            $isPaid = (
                isset($result['responseCode']) &&
                (int)$result['responseCode'] === 0 &&
                isset($result['data']['status']) &&
                strtolower($result['data']['status']) === 'success'
            );

            if ($isPaid) {
                // Update Order Status in Database
                $order = \App\Models\Order::where('transaction_id', $txId)->first();
                if ($order && $order->status == 'Pending') {
                    $order->status = 'Completed';
                    $order->save();
                }

                return response()->json([
                    'success' => true, 
                    'message' => 'Payment confirmed', 
                    'amount'  => $result['data']['amount'] ?? 0,
                    'order_id'=> $order ? $order->id : null
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Payment not verified', 'data' => $result]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Exception: ' . $e->getMessage()]);
        }
    }

    public function orderSuccess($id)
    {
        $order = \App\Models\Order::findOrFail($id);
        return view('cart.success', compact('order'));
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_date' => now(),
                'total_price' => 0,
            ]);

            $totalPrice = 0;

            foreach ($request->products as $productData) {
                $product = Product::findOrFail($productData['product_id']);

                if ($product->stock < $productData['quantity']) {
                    throw new \Exception("Insufficient stock for product: {$product->name}");
                }

                $product->stock -= $productData['quantity'];
                $product->save();

                $orderDetail = new OrderDetail([
                    'product_id' => $product->id,
                    'quantity' => $productData['quantity'],
                ]);

                $order->orderDetails()->save($orderDetail);

                $totalPrice += $product->price * $productData['quantity'];
            }

            $order->total_price = $totalPrice;
            $order->save();
        });

        return response()->json(['message' => 'Order created successfully'], 201);
    }

    public function requestBind(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $user = $request->user();

        $bankApiUrl = 'http://172.21.155.41:9011/api';
        $responseBind = Http::withHeaders([
            'Accept' => 'application/json',
        ])->post($bankApiUrl . '/user/bind-account', [
                    'email' => $request->email,
                    'password' => $request->password,
                    'ecommerce_user_id' => $user->id,
                ]);

        $responseBindData = $responseBind->json();
        if ($responseBind->failed()) {
            return response()->json(['message' => 'Failed to bind account ' . $responseBindData['message']], 500);
        }

        $bankToken = $responseBindData['token'];
        $responseUserBank = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $bankToken,
        ])->get($bankApiUrl . '/user/account');
        $responseUserBankData = $responseUserBank->json();
        if ($responseUserBank->failed()) {
            return response()->json(['message' => 'Failed to get user bank data ' . $responseUserBankData['message']], 500);
        }
        $mergedData = array_merge($responseBindData, $responseUserBankData);

        return response()->json($mergedData);
    }

    public function requestPayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::findOrFail($request->order_id);
        $bankApiUrl = 'http://172.21.155.41:9011/api';
        $bankToken = $request->header('BankToken');
        if (!$bankToken) {
            return response()->json(['message' => 'Unauthorized, Bank Token is required'], 401);
        }
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $bankToken,
        ])->post($bankApiUrl . '/user/payment', [
                    'amount' => $order->total_price,
                ]);
        $responseData = $response->json();
        if ($response->failed()) {
            return response()->json(['message' => 'Failed to make payment ' . $responseData['message']], 500);
        }

        return response()->json(['message' => $responseData['message']]);

    }

}

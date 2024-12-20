<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\OrderConfirmation;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PaypalController;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Requests\StoreCheckout1Request;

class CheckoutController extends Controller
{
    public function checkout1(){
        $user = Auth::user();
        return view('frontend.pages.checkout.checkout1',compact('user'));
    }

    public function checkout1Store(StoreCheckout1Request $request){
        $data = $request->validated();
        Session::put('checkout',$data);
        $shippings = Shipping::where('status','active')->orderBy('shipping_method','ASC')->get();
        return view('frontend.pages.checkout.checkout2',compact('shippings'));
    }

    public function checkout2(){
        $user = Auth::user();
        return view('frontend.pages.checkout.checkout2',compact('user'));
    }

    public function checkout2Store(Request $request){
        $request->validate([
            'delivery_charge' => 'nullable|numeric'
        ]);
    
        Session::push('checkout',[
            'delivery_charge'=>$request->delivery_charge
        ]);
        return view('frontend.pages.checkout.checkout3');
    }

    public function checkout3(){
        $user = Auth::user();
        return view('frontend.pages.checkout.checkout3',compact('user'));
    }

    public function checkout3Store(Request $request){
        $request->validate([
            'payment_method' => 'required|string',
            'payment_status' => 'string|in:paid,unpaid'
        ]);
        Session::push('checkout',[
            'payment_method'=>$request->payment_method,
            'payment_status'=>'paid'
        ]);
        return view('frontend.pages.checkout.checkout4');
    }

    public function checkoutStore(){

        // return Session::get('checkout');

        $checkout = Session::get('checkout');

        $coupon = Session::get('coupon')[0] ?? 0;

        $user_id = Auth::user()->id;

        // order related data
        $order_data = [
            'user_id' => $user_id,
            'order_number' => Str::upper('ord-'.Str::random(6)),
            'coupon' => $coupon,
            'payment_method' => $checkout[4]['payment_method'],
            'payment_status' => $checkout[4]['payment_status'],
            'condition' => 'pending',
            'delivery_charge' => $checkout[0]['delivery_charge'],
            'subtotal' => $checkout['subtotal'],
            'total' => $checkout['subtotal']-$coupon+$checkout[0]['delivery_charge'],
            'notes' => $checkout['notes'],
        ];

        // user related data
        $user_data = [
            'email' => $checkout['email'],
            'phone' => $checkout['phone'],
            'country' => $checkout['country'],
            'state' => $checkout['state'],
            'city' => $checkout['city'],
            'postcode' => $checkout['postcode'],
            'address' => $checkout['address'],
            'shipping_country' => $checkout['shipping_country'],
            'shipping_state' => $checkout['shipping_state'],
            'shipping_city' => $checkout['shipping_city'],
            'shipping_postcode' => $checkout['shipping_postcode'],
            'shipping_address' => $checkout['shipping_address']
        ];
        
        $user = User::where('id',$user_id)->update($user_data);

        $order = Order::create($order_data);

        if($order){
            session()->put('order_id',$order->id);
        }

        if($order['payment_method'] == 'paypal'){
            $paypal = new PaypalController;
            return $paypal->getCheckout();
        }

        Mail::to(Auth::user()->email)->cc('ahmadmaher@eshop.io')->send(new OrderConfirmation($order));

        foreach(Cart::instance('shopping')->content() as $item){
            $product = Product::find($item->id);
            OrderItem::create(['order_id'=>$order->id,'product_id'=>$product->id,'price'=>$product->offer_price,'quantity'=>$item->qty]);
        }

        if($order['payment_method'] == 'paypal'){
            $paypal = new PaypalController;
            return $paypal->getCheckout();
        }

        if($order){
            // Remove Coupon
            Session::forget('coupon');
            // Clear checkout info
            Session::forget('checkout');
            // Clear the cart
            Cart::instance('shopping')->destroy();

            $order_id = $order_data['order_number'];
            return redirect()->route('user.checkout.complete',$order_id);
        }
        else{
            return redirect()->route('user.checkout1')->with('error','Please try again');
        }
        
    }

    public function checkout_done($order_id,$payment_details){
        $order = Order::findOrFail($order_id);
        $order->payment_status = 'paid';
        $order->payment_details = $payment_details;
        $order->save();
        Mail::to(Auth::user()->email)->cc('ahmadmaher@eshop.io')->send(new OrderConfirmation($order));
        foreach(Cart::instance('shopping')->content() as $item){
            $product = Product::find($item->id);
            OrderItem::create(['order_id'=>$order->id,'product_id'=>$product->id,'price'=>$product->offer_price,'quantity'=>$item->qty]);
        }

        if($order){
            Session::forget('coupon');
            Session::forget('checkout');
            Cart::instance('shopping')->destroy();

            $order_id = $order->order_number;
            return redirect()->route('user.checkout.complete',$order_id);
        }
    }

    public function complete($order_id){
        return view('frontend.pages.checkout.complete',compact('order_id'));
    }
}

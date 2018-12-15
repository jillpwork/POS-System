<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Order;
use App\OrderItem;
use App\OrderImage;
use App\Mesurment;
use App\Http\Resources\Order as OrderResource;
use App\Http\Resources\OrderView as OrderViewResource;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();
        if ($request->has('filter')) {
            $filters = explode(',', $request->input('filter'));
            foreach ($filters as $filter) {
                if ($filter) {
                    list($criteria, $value) = explode(':', $filter);
                    if ($criteria == 'paid_status') {
                        if ($value == 'true') {
                            $value = 1;
                        } else if ($value == 'false') {
                            $value = 0;
                        }
                    }
                    $query->where($criteria, $value);
                }
            }
        }
        if ($request->has('from_date') && $request->has('to_date')) {
            $fromDate = $request->input('from_date');
            $toDate = $request->input('to_date');
            $query->whereBetween('order_date', [$fromDate, $toDate]);
        }
        // $sorts = explode(',', $request->input('sort', ''));
        // foreach ($sorts as $sortcol) {
        //     $sortDir = starts_with($sortcol, '-') ? 'desc' : 'asc';
        //     $sortcol = ltrim($sortcol, '-');
        // }
        $query->orderBy('created_at', 'desc');
        return OrderResource::collection($query->paginate(10));
    }

    public function store(Request $request)
    {
        $last_order = Order::orderBy('created_at', 'desc')->first();
        $new_order_id = sprintf("%'09d", $last_order['order_number'] + 1);
        $order = new Order;
        $order->id = $request->input('id');
        if ($request->input('order_number')) {
            $order->order_number = $request->input('order_number');
        } else {
            $order->order_number = $new_order_id;
        }
        $order->customer_id = $request->input('customer_id');
        if ($request->input('discount')) {
            $order->discount = $request->input('discount');
        }
        if ($request->input('sgst')) {
            $order->sgst = $request->input('sgst');
        }
        if ($request->input('cgst')) {
            $order->cgst = $request->input('cgst');
        }
        if ($request->input('igst')) {
            $order->igst = $request->input('igst');
        }
        if ($request->input('other_charges')) {
            $order->other_charges = $request->input('other_charges');
        }
        if ($request->input('total_amount')) {
            $order->total_amount = $request->input('total_amount');
        }
        if ($request->input('paid_amount')) {
            $order->paid_amount = $request->input('paid_amount');
        }
        $order->extra_notes = $request->input('extra_notes');
        $order->order_date = $request->input('order_date');
        $order->order_delivery_date = $request->input('order_delivery_date');
        $order->save();

        foreach ($request->order_items as $each_item) {
            if (array_key_exists('id', $each_item)) {
                $order_item = OrderItem::firstOrCreate(array('id' =>$each_item['id']));
            } else {
                $order_item = new OrderItem;
            }
            $order_item->order_id = $order->id;
            $order_item->item_name = $each_item['item_name'];
            if (array_key_exists('extra_notes', $each_item)) {
                $order_item->extra_notes = $each_item['extra_notes'];
            }
            $order_item->quantity = $each_item['quantity'];
            if ($request->input('price')) {
                $order_item->price = $each_item['price'];
            }
            if ($request->input('total')) {
                $order_item->total = $each_item['total'];
            }
            $order_item->save();
        };

        foreach ($request->images as $each_img) {
            $exploded = explode(';base64,', $each_img);
            $decoded = base64_decode($exploded[1]);
            $extention = explode('/', $exploded[0])[1];
            $filename = mt_rand(100000, 999999) . time() . '.' .$extention;
            $path = public_path().'/site_images/'.$filename;
            file_put_contents($path, $decoded);
            $order_image = new OrderImage;
            $order_image->order_id = $order->id;
            $order_image->image_path = '/site_images/'.$filename;
            $order_image->save();
        }

        return new OrderViewResource($order);
    }

    public function show($id)
    {
        // Get Order
        $order = Order::findOrFail($id);

        // Return Order as Resource
        return new OrderViewResource($order);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->order_number = $request->input('order_number');
        $order->customer_id = $request->input('customer_id');
        $order->discount = $request->input('discount');
        $order->sgst = $request->input('sgst');
        $order->cgst = $request->input('cgst');
        $order->igst = $request->input('igst');
        $order->other_charges = $request->input('other_charges');
        $order->total_amount = $request->input('total_amount');
        $order->paid_amount = $request->input('paid_amount');
        if ($request->input('paid_amount') != 0 && $request->input('paid_amount') == $request->input('total_amount')) {
            $order->paid_status = 1;
        } else {
            $order->paid_status = 0;
        }
        $order->extra_notes = $request->input('extra_notes');
        $order->order_date = $request->input('order_date');
        $order->order_delivery_date = $request->input('order_delivery_date');
        $order->save();
        foreach ($request->order_items as $each_item) {
            if (array_key_exists('id', $each_item)) {
                $order_item = OrderItem::firstOrCreate(array('id' =>$each_item['id']));
            } else {
                $order_item = new OrderItem;
            }
            $order_item->order_id = $order->id;
            $order_item->item_name = $each_item['item_name'];
            if (array_key_exists('extra_notes', $each_item)) {
                $order_item->extra_notes = $each_item['extra_notes'];
            }
            $order_item->quantity = $each_item['quantity'];
            // return $request->input();
            // if ($request->input('price')) {
            if (array_key_exists('price', $each_item)) {
                $order_item->price = $each_item['price'];
            }
            // if ($request->input('total')) {
            if (array_key_exists('total', $each_item)) {
                $order_item->total = $each_item['total'];
            }
            $order_item->save();
        };

        foreach ($request->images as $each_img) {
            $exploded = explode(';base64,', $each_img);
            $decoded = base64_decode($exploded[1]);
            $extention = explode('/', $exploded[0])[1];
            $filename = mt_rand(100000, 999999) . time() . '.' .$extention;
            $path = public_path().'/site_images/'.$filename;
            file_put_contents($path, $decoded);
            $order_image = new OrderImage;
            $order_image->order_id = $order->id;
            $order_image->image_path = '/site_images/'.$filename;
            $order_image->save();
        }

        return new OrderViewResource($order);
    }

    public function destroy($id)
    {
        //
    }

    public function deleteOrderImage($id)
    {
        // get OrderImage
        $order_image = OrderImage::findOrFail($id);
        $path = public_path().$order_image->image_path;
        if (is_file($path)) {
            unlink($path);
        }
        // delete Item
        $order_image->delete();
        return 'deleteit';
    }
}

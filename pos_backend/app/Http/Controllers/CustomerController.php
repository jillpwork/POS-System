<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Customer;
use App\Mesurment;
use App\User;
use Image; 
use App\Http\Resources\Customer as CustomerResource;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();
        if ($request->has('filter')) {
            if ($request->input('filter')) {
                $filters = explode(',', $request->input('filter'));
                foreach ($filters as $filter) {
                    list($criteria, $value) = explode(':', $filter);
                    if ($criteria == 'mobile') {
                        $query->where($criteria, 'like', '%'.$value.'%')
                        ->orWhere('phone_number', 'like', '%'.$value.'%');
                    } else {
                        $query->where($criteria, 'like', '%'.$value.'%');
                    }
                }
            }
            // list($criteria, $value) = explode(':', $request->input('filter'));
            // $customer_query->where($criteria, 'like', '%'.$value.'%');
        }
        $query->orderBy('created_at', 'desc');
        return CustomerResource::collection($query->paginate(5));
    }

    public function store(Request $request)
    {   
        // DB::transaction(function ($request) {
            $customer = $request->isMethod('put') ? Customer::findOrFail
            ($request->id) : new Customer;
            $customer->id = $request->input('id');
            $customer->fullname = $request->input('fullname');
            $customer->gender = $request->input('gender');
            $customer->email = $request->input('email');
            $customer->phone_number = $request->input('phone_number');
            $customer->mobile = $request->input('mobile');
            $customer->address_street = $request->input('address_street');
            $customer->city = $request->input('city');
            $customer->country = $request->input('country');
            $customer->postalcode = $request->input('postalcode');
            // $customer->date_of_birth = $request->input('date_of_birth');
            $customer->date_of_birth = date('Y/m/d', strtotime($request->input('date_of_birth')));
            $customer->save();

            if ($request->mesurment) {
                if (array_key_exists('id', $request->mesurment)) {
                    $mesurment = Mesurment::firstOrCreate(array('id' => $request->mesurment['id']));
                } else {
                    $mesurment = new Mesurment;
                };
                $mesurment->customer_id = $customer->id;
                $mesurment->chest = $request->mesurment['chest'];
                $mesurment->bust = $request->mesurment['bust'];
                $mesurment->rib_cage = $request->mesurment['rib_cage'];
                $mesurment->inseam = $request->mesurment['inseam'];
                $mesurment->biceps = $request->mesurment['biceps'];
                $mesurment->waist = $request->mesurment['waist'];
                $mesurment->hip = $request->mesurment['hip'];
                $mesurment->neck_to_floor = $request->mesurment['neck_to_floor'];
                $mesurment->shoulder_to_elbow = $request->mesurment['shoulder_to_elbow'];
                $mesurment->shoulder_to_wrist = $request->mesurment['shoulder_to_wrist'];
                $mesurment->waist_to_knee = $request->mesurment['waist_to_knee'];
                $mesurment->waist_to_floor = $request->mesurment['waist_to_floor'];
                $mesurment->armpit_to_waist = $request->mesurment['armpit_to_waist'];
                $mesurment->backneck_to_waist = $request->mesurment['backneck_to_waist'];
                $mesurment->save();
            }
            return new CustomerResource($customer);
        // });
    }

    public function show($id)
    {
        // Get Customer
        $customer = Customer::findOrFail($id);

        // Return Customer as Resource
        return new CustomerResource($customer);
    }

    public function update(Request $request, $id)
    {
        // DB::transaction(function () {
            $customer = Customer::findOrFail($id);
            $customer->fullname = $request->input('fullname');
            $customer->gender = $request->input('gender');
            $customer->email = $request->input('email');
            $customer->phone_number = $request->input('phone_number');
            $customer->mobile = $request->input('mobile');
            $customer->address_street = $request->input('address_street');
            $customer->city = $request->input('city');
            $customer->country = $request->input('country');
            $customer->postalcode = $request->input('postalcode');
            // $customer->date_of_birth = $request->input('date_of_birth');
            $customer->date_of_birth = date('Y-m-d', strtotime($request->input('date_of_birth')));
            $customer->save();

            if (array_key_exists('id', $request->mesurment)) {
                $mesurment = Mesurment::firstOrCreate(array('id' => $request->mesurment['id']));
            } else {
                $mesurment = new Mesurment;
            }
            $mesurment->customer_id = $customer->id;
            $mesurment->chest = $request->mesurment['chest'];
            $mesurment->bust = $request->mesurment['bust'];
            $mesurment->rib_cage = $request->mesurment['rib_cage'];
            $mesurment->inseam = $request->mesurment['inseam'];
            $mesurment->biceps = $request->mesurment['biceps'];
            $mesurment->waist = $request->mesurment['waist'];
            $mesurment->hip = $request->mesurment['hip'];
            $mesurment->neck_to_floor = $request->mesurment['neck_to_floor'];
            $mesurment->shoulder_to_elbow = $request->mesurment['shoulder_to_elbow'];
            $mesurment->shoulder_to_wrist = $request->mesurment['shoulder_to_wrist'];
            $mesurment->waist_to_knee = $request->mesurment['waist_to_knee'];
            $mesurment->waist_to_floor = $request->mesurment['waist_to_floor'];
            $mesurment->armpit_to_waist = $request->mesurment['armpit_to_waist'];
            $mesurment->backneck_to_waist = $request->mesurment['backneck_to_waist'];
            $mesurment->save();
            return new CustomerResource($customer);
        // });
    }

    public function destroy($id)
    {
        //
    }

    public function uploadSingleImage(Request $request)
    {
        // \Log::info($request->all());
        $exploded = explode(';base64,', $request->image);
        $decoded = base64_decode($exploded[1]);
        $extention = explode('/', $exploded[0])[1];
        $filename = time() . '.' .$extention;
        $path = public_path().'/site_images/'.$filename;
        file_put_contents($path, $decoded);
        return 'File Uploaded';
    }

    public function uploadImage(Request $request)
    {
        // return count($request->image);
        foreach ($request->image as $each_img) {
            $exploded = explode(';base64,', $each_img);
            $decoded = base64_decode($exploded[1]);
            $extention = explode('/', $exploded[0])[1];
            $filename = time() . '.' .$extention;
            // mt_rand(100000, 999999) . 
            $path = public_path().'/site_images/'.$filename;
            return '/site_images/'.$filename;
            file_put_contents($path, $decoded);
        }
        return 'File Uploaded';
    }

    public function image($fileName){
        $path = public_path().'/site_images/'.$fileName;
        return response()->download($path);
    }

    public function deleteImage($fileName){
        $path = public_path().'/site_images/'.$fileName;
        unlink($path);
        return $path;
    }
}

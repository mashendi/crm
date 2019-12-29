<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Customer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use \App\Http\Resources\Customer as CustomerResource;

class CustomerController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();
        return $this->sendResponse(CustomerResource::collection($customers), 'customers retrieved successfully');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => 'required|email',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $customer = Customer::create($input);
        return $this->sendResponse(new CustomerResource($customer), 'Customer created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::find($id);
        if (is_null($customer)) {
            return $this->sendError('Customer not found.');
        }

        return $this->sendResponse(new CustomerResource($customer), 'Customer data retrieved successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Customer $customer
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => 'required|email',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $customer->name = $input['name'];
        $customer->phone = $input['phone'];
        $customer->address = $input['address'];
        $customer->email = $input['email'];
        $customer->type = $input['type'];
        $customer->save();

        return $this->sendResponse(new CustomerResource($customer), 'Customer data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Customer $customer
     * @return Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return $this->sendResponse([], 'Customer data deleted successfully');
    }
}

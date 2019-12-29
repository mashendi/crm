<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ActionRequest;
use App\Http\Resources\Customer as CustomerResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActionController extends BaseController
{

    /**
     * add action to a customer
     *
     * @param ActionRequest $request
     * @param $id
     * @return Illuminate\Http\Response
     */
    public function addAction(ActionRequest $request){
        $input = $request->all();

        $validator = Validator::make($input, [
            'action' => 'required|in:call,visit',
            'id' => 'required',
        ]);

        if ($validator->fails()){
            return  $this->sendError('Validation Error.', $validator->errors());
        }

        $customer= Customer::find($input['id']);
        $customer->action = $input['action'];
        $customer->save();

        return $this->sendResponse(new CustomerResource($customer), 'Action added successfully');
    }
}

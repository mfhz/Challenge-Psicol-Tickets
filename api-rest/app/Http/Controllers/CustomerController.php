<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        $customers = Customer::with('tickets')->get();
        return response()->json($customers, 200);
    }

    /**
     * @param CustomerRequest $customerRequest
     * @return JsonResponse
     */
    public function store(CustomerRequest $customerRequest)
    {
        $customer = new Customer($customerRequest->all());
        $customer->save();

        return response()->json($customer, 200);
    }

    /**
     * @param Customer $customer
     * @return JsonResponse
     */
    public function show(Customer $customer)
    {
        $customer = Customer::with('tickets')->find($customer);
        return response()->json($customer);
    }

    /**
     * @param Customer $customer
     * @return JsonResponse
     */
    public function destroy(Customer $customer)
    {
        Customer::destroy($customer);

        return response()->json('customer deleted', 200);
    }

    /**
     * @param CustomerRequest $customerRequest
     * @param Customer $customer
     * @return JsonResponse
     */
    public function update(CustomerRequest $customerRequest, $customer)
    {
        $customer = Customer::find($customer)->update($customerRequest->all());
        return response()->json($customer, 200);
    }
}

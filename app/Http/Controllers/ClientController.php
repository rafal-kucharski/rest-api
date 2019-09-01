<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ClientController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     */
    function __construct()
    {
        $this->middleware('permission:client-list|client-create|client-edit|client-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:client-create', ['only' => ['create','store']]);
        $this->middleware('permission:client-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:client-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->sendResponse(Client::all(), 'Clients retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'vat_number' => 'required|digits:10',
            'street' => 'required',
            'city' => 'required',
            'post_code' => 'required|regex:/^([0-9]{2})(-[0-9]{3})?$/i',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $client = Client::create($input);

        return $this->sendResponse($client->toArray(), 'Client created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  Client  $client
     * @return Response
     */
    public function show(Client $client)
    {
        if ($client instanceof ModelNotFoundException) {
            return $this->sendError('Client not found.');
        }

        return $this->sendResponse($client, 'Client retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Client  $client
     * @return Response
     */
    public function update(Request $request, Client $client)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'vat_number' => 'required|digits:10',
            'street' => 'required',
            'city' => 'required',
            'post_code' => 'required|regex:/^([0-9]{2})(-[0-9]{3})?$/i',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $client->name = $input['name'];
        $client->vat_number = $input['vat_number'];
        $client->street = $input['street'];
        $client->city = $input['city'];
        $client->post_code = $input['post_code'];
        $client->email = $input['email'];
        $client->save();

        return $this->sendResponse($client->toArray(), 'Client updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Client  $client
     * @return Response
     * @throws \Exception
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return $this->sendResponse($client->toArray(), 'Client deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\clients;
use App\Models\Authors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class clientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $sortBy = $request->sort_by ?? '';
        $orderBy = $request->order_by ?? '';
        if ($orderBy && !in_array($orderBy, ['asc', 'desc'])) {
            $orderBy = '';
        }
        $filterBy = $request->filter_by ?? '';
        $filterValue = $request->filter_value ?? '0';
        $perPage = (int) $request->per_page ?? 20;
        
        if ($request->s) {

            $clients = clients::where('clients', 'like', '%'.$request->s.'%')->paginate(20)->withQueryString();
        
        } else {
        
            $clients = clients::select('clients.*');

            //filtravimas
            $clients = match($filterBy) {
                'rate' => $clients->where('rate', '=', $filterValue),
                default => $clients
            };

            //rikiavimas
            $clients = match($sortBy) {
                'clients' => $clients->orderBy('clients', $orderBy),
                'rate' => $clients->orderBy('rate', $orderBy),
                default => $clients
            };


            $clients = $clients->paginate($perPage)->withQueryString();

        }

       


        
        return view('clients.index', [
            'clients' => $clients,
            'sortBy' => $sortBy,
            'orderBy' => $orderBy,
            'filterBy' => $filterBy,
            'filterValue' => $filterValue,
            'perPage' => $perPage,
            's' => $request->s ?? ''
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = Authors::all();

        return view('clients.create', [
            'authors' => $authors
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make(
            $request->all(),
            [
                'clients' => 'required|max:7|regex:/^#[0-9A-F]{6}$/i',

                'author_id' => 'required|integer',

                'clients_rate' => 'required|integer|between:1,10',
            ],
            [
                'clients.required' => 'Please enter clients name!',
                'clients.max' => 'clients name is too long!',
                'clients.regex' => 'clients name must be in HEX format!',

                'author_id.required' => 'Please select author!',
                'author_id.integer' => 'Rate must be a number!',

                'clients_rate.required' => 'Please enter rate!',
                'clients_rate.integer' => 'Rate must be a number!',
                'clients_rate.between' => 'Rate must be between 1 and 10!',
            ]);

        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }

        $clients = new Clients;
        $clients->clients = $request->clients;
        $clients->author_id = $request->author_id;
        $clients->rate = $request->clients_rate;
        $clients->save();
        return redirect()
        ->route('clients-index')
        ->with('success', 'New clients has been added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(clients $clients)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(clients $clients)
    {
        $authors = Authors::all();
        
        return view('clients.edit', [
            'clients' => $clients,
            'authors' => $authors
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, clients $clients)
    {
        
        $validator = Validator::make(
            $request->all(),
            [
                'clients' => 'required|max:7|regex:/^#[0-9A-F]{6}$/i',
                'author_id' => 'required|integer',
                'clients_rate' => 'required|integer|between:1,10',
            ],
            [
                'clients.required' => 'Please enter clients name!',
                'clients.max' => 'clients name is too long!',
                'clients.regex' => 'clients name must be in HEX format!',
                
                'author_id.required' => 'Please select author!',
                'author_id.integer' => 'Rate must be a number!',

                'clients_rate.required' => 'Please enter rate!',
                'clients_rate.integer' => 'Rate must be a number!',
                'clients_rate.between' => 'Rate must be between 1 and 10!',
            ]);

        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }
        
        
        $clients->clients = $request->clients;
        $clients->author_id = $request->author_id;
        $clients->rate = $request->clients_rate;
        $clients->save();
        return redirect()
        ->route('clients-index')
        ->with('success', 'clients has been updated!');

    }

    public function delete(clients $clients)
    {
        return view('clients.delete', [
            'clients' => $clients
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(clients $clients)
    {
        $clients->delete();
        return redirect()
        ->route('clients-index')
        ->with('success', 'clients has been deleted!');
    }
}

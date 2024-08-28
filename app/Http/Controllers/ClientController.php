<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssetStoreRequest;
use App\Http\Requests\DisableRequest;
use App\Http\Requests\PersonStoreRequest;
use App\Models\Asset;
use App\Models\Client;
use App\Models\Item;
use App\Models\Person;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        $clients = Client::latest()->paginate(5);
          
        return view('clients.index', compact('clients'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
       
        $transactionRoute = 'clients.store';
        $client = new Client();

        return view('clients.form',compact('transactionRoute','client'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PersonStoreRequest $request):RedirectResponse
    {
        // Validate and create a new Person record
    $person = Person::create($request->validated());

    // Create a new Client record using the newly created Person's ID
    Client::create([
        'person_id' => $person->id,
        'company_id' => Auth::user()->company->id,
        'registration_date' => $request->input('registration_date'),
    ]);

    return redirect()->route('clients.index')
                     ->with('success', 'Client created successfully.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Client $client):View
    {
        return view('client.show',compact('client'));
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client):View
    {
        $transactionRoute = 'clients.update';
      
        return view('clients.form',compact('client','transactionRoute' ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PersonStoreRequest $request, Client $client):RedirectResponse
    {
        // $client = Client::findOrFail($client->id);
        $client->person->update($request->validated());
        $client->update([
            'registration_date' => $request->input('registration_date', $client->registration_date), // Keep existing if not provided
        ]);

        return redirect()->route('clients.index')
                        ->with('success', 'Client and Person updated successfully.');
        // $client->update($request->validated());
          
        // return redirect()->route('clients.index')
        //                 ->with('success','Client updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();
           
        return redirect()->route('clients.index')
                        ->with('success','Client deleted successfully');
    }

    public function getAllData(Request $request)
    {
        $search = $request->input('search');

        $query = Client::with(['person']);

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query
                    ->where('registration_date', 'LIKE', "%{$search}%")
                    ->orWhereHas('person', function ($q) use ($search) {
                        $q->where('first_name', 'LIKE', "%{$search}%");
                        $q->where('last_name', 'LIKE', "%{$search}%");
                        $q->where('contact_number', 'LIKE', "%{$search}%");
                        $q->where('address', 'LIKE', "%{$search}%");
                        $q->where('valid_id_type', 'LIKE', "%{$search}%");
                        $q->where('valid_id_no', 'LIKE', "%{$search}%");
                        $q->where('email', 'LIKE', "%{$search}%");
                    })
                    ;
            });
        }

        $data = $query->paginate(10);

        // Return data as JSON response
        return response()->json($data);
    }

    public function restDisable(DisableRequest $request, Client $client)
    {
        try {
            $validatedData = $request->validated();
    
            $dataToUpdate = array_filter(
                $validatedData,
                function ($value) {
                    return $value !== null;
                }
            );
    
            $client->update($dataToUpdate);
    
        
            return response()->json([
                'success' => true,
                'message' => 'Client updated successfully',
                'item' => $client
            ]);
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error updating item: ' . $e->getMessage());
    
            return response()->json([
                'success' => false,
                'message' => 'Failed to update item',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


}

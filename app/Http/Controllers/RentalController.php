<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssetStoreRequest;
use App\Http\Requests\DisableRequest;
use App\Http\Requests\RentalStoreRequest;
use App\Models\Asset;
use App\Models\Item;
use App\Models\Rental;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        $assets = Asset::all();
        $rentals = Rental::latest()->paginate(5);
          
        return view('rentals.index', compact('rentals', 'assets'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        $assets = Asset::all();
        $transactionRoute = 'rentals.store';
        $rental = new Rental();

        return view('rentals.form',compact('transactionRoute', 'assets', 'rental'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RentalStoreRequest $request):RedirectResponse
    {
        Rental::create($request->validated());
           
        return redirect()->route('rentals.index')
                         ->with('success', 'Rental created successfully.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Rental $rental):View
    {
        return view('rentals.show',compact('rental'));
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rental $rental):View
    {
        $transactionRoute = 'rentals.update';
        $assets = Asset::all();
        return view('rentals.form',compact('rental','transactionRoute', 'assets' ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RentalStoreRequest $request, Rental $rental):RedirectResponse
    {
        $rental->update($request->validated());
          
        return redirect()->route('rentals.index')
                        ->with('success','Rental updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rental $rental)
    {
        $rental->delete();
           
        return redirect()->route('rentals.index')
                        ->with('success','Rental deleted successfully');
    }

    public function getAllData(Request $request)
    {
        $search = $request->input('search');
        $assetId = $request->input('asset_id');
       
        $convertAssetId = null; // Initialize $convertAssetId with null or 0, depending on your needs

        if ($assetId) {
            $convertAssetId = (int) $assetId;
        }


        $query = Rental::with(['asset', 'asset.item']);

        if ($search || $convertAssetId) {
            $query->where(function ($query) use ($search, $convertAssetId) {
                // If asset_id is provided, include it in the query
                if ($convertAssetId) {
                    $query->where('asset_id', $convertAssetId);
                }
        
                // Apply search filters
                if ($search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('client', 'LIKE', "%{$search}%")
                              ->orWhereHas('asset.item', function ($query) use ($search) {
                                  $query->where('description', 'LIKE', "%{$search}%");
                              });
                    });
                }
            });
        }
        $query->orderBy('expected_pickup_datetime', 'desc');

        $data = $query->paginate(10);

        // Return data as JSON response
        return response()->json($data);
    }

    public function restDisable(DisableRequest $request, Rental $rental)
    {
        try {
            $validatedData = $request->validated();
    
            $dataToUpdate = array_filter(
                $validatedData,
                function ($value) {
                    return $value !== null;
                }
            );
    
            $rental->update($dataToUpdate);
    
        
            return response()->json([
                'success' => true,
                'message' => 'Rental updated successfully',
                'item' => $rental
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

    public function getConflicts(Request $request)
    {

        // Retrieve the validated data
        $expectedPickup = $request->input('expected_pickup_datetime');
        $expectedReturn = $request->input('expected_return_datetime');
        $assetId = $request->input('asset_id');

        // Query to find conflicting rentals
        $conflictingRentals = Rental::where('asset_id', $assetId)
            ->where(function ($query) use ($expectedPickup, $expectedReturn) {
                $query->where(function ($query) use ($expectedPickup, $expectedReturn) {
                    $query->where('expected_pickup_datetime', '<=', $expectedReturn)
                          ->where('expected_return_datetime', '>=', $expectedPickup);
                })
                ->orWhere(function ($query) use ($expectedPickup, $expectedReturn) {
                    $query->where('actual_pickup_datetime', '<=', $expectedReturn)
                          ->where('actual_return_datetime', '>=', $expectedPickup);
                });
            })
            ->where('deleted', false) // Optionally filter out deleted rentals
            ->get();

        return response()->json($conflictingRentals);
    }


}

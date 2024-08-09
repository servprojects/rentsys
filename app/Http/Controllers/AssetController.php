<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssetStoreRequest;
use App\Http\Requests\DisableRequest;
use App\Models\Asset;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        $asset = Asset::latest()->paginate(5);
          
        return view('assets.index', compact('asset'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        $items = Item::all();
        $transactionRoute = 'assets.store';
        $asset = new Asset();

        return view('assets.form',compact('transactionRoute', 'items', 'asset'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AssetStoreRequest $request):RedirectResponse
    {
        Asset::create($request->validated());
           
        return redirect()->route('assets.index')
                         ->with('success', 'Asset created successfully.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset):View
    {
        return view('assets.show',compact('asset'));
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset):View
    {
        $transactionRoute = 'asset.update';
        return view('assets.form',compact('asset','transactionRoute' ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AssetStoreRequest $request, Asset $asset):RedirectResponse
    {
        $asset->update($request->validated());
          
        return redirect()->route('assets.index')
                        ->with('success','Asset updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();
           
        return redirect()->route('assets.index')
                        ->with('success','Asset deleted successfully');
    }

    public function getAllData(Request $request)
    {
        $search = $request->input('search');

        $query = Asset::with(['item']);

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query
                    ->where('serial_number', 'LIKE', "%{$search}%")
                    ->orWhere('code', 'LIKE', "%{$search}%")
                    ->orWhere('desciption', 'LIKE', "%{$search}%")
                    ->orWhereHas('item', function ($q) use ($search) {
                        $q->where('description', 'LIKE', "%{$search}%");
                    })
                    ;
            });
        }

        $data = $query->paginate(10);

        // Return data as JSON response
        return response()->json($data);
    }

    public function restDisable(DisableRequest $request, Asset $asset)
    {
        try {
            $validatedData = $request->validated();
    
            $dataToUpdate = array_filter(
                $validatedData,
                function ($value) {
                    return $value !== null;
                }
            );
    
            $asset->update($dataToUpdate);
    
        
            return response()->json([
                'success' => true,
                'message' => 'Asset updated successfully',
                'item' => $asset
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

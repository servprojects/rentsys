<?php

namespace App\Http\Controllers;

use App\Http\Requests\DisableRequest;
use App\Http\Requests\ItemBrandStoreRequest;
use App\Models\ItemBrand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Log;

class ItemBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        $itemBrand = ItemBrand::latest()->paginate(5);
          
        return view('itemBrand.index', compact('itemBrand'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        $transactionRoute = 'item-brand.store';
        return view('itemBrand.form',compact('transactionRoute'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemBrandStoreRequest $request):RedirectResponse
    {
        ItemBrand::create($request->validated());
           
        return redirect()->route('item-brand.index')
                         ->with('success', 'Item Brand created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemBrand $itemBrand):View
    {
        return view('itemBrand.show',compact('itemBrand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemBrand $itemBrand):View
    {
        $transactionRoute = 'item-brand.update';
        return view('itemBrand.form',compact('itemBrand','transactionRoute' ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemBrandStoreRequest $request, ItemBrand $itemBrand)
    {
        $itemBrand->update($request->validated());
          
        return redirect()->route('item-brand.index')
                        ->with('success','Item Brand updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemBrand $itemBrand)
    {
        $itemBrand->delete();
           
        return redirect()->route('item-brand.index')
                        ->with('success','Item Brand deleted successfully');
    }

    public function getAllData(Request $request)
    {
        $search = $request->input('search');

        $query = ItemBrand::latest();

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query
                    ->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('details', 'LIKE', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        // Return data as JSON response
        return response()->json($data);
    }

    public function restDisable(DisableRequest $request, ItemBrand $item)
    {
        try {
            $validatedData = $request->validated();
    
            $dataToUpdate = array_filter(
                $validatedData,
                function ($value) {
                    return $value !== null;
                }
            );
    
            $item->update($dataToUpdate);
    
        
            return response()->json([
                'success' => true,
                'message' => 'Item updated successfully',
                'item' => $item
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

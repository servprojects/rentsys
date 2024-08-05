<?php

namespace App\Http\Controllers;

use App\Http\Requests\DisableRequest;
use App\Http\Requests\ItemStoreRequest;
use App\Models\Item;
use App\Models\ItemBrand;
use App\Models\ItemCategory;
use App\Models\ItemGenericName;
use Illuminate\Http\Request;
use Log;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $items = Item::with(['itemGenericName', 'itemBrand', 'itemCategory'])
            ->latest()
            ->paginate(5);

        return view('items.index', compact('items'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $itemGenericNames = ItemGenericName::all();
        $itemBrands = ItemBrand::all();
        $itemCategories = ItemCategory::all();
        $transactionRoute = 'items.store';
        $item = new Item();

        return view('items.create', compact('itemGenericNames', 'itemBrands', 'itemCategories', 'transactionRoute', 'item'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemStoreRequest $request)
    {
        Item::create($request->validated());

        return redirect()->route('items.index')->with('success', 'Item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        $itemGenericNames = ItemGenericName::all();
        $itemBrands = ItemBrand::all();
        $itemCategories = ItemCategory::all();
        $transactionRoute = 'items.update';
        return view('items.create', compact('item', 'transactionRoute', 'itemGenericNames', 'itemBrands', 'itemCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemStoreRequest $request, Item $item)
    {
        $item->update($request->validated());

        return redirect()->route('items.index')->with('success', 'Item updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item deleted successfully');
    }

    // API methods //

    public function getAllData(Request $request)
    {
        $search = $request->input('search');

        $query = Item::with(['itemGenericName', 'itemBrand', 'itemCategory']);

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query
                    ->where('model', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhere('details', 'LIKE', "%{$search}%")
                    ->orWhereHas('itemGenericName', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('itemBrand', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('itemCategory', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        $data = $query->paginate(10);

        // Return data as JSON response
        return response()->json($data);
    }

    public function restDisable(DisableRequest $request, Item $item)
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

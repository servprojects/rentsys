<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemStoreRequest;
use App\Models\Item;
use App\Models\ItemBrand;
use App\Models\ItemCategory;
use App\Models\ItemGenericName;
use Illuminate\Http\Request;

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

        return view('items.create', compact('itemGenericNames', 'itemBrands', 'itemCategories'));
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
        return view('items.edit', compact('item'));
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

    public function getAllData(Request $request)
    {
        // Fetch the search parameter from the request
        $search = $request->input('search');

        // Query the database with the search parameter
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

        $data = $query->paginate(2);

        // Return data as JSON response
        return response()->json($data);
    }
}

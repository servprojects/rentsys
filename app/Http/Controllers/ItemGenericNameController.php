<?php

namespace App\Http\Controllers;

use App\Http\Requests\DisableRequest;
use App\Http\Requests\ItemGenericNameStoreRequest;
use App\Models\ItemGenericName;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Log;

class ItemGenericNameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        $itemGenericName = ItemGenericName::latest()->paginate(5);
          
        return view('itemGenericName.index', compact('itemGenericName'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        $transactionRoute = 'item-generic-name.store';
        $itemGenericName = new ItemGenericName();
        return view('itemGenericName.form',compact('transactionRoute', 'itemGenericName'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemGenericNameStoreRequest $request):RedirectResponse
    {
        ItemGenericName::create($request->validated());
           
        return redirect()->route('item-generic-name.index')
                         ->with('success', 'Item Generic Name created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemGenericName $itemGenericName):View
    {
        return view('itemGenericName.show',compact('itemGenericName'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemGenericName $itemGenericName):View
    {
        $transactionRoute = 'item-generic-name.update';
        return view('itemGenericName.form',compact('itemGenericName','transactionRoute' ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemGenericNameStoreRequest $request, ItemGenericName $itemGenericName):RedirectResponse
    {
        $itemGenericName->update($request->validated());
          
        return redirect()->route('item-generic-name.index')
                        ->with('success','Item Generic Name updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemGenericName $itemGenericName)
    {
        $itemGenericName->delete();
           
        return redirect()->route('item-generic-name.index')
                        ->with('success','Item Generic Name deleted successfully');
    }

    // api
    public function getAllData(Request $request)
    {
        $search = $request->input('search');

        $query = ItemGenericName::latest();

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

    public function restDisable(DisableRequest $request, ItemGenericName $item)
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

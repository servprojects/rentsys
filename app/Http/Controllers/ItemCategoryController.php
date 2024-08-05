<?php

namespace App\Http\Controllers;

use App\Http\Requests\DisableRequest;
use App\Http\Requests\ItemCategoryStoreRequest;
use App\Models\ItemCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ItemCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        $itemCategory = ItemCategory::latest()->paginate(5);
          
        return view('itemCategory.index', compact('itemCategory'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        $transactionRoute = 'item-category.store';
        return view('itemCategory.form',compact('transactionRoute'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemCategoryStoreRequest $request):RedirectResponse
    {
        ItemCategory::create($request->validated());
           
        return redirect()->route('item-category.index')
                         ->with('success', 'Item Category created successfully.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(ItemCategory $itemCategory):View
    {
        return view('itemCategory.show',compact('itemCategory'));
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemCategory $itemCategory):View
    {
        $transactionRoute = 'item-category.update';
        return view('itemCategory.form',compact('itemCategory','transactionRoute' ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemCategoryStoreRequest $request, ItemCategory $itemCategory):RedirectResponse
    {
        $itemCategory->update($request->validated());
          
        return redirect()->route('item-category.index')
                        ->with('success','Item Generic Name updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemCategory $itemCategory)
    {
        $itemCategory->delete();
           
        return redirect()->route('item-category.index')
                        ->with('success','Item Generic Name deleted successfully');
    }

    public function getAllData(Request $request)
    {
        $search = $request->input('search');

        $query = ItemCategory::latest();

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

    public function restDisable(DisableRequest $request, ItemCategory $item)
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

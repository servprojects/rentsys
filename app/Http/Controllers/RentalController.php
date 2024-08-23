<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssetStoreRequest;
use App\Http\Requests\DisableRequest;
use App\Http\Requests\RentalStoreRequest;
use App\Models\Asset;
use App\Models\Item;
use App\Models\LeadSource;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $assets = Asset::all();
        $rentals = Rental::latest()->paginate(5);

        return view('rentals.index', compact('rentals', 'assets'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $assets = Asset::all();
        $leadSources = LeadSource::all();
        $transactionRoute = 'rentals.store';
        $rental = new Rental();

        return view('rentals.form', compact('transactionRoute', 'assets', 'rental', 'leadSources'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RentalStoreRequest $request): RedirectResponse
    {
        Rental::create($request->validated());

        return redirect()->route('rentals.index')->with('success', 'Rental created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rental $rental): View
    {
        return view('rentals.show', compact('rental'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rental $rental): View
    {
        $transactionRoute = 'rentals.update';
        $assets = Asset::all();
        return view('rentals.form', compact('rental', 'transactionRoute', 'assets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RentalStoreRequest $request, Rental $rental): RedirectResponse
    {
        $rental->update($request->validated());

        return redirect()->route('rentals.index')->with('success', 'Rental updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rental $rental)
    {
        $rental->delete();

        return redirect()->route('rentals.index')->with('success', 'Rental deleted successfully');
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
                        $query->where('client', 'LIKE', "%{$search}%")->orWhereHas('asset.item', function ($query) use ($search) {
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

            $dataToUpdate = array_filter($validatedData, function ($value) {
                return $value !== null;
            });

            $rental->update($dataToUpdate);

            return response()->json([
                'success' => true,
                'message' => 'Rental updated successfully',
                'item' => $rental,
            ]);
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error updating item: ' . $e->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Failed to update item',
                    'error' => $e->getMessage(),
                ],
                500,
            );
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
                $query
                    ->where(function ($query) use ($expectedPickup, $expectedReturn) {
                        $query->where('expected_pickup_datetime', '<=', $expectedReturn)->where('expected_return_datetime', '>=', $expectedPickup);
                    })
                    ->orWhere(function ($query) use ($expectedPickup, $expectedReturn) {
                        $query->where('actual_pickup_datetime', '<=', $expectedReturn)->where('actual_return_datetime', '>=', $expectedPickup);
                    });
            })
            ->where('deleted', false) // Optionally filter out deleted rentals
            ->get();

        return response()->json($conflictingRentals);
    }
    public function getMonthlyCounts()
    {
        $year = Carbon::now()->year;
        $monthlyCounts = [];

        for ($month = 1; $month <= 12; $month++) {
            $monthName = Carbon::create()->month($month)->format('F');
            $count = Rental::whereYear('expected_pickup_datetime', $year)->whereMonth('expected_pickup_datetime', $month)->count();

            $monthlyCounts[] = [
                'month' => $monthName,
                'count' => $count,
            ];
        }

        return response()->json($monthlyCounts);
    }

   public function getCategoryCounts()
{
    $year = Carbon::now()->year;

    $categoryCounts = Rental::whereYear('expected_pickup_datetime', $year)
        ->where('deleted', '!=', 1) // Only check rentals for deletion
        ->with(['asset.item.itemCategory' => function ($query) {
            $query->where('deleted', '!=', 1); // Ensure categories are not deleted
        }])
        ->get()
        ->flatMap(function ($rental) {
            return $rental->asset->item->itemCategory ? [
                $rental->asset->item->itemCategory->name => $rental->id
            ] : [];
        })
        ->countBy()
        ->map(function ($count, $category) {
            return [
                'category' => $category,
                'count' => $count
            ];
        });

    return response()->json($categoryCounts->values());
}

public function getAdsCounts()
{
    $year = Carbon::now()->year;

    $adsCounts = Rental::whereYear('expected_pickup_datetime', $year)
        ->where('deleted', '!=', 1) // Only check rentals for deletion
        ->select(
            DB::raw('
                SUM(CASE WHEN is_from_ads = 1 THEN 1 ELSE 0 END) as ads_count,
                SUM(CASE WHEN is_from_ads = 0 THEN 1 ELSE 0 END) as non_ads_count
            ')
        )
        ->first();

    return response()->json([
        'ads_count' => $adsCounts->ads_count,
        'non_ads_count' => $adsCounts->non_ads_count,
    ]);
}

public function getAvailableAssets(Request $request)
{
   // Use the current date if no specific date is provided
   $date = Carbon::parse($request->input('date', Carbon::now()->toDateString()));

   // Set the end date to the end of the next day
   $endDate = $date->copy()->addDay()->endOfDay();

   // Query to get all asset_ids that are not available between the specified date and the end of the next day
   $unavailableAssetIds = Rental::where(function($query) use ($date, $endDate) {
       $query->where(function($subQuery) use ($date, $endDate) {
           $subQuery->where('expected_pickup_datetime', '<=', $endDate)
                    ->where('expected_return_datetime', '>=', $date);
       });
   })->pluck('asset_id');

   // Query to get all item descriptions concatenated with asset codes that are available during the specified period
   $availableItemDescriptions = Asset::whereNotIn('id', $unavailableAssetIds)
                                     ->where('deleted', false)
                                     ->with('item:id,description')
                                     ->get()
                                     ->map(function ($asset) {
                                         return $asset->item->description . ' (' . $asset->code . ')';
                                     });

   return response()->json($availableItemDescriptions);
}
// public function getAvailableAssets(Request $request)
// {
//     // Use the current date if no specific date is provided
//     $date = $request->input('date', Carbon::now()->toDateString());

//     // Query to get all asset_ids that are not available on the specified date
//     $unavailableAssetIds = Rental::where(function($query) use ($date) {
//         $query->where('expected_pickup_datetime', '<=', $date)
//               ->where('expected_return_datetime', '>=', $date);
//     })->pluck('asset_id');

//     // Query to get all asset_ids that are available on the specified date
//     $availableAssets = Rental::whereNotIn('asset_id', $unavailableAssetIds)
//                              ->where('deleted', false)
//                              ->pluck('asset_id');

//     return response()->json($availableAssets);
// }



    
}

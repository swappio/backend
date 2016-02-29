<?php

namespace App\Http\Controllers;

use App\Services\SwapService;
use Illuminate\Http\Request;
use App\Models\Swap;

class SwapsController extends Controller
{
    /**
     * @var SwapService
     */
    private $swapsService;

    /**
     * SwapsController constructor.
     * @param SwapService $swapsService
     */
    public function __construct(SwapService $swapsService)
    {
        $this->swapsService = $swapsService;
    }


    public function create(Request $request)
    {
        $swap = $this->swapsService->create($request->all());
        if (!$swap) {
            abort(400);
        }

        return response()->json(['id' => $swap->id], 201);
    }

    public function matches($id)
    {
        return $this->swapsService->findMatches($this->swapsService->loadById($id));
    }
}

<?php

namespace App\Http\Controllers\OrderController;

use Illuminate\Http\Request;

class orderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = order::all();

        return response()->json($order);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $order = order::create($request->all());

        return response()->json($order, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = order::find($id);

        if (!$order) {
            return response()->json([
                'message'=> 'Pedido nn encontrado'
                ],404);
        }
        
            return response()->json($order,200); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateOrderRequest $request,
        order $order
    ): JsonResponse {
        $order->update($request->validated());

        return response()->json([
            'message' => 'Recomendação atualizada com sucesso.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(order $order): Response
    {
        $order->delete();

        return response()->noContent();
    }
}

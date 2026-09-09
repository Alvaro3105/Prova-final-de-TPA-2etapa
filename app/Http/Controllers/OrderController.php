<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Order::all(), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $dados = $request->validate($this->regras());
        $order = Order::create($dados);

        return response()->json($order, 201);
    }

    public function show(Order $order): JsonResponse
    {
        return response()->json($order, 200);
    }

    public function update(Request $request, Order $order): JsonResponse
    {
        $dados = $request->validate($this->regras($order, $request->isMethod('patch')));
        $order->update($dados);

        return response()->json($order->refresh(), 200);
    }

    public function destroy(Order $order): Response
    {
        $order->delete();

        return response()->noContent();
    }

    private function regras(?Order $order = null, bool $parcial = false): array
    {
        $obrigatorio = $parcial ? 'sometimes|required' : 'required';
        $codigo = Rule::unique('orders', 'codigo_pedido');
        if ($order !== null) {
            $codigo->ignore($order->id);
        }

        return [
            'cliente' => array_merge(explode('|', $obrigatorio), ['string', 'max:255']),
            'status' => array_merge(explode('|', $obrigatorio), ['string', 'max:255']),
            'codigo_pedido' => array_merge(explode('|', $obrigatorio), ['string', 'max:255', $codigo]),
            'total' => array_merge(explode('|', $obrigatorio), ['integer', 'min:0']),
        ];
    }
}

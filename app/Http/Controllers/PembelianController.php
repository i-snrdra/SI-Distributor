<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRole;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(\App\Models\Pembelian::with(['supplier', 'items.product'])->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== UserRole::Admin) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'tanggal' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);
        $total = 0;
        $itemsData = [];
        foreach ($validated['items'] as $item) {
            $product = \App\Models\Product::find($item['product_id']);
            $harga_beli = $product->harga_beli;
            $subtotal = $harga_beli * $item['qty'];
            $total += $subtotal;
            $itemsData[] = [
                'product_id' => $item['product_id'],
                'qty' => $item['qty'],
                'harga_beli' => $harga_beli,
                'subtotal' => $subtotal,
            ];
        }
        $pembelian = Pembelian::create([
            'supplier_id' => $validated['supplier_id'],
            'tanggal' => $validated['tanggal'],
            'total' => $total,
        ]);
        foreach ($itemsData as $item) {
            $pembelian->items()->create($item);
            $product = \App\Models\Product::find($item['product_id']);
            $product->stok += $item['qty'];
            $product->save();
        }
        return response()->json($pembelian->load('items'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pembelian = \App\Models\Pembelian::with(['supplier', 'items.product'])->find($id);
        if (!$pembelian) {
            return response()->json(['message' => 'Pembelian tidak ditemukan'], 404);
        }
        return response()->json($pembelian);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== UserRole::Admin) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $pembelian = Pembelian::find($id);
        if (!$pembelian) {
            return response()->json(['message' => 'Pembelian tidak ditemukan'], 404);
        }
        $validated = $request->validate([
            'supplier_id' => 'sometimes|required|exists:suppliers,id',
            'product_id' => 'sometimes|required|exists:products,id',
            'qty' => 'sometimes|required|integer|min:1',
            'harga_beli' => 'sometimes|required|numeric',
            'total' => 'sometimes|required|numeric',
            'tanggal' => 'sometimes|required|date',
        ]);
        $pembelian->update($validated);
        return response()->json($pembelian->load(['supplier', 'product']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Auth::user()->role !== UserRole::Admin) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $pembelian = Pembelian::find($id);
        if (!$pembelian) {
            return response()->json(['message' => 'Pembelian tidak ditemukan'], 404);
        }
        $pembelian->delete();
        return response()->json(['message' => 'Pembelian berhasil dihapus']);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRole;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(\App\Models\Penjualan::with(['items.product'])->get());
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
            'nama_customer' => 'required|string',
            'tanggal' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);
        $total = 0;
        $itemsData = [];
        foreach ($validated['items'] as $item) {
            $product = \App\Models\Product::find($item['product_id']);
            $harga_jual = $product->harga_jual;
            $subtotal = $harga_jual * $item['qty'];
            $total += $subtotal;
            $itemsData[] = [
                'product_id' => $item['product_id'],
                'qty' => $item['qty'],
                'harga_jual' => $harga_jual,
                'subtotal' => $subtotal,
            ];
        }
        $penjualan = Penjualan::create([
            'nama_customer' => $validated['nama_customer'],
            'tanggal' => $validated['tanggal'],
            'total' => $total,
        ]);
        foreach ($itemsData as $item) {
            $penjualan->items()->create($item);
            $product = \App\Models\Product::find($item['product_id']);
            $product->stok -= $item['qty'];
            $product->save();
        }
        return response()->json($penjualan->load('items'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $penjualan = \App\Models\Penjualan::with(['items.product'])->find($id);
        if (!$penjualan) {
            return response()->json(['message' => 'Penjualan tidak ditemukan'], 404);
        }
        return response()->json($penjualan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== UserRole::Admin) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $penjualan = Penjualan::find($id);
        if (!$penjualan) {
            return response()->json(['message' => 'Penjualan tidak ditemukan'], 404);
        }
        $validated = $request->validate([
            'product_id' => 'sometimes|required|exists:products,id',
            'nama_customer' => 'sometimes|required|string',
            'qty' => 'sometimes|required|integer|min:1',
            'harga_jual' => 'sometimes|required|numeric',
            'total' => 'sometimes|required|numeric',
            'tanggal' => 'sometimes|required|date',
        ]);
        $penjualan->update($validated);
        return response()->json($penjualan->load('product'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Auth::user()->role !== UserRole::Admin) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $penjualan = Penjualan::find($id);
        if (!$penjualan) {
            return response()->json(['message' => 'Penjualan tidak ditemukan'], 404);
        }
        $penjualan->delete();
        return response()->json(['message' => 'Penjualan berhasil dihapus']);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items'])->latest()->get();
        return view('admin.order.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::with('items')->findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Kurangi stok: pending → process atau done
        if (
            in_array($newStatus, ['process', 'done']) &&
            $oldStatus === 'pending'
        ) {
            foreach ($order->items as $item) {
                $produk = \App\Models\Produk::find($item->produk_id);
                if ($produk) {
                    $produk->stok = max(0, $produk->stok - $item->qty);
                    $produk->save();
                }
            }
        }

        $order->update(['status' => $newStatus]);

        return back()->with('success', 'Status pesanan diperbarui');
    }

    public function destroy($id)
    {
        Order::findOrFail($id)->delete();
        return redirect()->route('admin.order.index')->with('success', 'Pesanan berhasil dihapus');
    }

    public function cancel(Request $request, $id)
    {
        $request->validate([
            'alasan_batal' => 'required|string|max:255',
        ]);

        $order = Order::with('items')->findOrFail($id);
        $oldStatus = $order->status;

        // Kembalikan stok jika sebelumnya sudah process/done
        if (in_array($oldStatus, ['process', 'done'])) {
            foreach ($order->items as $item) {
                $produk = \App\Models\Produk::find($item->produk_id);
                if ($produk) {
                    $produk->stok += $item->qty;
                    $produk->save();
                }
            }
        }

        $order->update([
            'status' => 'cancelled',
            'alasan_batal' => $request->alasan_batal,
        ]);

        return back()->with('success', 'Pesanan ' . $order->kode_order . ' berhasil dibatalkan.');
    }
}
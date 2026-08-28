<?php
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', [ProductController::class, 'index'])->middleware('auth')->name('products.index');

Route::get('/dashboard', function () {
    return redirect()->route('products.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/checkout', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/checkout', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{orderNumber}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/address', [ProfileController::class, 'updateAddress'])->name('address.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/orders/{orderNumber}/pay', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/orders/{orderNumber}/pay', [PaymentController::class, 'process'])->name('payments.process');
    Route::get('/orders/{orderNumber}/boleto-pdf', function (\Illuminate\Http\Request $request, int $orderNumber) {
        $order = $request->user()->orders()->where('order_number', $orderNumber)->firstOrFail();
        $barcode = \App\Services\BoletoGenerator::generateBarcode($order->id, (float) $order->total);
        $linhaDigitavel = \App\Services\BoletoGenerator::formatLinhaDigitavel($barcode);

        return \Barryvdh\DomPDF\Facade\Pdf::loadView('payments.boleto-pdf', [
            'order' => $order->load('user'),
            'barcode' => $barcode,
            'linhaDigitavel' => $linhaDigitavel,
        ])->download('boleto-pedido-'.$order->order_number.'.pdf');
    })->name('payments.boleto-pdf');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
});

require __DIR__.'/auth.php';

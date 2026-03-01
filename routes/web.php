<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Frontend\TransactionUserController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Controllers\ShippingOptionController;
/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return redirect()->route('product.index');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/payment-success', function () {
    return view('frontend.payment-success');
})->name('payment.success');


Route::get('/checkout/success/{id}', function ($id) {
    $transaction = \App\Models\Transaction::findOrFail($id);
    return view('frontend.checkout-success', compact('transaction'));
})->name('checkout.success');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Products (Frontend)
    Route::get('/products', [FrontendProductController::class, 'index'])->name('product.index');
    Route::get('/products/{product}', [FrontendProductController::class, 'show'])->name('product.show');

    // Cart
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.index');
    Route::patch('/cart/{cart}/update', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/{cart}/remove', [CartController::class, 'removeItem'])->name('cart.remove');

    // Checkout
    Route::get('/checkout', [TransactionController::class, 'checkoutPage'])->name('checkout.page');
    Route::post('/checkout', [TransactionController::class, 'checkout'])->name('checkout.process');

    // Payment (Midtrans)
    Route::get('/payment/{transaction}/pay', [PaymentController::class, 'pay'])
        ->name('payment.pay');

    Route::get('/payment/result', [PaymentController::class, 'result'])->name('payment.result');

    // Invoice (PISAH URL — tidak bentrok)
    Route::get('/transactions/{transaction}/invoice/download', [TransactionController::class, 'generateInvoice'])
        ->name('transactions.invoice.download');

    Route::get('/transactions/{transaction}/invoice/print', [TransactionController::class, 'printInvoice'])
        ->name('transactions.invoice.print');

    // User Transactions
    Route::get('/user/transactions', [TransactionUserController::class, 'userTransactions'])
        ->name('user.transactions.index');
    Route::get('/user/transactions/{id}', [TransactionUserController::class, 'userTransactionDetails'])
        ->name('user.transactions.details');
    Route::post('/user/transactions/{id}/cancel', [TransactionUserController::class, 'cancelTransaction'])
        ->name('user.transactions.cancel');
    Route::delete('/user/transactions/{id}/delete', [TransactionUserController::class, 'deleteTransaction'])
        ->name('user.transactions.delete');
    Route::post('/user/transactions/bulk-delete', [TransactionUserController::class, 'bulkDelete'])
        ->name('user.transactions.bulk-delete');
});

/*
|--------------------------------------------------------------------------
| Midtrans Webhook (NO AUTH!)
|--------------------------------------------------------------------------
*/
Route::post('/payment/midtrans/callback', [PaymentController::class, 'callback'])
    ->name('payment.callback');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', EnsureUserIsAdmin::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Transactions Management
        Route::get('/transactions', [DashboardController::class, 'transactionPage'])->name('transactions.index');
        Route::get('/transactions/{transaction}', [DashboardController::class, 'transactionDetail'])->name('transactions.show');
        Route::patch('/transactions/{transaction}/shipping', [DashboardController::class, 'updateShippingStatus'])->name('transactions.update-shipping');

        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);

        Route::post('/products/{product}/toggle-active', [ProductController::class, 'toggleActive'])
            ->name('products.toggle-active');

        Route::post('/transactions/{transaction}/{status}', [DashboardController::class, 'updateStatus'])
            ->name('transactions.update-status');
        Route::post('/transactions/bulk-delete', [DashboardController::class, 'bulkDeleteTransactions'])
            ->name('transactions.bulk-delete');


        Route::get('/shipping-options', [ShippingOptionController::class, 'index'])->name('shipping-options.index');
        Route::get('/shipping-options/create', [ShippingOptionController::class, 'create'])->name('shipping-options.create');
        Route::post('/shipping-options', [ShippingOptionController::class, 'store'])->name('shipping-options.store');
        Route::put('/shipping-options/{id}', [ShippingOptionController::class, 'update'])->name('shipping-options.update');
        Route::delete('/shipping-options/{id}', [ShippingOptionController::class, 'destroy'])->name('shipping-options.destroy');
    });

/*
|--------------------------------------------------------------------------
| Reports & Maintenance
|--------------------------------------------------------------------------
*/
Route::get('/transactions/report', [TransactionController::class, 'generateReport'])
    ->name('transactions.report');

Route::delete('/transactions/{transaction}/delete', [TransactionController::class, 'destroy'])
    ->name('transactions.destroy');

require __DIR__ . '/auth.php';

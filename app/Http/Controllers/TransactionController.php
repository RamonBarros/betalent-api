<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    protected TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id'   => 'required|exists:clients,id',
            'products'    => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'card_number' => 'required|string',
            'name'        => 'required|string',
            'email'       => 'required|email',
            'cvv'         => 'required|string|size:3',
        ]);
        $transaction = $this->transactionService->createTransaction($validated);

        return response()->json($transaction, 201);
    }

    public function index()
    {
        return $this->transactionService->listTransactions();
    }

    public function show($id)
    {
        return $this->transactionService->getTransaction($id);
    }

    public function refund($id)
    {
        return $this->transactionService->refundTransaction($id);
    }
}
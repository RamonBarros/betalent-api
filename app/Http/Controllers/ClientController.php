<?php
namespace App\Http\Controllers;
use App\Services\ClientService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index()
    {
        return response()->json($this->clientService->list());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
        ]);

        return response()->json($this->clientService->create($data), 201);
    }

    public function show(int $id)
    {
        return response()->json($this->clientService->find($id));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => "sometimes|required|email|unique:clients,email,{$id}",
        ]);


        return response()->json($this->clientService->update($id, $data));
    }

    public function destroy(int $id)
    {
        $this->clientService->delete($id);
        return response()->json(null, 204);
    }

}
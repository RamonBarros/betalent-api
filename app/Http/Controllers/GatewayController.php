<?php
namespace App\Http\Controllers;
use App\Services\GatewayService;

class GatewayController extends Controller
{
     protected GatewayService $gatewayService;

    public function __construct(GatewayService $gatewayService)
    {
        $this->gatewayService = $gatewayService;
    }

    public function index()
    {
        return $this->gatewayService->list();
    }

    public function toggleActive($id)
    {
        return $this->gatewayService->toggleActive($id);
    }

    public function changePriority($id)
    {
        $priority = request()->input('priority');

        return $this->gatewayService->changePriority($id, $priority);
    }

    
}
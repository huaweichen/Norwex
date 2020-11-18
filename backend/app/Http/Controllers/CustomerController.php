<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use App\Repositories\CustomerOrderRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CustomerController
 * @package App\Http\Controllers
 */
class CustomerController extends Controller
{
    /**
     * @var CustomerOrderRepository
     */
    private CustomerOrderRepository $customerOrderRepository;

    /**
     * CustomerController constructor.
     * @param CustomerOrderRepository $customerOrderRepository
     */
    public function __construct(CustomerOrderRepository $customerOrderRepository)
    {
        $this->customerOrderRepository = $customerOrderRepository;
    }

    /**
     */
    public function index(): JsonResponse
    {
        $customerCollection = $this->customerOrderRepository->getCustomerList();
        return CustomerResource::collection($customerCollection)
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}

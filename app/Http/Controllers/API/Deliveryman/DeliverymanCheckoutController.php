<?php

namespace CodeDelivery\Http\Controllers\API\Deliveryman;


use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Service\OrderService;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;


class DeliverymanCheckoutController extends Controller
{
    /**
     * @var OrderRepository
     */
    private $repository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var OrderService
     */
    private $service;

    private $with = ['client', 'cupom', 'items'];

    public function __construct(
        OrderRepository $repository,
        UserRepository $userRepository,
        OrderService $service
    )
    {

        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->service = $service;
    }

    public function index()
    {

        $id = Authorizer::getResourceOwnerId();
        $orders = $this->repository
            ->skipPresenter(false)
            ->with($this->with)
            ->scopeQuery(function ($query) use ($id) {
            return $query->where('user_deliveryman_id', '=', $id);
        })->paginate();

        return $orders;
    }


    public function show($id)
    {
        $idDeliveryman = Authorizer::getResourceOwnerId();
        return $this->repository
            ->skipPresenter(false)
            ->getByIdAndDeliveryman($id, $idDeliveryman);


    }

    public function updateStatus(Request $request, $id)
    {
        $idDeliveryman = Authorizer::getResourceOwnerId();
        $order = $this->service->updateStatus($id, $idDeliveryman, $request->get('status'));
       if($order) {
           return $this->repository->find($order->id);
       }
       abort(400, "Order não encontrada");
    }
}
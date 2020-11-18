<?php

namespace App\Repositories;

use App\Models\CustomerStatus;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CustomerOrderRepository
{
    /**
     * Highlight `Removed` customers in RED
     * `Active` customers who have not placed any orders during the last 12 months in ORANGE
     * `Active` customers who have placed a minimum of RM200.00 in sales over the last 3 months in GREEN (check the `OrderStatus` and make sure you are only including `Completed` orders in this calculation)
     * Include a total order count for each customer
     *
     * @return Collection
     */
    public function getCustomerList(): Collection
    {
        $removedCustomersBuilder = $this->getRemovedCustomers();
        $activeCustomerWithoutOrdersBuilder = $this->getActiveCustomerWithoutOrders(12);
        $activeCustomerWithOrderAndCertainAmount = $this->getActiveCustomerWithOrderAndCertainAmount(3, 200);

        return $activeCustomerWithOrderAndCertainAmount
            ->union($activeCustomerWithoutOrdersBuilder)
            ->union($removedCustomersBuilder)
            ->get();
    }


    /**
     * Get all removed customers with count of orders.
     *
     * @return Builder
     */
    private function getRemovedCustomers(): Builder
    {
        return $this->customerOrderSharedBuilder()
            ->where('code', '=', CustomerStatus::REMOVED)
            ->select(DB::raw(
                'customers.name as name,
                count(order_id) as count,
                \'red\' as color'
            ));
    }

    /**
     * Get all active customers with count of orders,
     * who since X amount of months hasn't place any order.
     *
     * @param int $month
     * @return Builder
     */
    private function getActiveCustomerWithoutOrders(int $month): Builder
    {
        return $this->customerOrderSharedBuilder()
            ->where('code', '=', CustomerStatus::ACTIVE)
            ->whereNotIn('customers.customer_id', function ($query) use ($month) {
                return $query->select('orders.customer_id')
                    ->from('orders')
                    ->where('orders.created_date_time', '>=', Carbon::now()->subMonths($month))
                    ->groupBy('orders.customer_id');
            })
            ->select(DB::raw(
                'customers.name as name,
                count(order_id) as count,
                \'orange\' as color'
            ));
    }

    /**
     * Get all active customers with count of orders,
     * who since X amount of months has placed order above X amount of total value.
     *
     * @param int $month
     * @param int $amount
     * @return Builder
     */
    private function getActiveCustomerWithOrderAndCertainAmount(int $month, int $amount): Builder
    {
        return $this->customerOrderSharedBuilder()
            ->where('customer_status.code', '=', CustomerStatus::ACTIVE)
            ->whereIn('customers.customer_id', function ($query) use ($amount, $month) {
                return $query->select('total.customer_id')
                    ->from(function($query) use ($month) {
                        return $query->select('customer_id', DB::raw('SUM(order_total) as sales'))
                            ->from('orders')
                            ->where('created_date_time', '>=',
                            Carbon::now()->subMonths($month))
                            ->where('order_status', '=', 'C')
                            ->groupBy('orders.customer_id');
                    }, 'total')
                    ->where('total.sales', '>=', $amount);
            })
            ->select(DB::raw('customers.name as name,
                count(order_id) as count,
                \'green\' as color'));
    }

    /**
     * @return Builder
     */
    private function customerOrderSharedBuilder(): Builder
    {
        return DB::table('customers')
            ->join('customer_status', 'customer_status.customer_status_id', '=', 'customers.customer_status_id')
            ->leftJoin('orders', 'orders.customer_id', '=', 'customers.customer_id')
            ->groupBy('customers.name')
            ->orderBy('customers.name');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected string $table = 'customers';

    /**
     * @var string
     */
    protected string $primaryKey = 'customer_id';

    /**
     * @var bool
     */
    public bool $timestamps = false;

    /**
     * @var array|string[]
     */
    public array $fillable = [
        'customer_status_id',
        'name'
    ];

    /**
     * Link to customer's status.
     *
     * @return HasOne
     */
    public function customerStatus(): HasOne
    {
        return $this->hasOne(CustomerStatus::class, 'customer_status_id', 'customer_status_id');
    }
}

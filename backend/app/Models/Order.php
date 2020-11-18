<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    public const CREATED_AT = 'created_date_time';

    /**
     * @inheritdoc
     */
    public const UPDATED_AT = null;

    /**
     * @var string
     */
    public const COMPLETED = 'C';

    /**
     * @var string
     */
    public const INCOMPLETE = 'I';

    /**
     * @var string
     */
    protected string $table = 'orders';

    /**
     * @var string
     */
    protected string $primaryKey = 'order_id';

    /**
     * @var array|string[]
     */
    public array $fillable = [
        'customer_id',
        'order_status',
        'order_total',
    ];
}

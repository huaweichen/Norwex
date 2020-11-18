<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerStatus extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    public const ACTIVE = 'AC';

    /**
     * @var string
     */
    public const REMOVED = 'RE';

    /**
     * @var string
     */
    protected string $table = 'customer_status';

    /**
     * @var string
     */
    protected string $primaryKey = 'customer_status_id';

    /**
     * @var bool
     */
    public bool $timestamps = false;

    /**
     * @var array|string[]
     */
    public array $fillable = [
        'code',
        'name',
    ];
}

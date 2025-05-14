<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transactions extends Model  // Changed to singular (convention)
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'type',
        'name',
        'value',
        'currency',
        'status',
        'notes',
        'user_id',
        'category_id'
    ];

    protected $casts = [
        'date' => 'date',       // Automatically casts to Carbon instance
        'value' => 'decimal:2'  // Ensures proper decimal handling
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category()
{
    return $this->belongsTo(Category::class);
}

    // Scopes
    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['filter'] ?? null, function ($query, $filter) {
            if ($filter === 'only') {
                $query->onlyTrashed();
            }
        });

        // Additional filtering examples:
        $query->when($filters['type'] ?? null, fn ($q, $type) => $q->where('type', $type));
        $query->when($filters['status'] ?? null, fn ($q, $status) => $q->where('status', $status));
    }
}

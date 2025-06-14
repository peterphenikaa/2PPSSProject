<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Các thuộc tính có thể gán (mass assignable)
     *
     * @var array
     */
   protected $fillable = [
    'user_id', 'recipient_name', 'recipient_phone',
    'province', 'district', 'ward', 'address_detail',
    'payment_method', 'total_price', 'status',
];

    /**
     * Các giá trị mặc định
     *
     * @var array
     */
    protected $attributes = [
        'status' => 'Chờ xác nhận',
        'payment_method' => 'cod'
    ];

    /**
     * Kiểu dữ liệu của các thuộc tính
     *
     * @var array
     */
    protected $casts = [
        'total_price' => 'integer',
    ];

    /**
     * Quan hệ với User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Quan hệ với OrderItem
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Quan hệ với OrderItem (alias của items)
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Quan hệ với Product thông qua OrderItem
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items')
                   ->withPivot(['quantity', 'price', 'size'])
                   ->withTimestamps();
    }

    /**
     * Scope cho đơn hàng đang chờ xác nhận
     */
    public function scopePending($query)
    {
        return $query->where('status', 'Chờ xác nhận');
    }

    /**
     * Scope cho đơn hàng đã xác nhận
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'Đã xác nhận');
    }

    /**
     * Tính tổng số lượng sản phẩm trong đơn hàng
     */
    public function totalItems()
    {
        return $this->items()->sum('quantity');
    }
}
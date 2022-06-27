<?php

namespace App\Models;

use App\Models\TranslateAwareModel;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use App\Models\items;

class Categories extends TranslateAwareModel implements Sortable
{

    use SortableTrait;

    protected $table = 'categories';
    public $translatable = ['name'];

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];

   

    

    public function items()
    {
        return $this->hasMany(Items::class, 'category_id', 'id');
    }

    public function aitems()
    {
        return $this->hasMany(Items::class, 'category_id', 'id')->where(['items.available'=>1]);
    }

   

    public static function boot()
    {
        parent::boot();
        self::deleting(function (self $categories) {
            //Delete items
            foreach ($categories->items()->get() as $key => $item) {
                $item->forceDelete();
            }

            return true;
        });
    }
}

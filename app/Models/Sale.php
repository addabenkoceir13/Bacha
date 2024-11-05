<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
  use HasFactory, SoftDeletes, SoftCascadeTrait;

  protected $fillable = [
    'category_id',
    'name_product',
    'quantity',
    'amount',
    'is_debt',
    'name_client',
    'notes',
    'date_debt',
    'type',
    'status_debt',
  ];

  public function category()
  {
    return $this->belongsTo(Category::class);
  }
}

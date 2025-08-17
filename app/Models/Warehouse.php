<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warehouse extends Model
{
    use HasFactory, HasFilter;

    protected $filterSearchCols = ['name'];

    protected $fillable = ['name', 'location'];

    /* ============================== relations ============================== */
    public function stocks() { return $this->hasMany(Stock::class); }
}
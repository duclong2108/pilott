<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Winner extends Model
{
  use HasFactory;
  protected $fillable = [
    'user_id',
    'check',
    'type',
    'money',
    'result_prediction',
    'status',
    'count'
    ///check 1 is win or 0 is lose
    // result_prediction is result of xsmb
    // type 1 is DB, 0 is Lo to
    // money is points to bet
    /// check khi 6h30 thi ms thanh 1 hay 0
    // status 1 la trung giai nhg chua nhan thg, 0 la k trung giai, -1 la trung giai nhg da nhan, 2 cho ket qua
  ];
}

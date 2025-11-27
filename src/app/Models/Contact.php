<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = ['category_id', 'gender', 'tel', 'last_name', 'first_name', 'email', 'address', 'building', 'detail'];

    public function getGenderLabelAttribute()
    {
        $labels = [1 => '男性', 2 => '女性', 3 => 'その他'];
        return $labels[$this->gender] ?? '-';
    }

    public function getCategoryLabelAttribute()
    {
        $labels = [
            1 => '商品のお届けについて',
            2 => '商品交換について',
            3 => '商品トラブル',
            4 => 'ショップへのお問い合わせ',
            5 => 'その他'
        ];
        return $labels[$this->category_id] ?? '-';
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjangs'; // nama tabel di database
    protected $fillable = ['user_id', 'product_id', 'quantity']; // contoh kolom yang diizinkan

    public function destination()
{
    return $this->belongsTo(Destination::class, 'destination_id');
}

}

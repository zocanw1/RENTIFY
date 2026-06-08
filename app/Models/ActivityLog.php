<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = ['user_id','aksi','keterangan','model','model_id','data_lama','data_baru','ip'];
    protected $casts = ['data_lama'=>'array','data_baru'=>'array'];

    public function user() { return $this->belongsTo(User::class); }

    // Helper static untuk log mudah
    public static function catat(string $aksi, string $keterangan, $model = null, $id = null, $lama = null, $baru = null)
    {
        return static::create([
            'user_id'    => auth()->id(),
            'aksi'       => $aksi,
            'keterangan' => $keterangan,
            'model'      => $model,
            'model_id'   => $id,
            'data_lama'  => $lama,
            'data_baru'  => $baru,
            'ip'         => request()->ip(),
        ]);
    }
}

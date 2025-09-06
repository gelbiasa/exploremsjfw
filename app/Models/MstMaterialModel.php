<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MstMaterial
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $kode_baru_fg
 * @property string $id_mat_group
 * @property string $customer
 * @property string $product_name
 * @property string $division
 * @property string $mat_g1
 * @property string $mat_g2
 * @property string $mat_g3
 * @property string|null $keterangan
 * @property float|null $length
 * @property float|null $width
 * @property float|null $weight
 * @property string $alt_uom
 * @property int|null $top_load
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property string|null $user_create
 * @property string|null $user_update
 * @property string|null $it_update
 * @property string $status
 * @property string $isactive
 */
class MstMaterialModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mst_material';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode_baru_fg',
        'id_mat_group',
        'customer',
        'product_name',
        'division',
        'mat_g1',
        'mat_g2',
        'mat_g3',
        'keterangan',
        'length',
        'width',
        'weight',
        'alt_uom',
        'top_load',
        'user_create',
        'user_update',
        'it_update',
        'status',
        'isactive',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'length' => 'float',
        'width' => 'float',
        'weight' => 'float',
        'top_load' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
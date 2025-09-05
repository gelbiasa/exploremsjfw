<?php

namespace App\Models\Transaksi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrsBomH extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trs_bom_h';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'trs_bom_h_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mat_type',
        'resource',
        'capacity',
        'width',
        'length',
        'product',
        'process',
        'material_fg_sfg_kode_lama',
        'material_fg_sfg',
        'isactive',
        'user_create',
        'user_update',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'capacity' => 'decimal:2',
        'width' => 'decimal:2',
        'length' => 'decimal:2',
        'isactive' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the detail records associated with the header.
     */
    public function details(): HasMany
    {
        return $this->hasMany(TrsBomD::class, 'fk_trs_bom_h_id', 'trs_bom_h_id');
    }
}

<?php

namespace App\Models\Transaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrsBomD extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trs_bom_d';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'trs_bom_d_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fk_trs_bom_h_id',
        'header_desc',
        'plant',
        'usage',
        'alt_bom_no',
        'valid_from',
        'alternative_bom_text',
        'product_qty',
        'base_uom_header',
        'item_number',
        'type',
        'comp_material_code',
        'comp_desc',
        'comp_qty',
        'uom',
        'wip_material',
        'length_per_unit',
        'waste_jumbo',
        'remark',
        'gsm',
        'extra_panjang',
        'jumbo',
        'rewind',
        'berat_sfg',
        'lebar',
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
        'valid_from' => 'date',
        'product_qty' => 'decimal:3',
        'comp_qty' => 'decimal:3',
        'length_per_unit' => 'decimal:3',
        'waste_jumbo' => 'decimal:3',
        'gsm' => 'decimal:2',
        'extra_panjang' => 'decimal:2',
        'jumbo' => 'decimal:2',
        'rewind' => 'decimal:2',
        'berat_sfg' => 'decimal:3',
        'lebar' => 'decimal:3',
        'isactive' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the header record that owns the detail.
     */
    public function header(): BelongsTo
    {
        return $this->belongsTo(TrsBomH::class, 'fk_trs_bom_h_id', 'trs_bom_h_id');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RumusAndTemplateController extends Controller
{
    /**
     * Fungsi universal untuk handle rekomendasi value (material & altbom)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRecommendations(Request $request)
    {
        $type = $request->get('type');
        $query = $request->get('q');

        if (!$query || strlen($query) < 1) {
            return response()->json([]);
        }

        switch ($type) {
            case 'material':
                return $this->getMaterialRecommendations($query);
            case 'altbom':
                return $this->getAltBomRecommendations($query);
            default:
                return response()->json([]);
        }
    }

    /**
     * Rekomendasi Material FG/SFG (universal)
     * 
     * @param string $query
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMaterialRecommendations($query)
    {
        $materials = DB::table('trs_bom_h')
            ->where('isactive', '1')
            ->where('material_fg_sfg', 'LIKE', "%$query%")
            ->whereRaw("LEFT(material_fg_sfg, 1) != '7'")
            ->select('material_fg_sfg', 'product')
            ->distinct()
            ->orderBy('material_fg_sfg', 'asc')
            ->limit(10)
            ->get();

        return response()->json($materials);
    }

    /**
     * Rekomendasi Alternative BOM Text (universal)
     * 
     * @param string $query
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAltBomRecommendations($query)
    {
        // Tidak tampilkan rekomendasi jika ada karakter '-'
        if (strpos($query, '-') !== false) {
            return response()->json([]);
        }

        $altBomTexts = DB::table('trs_bom_d')
            ->where('isactive', '1')
            ->whereNotNull('alternative_bom_text')
            ->where('alternative_bom_text', '!=', '')
            ->select(DB::raw('DISTINCT alternative_bom_text'))
            ->orderBy('alternative_bom_text', 'asc')
            ->get();

        $processed = collect();

        foreach ($altBomTexts as $item) {
            $text = $item->alternative_bom_text;
            $cleanText = $text;

            // Ambil bagian setelah kode resource (misal XX- atau XXX-)
            if (preg_match('/^[A-Z0-9]{1,3}-(.+)$/', $text, $matches)) {
                $cleanText = $matches[1];
            }

            // Filter hanya jika query ditemukan di bagian cleanText
            if (stripos($cleanText, $query) !== false) {
                $processed->push((object) ['alt_bom_text' => $cleanText]);
            }
        }

        // Hilangkan duplikat dan batasi maksimal 15 hasil
        $filtered = $processed->unique('alt_bom_text')->values()->take(15);

        return response()->json($filtered);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NilaiController extends Controller
{

    public function getNilaiST()
    {
        $results = DB::table('nilai')
            ->select(
                'nama',
                'nisn',
                'nama_pelajaran',
                DB::raw('
            SUM(
                CASE
                    WHEN pelajaran_id = 44 THEN skor * 41.67
                    WHEN pelajaran_id = 45 THEN skor * 29.67
                    WHEN pelajaran_id = 46 THEN skor * 100
                    WHEN pelajaran_id = 47 THEN skor * 23.81
                    ELSE 0
                END
            ) as total_nilai
        ')
            )
            ->where('materi_uji_id', 4)
            ->groupBy('nama', 'nisn', 'nama_pelajaran')
            ->orderBy('total_nilai', 'desc')
            ->get();
        $transformedResults = $results->groupBy('nama')->map(function ($group) {
            $listNilai = $group->mapWithKeys(function ($item) {
                return [$item->nama_pelajaran => $item->total_nilai];
            })->toArray();
            return [
                'nama' => $group->first()->nama,
                'listNilai' => $listNilai,
                'nisn' => $group->first()->nisn,
                'total' => number_format($group->sum('total_nilai'), 2),
            ];
        })->values();

        $sortedResults = $transformedResults->sortByDesc('total')->values();
        return response()->json($sortedResults);
    }

    public function getNilaiRT()
    {
        $results = DB::table('nilai')
            ->select(
                'nama',
                'nisn',
                'nama_pelajaran',
                DB::raw('
                    SUM(
                        skor
                    ) as total_nilai
                ')
            )
            ->where('materi_uji_id', 7)
            ->whereNotIn('nama_pelajaran', ["Pelajaran Khusus"])
            ->groupBy('nama', 'nisn', 'nama_pelajaran')
            ->orderBy('total_nilai', 'desc')
            ->get();

        $transformedResults = $results->groupBy('nama')->map(function ($group) {
            $listNilai = $group->mapWithKeys(function ($item) {
                return [$item->nama_pelajaran => number_format($item->total_nilai, 2)];
            })->toArray();

            return [
                'nama' => $group->first()->nama,
                'nilaiRt' => $listNilai,
                'nisn' => $group->first()->nisn,
            ];
        })->values();

        return response()->json($transformedResults);
    }
}

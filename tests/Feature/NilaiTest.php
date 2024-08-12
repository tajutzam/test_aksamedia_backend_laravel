<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NilaiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


    /** @test */
    public function test_get_nilai_st()
    {
        $response = $this->getJson('/api/nilaiST');
        $response->assertJsonStructure(
            [
                [
                    'nama',
                    'listNilai' => [
                        'Verbal',
                        'Penalaran',
                        'Figural',
                        'Kuantitatif'
                    ],
                    'nisn',
                    'total'
                ]
            ]
        );
    }


    public function test_get_nilai_rt()
    {
        $response = $this->getJson('/api/nilaiRT');
        $response->assertJsonStructure(
            [
                [
                    'nama',
                    'nilaiRt' => [
                        'SOCIAL',
                        'INVESTIGATIVE',
                        'CONVENTIONAL',
                        'REALISTIC',
                        'ARTISTIC',
                        'ENTERPRISING'
                    ],
                    'nisn'
                ]
            ]
        );
    }


}

<?php

namespace Database\Seeders;

use App\Models\Promo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        for ($i = 1; $i < 5; $i++) {
            DB::table('promos')->insert([
                'title' => 'Случайная акция №' . $i,
                'desc' => 'Это случайное описание к акции №' . $i . '. Скидка 5% на окрашивание и уходы для волос, 10%.',
                'link' => 'Ссылка у акции №' . $i,
                'link_text' => 'Записаться (№' . $i . ')',
                'type' => 'Тип акции  №' . $i,
                'position' => $i,
            ]);
            Promo::all()->getMedia('promo_pics')->delete();
            $promo = Promo::where('id', $i)->first();
            dd($promo);
            $seed_pic = public_path('media/media_seeders/460x280_' . rand(1, 2) . '.png');
            $promo->addMedia($seed_pic)->toMediaCollection('promo_pics');
        }

    }
}

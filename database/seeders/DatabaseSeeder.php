<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Promo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
//        Promo::all()->each()->delete();
        File::deleteDirectory(public_path('media/media_models'));

        for ($i = 1; $i < 7; $i++) {
            DB::table('promos')->insert([
                'title' => 'Случайная акция №' . $i,
                'desc' => 'Это случайное описание к акции №' . $i . '. Скидка 5% на окрашивание и уходы для волос, 10%.',
                'link' => 'Ссылка у акции №' . $i,
                'link_text' => 'Записаться (№' . $i . ')',
                'type' => 'Тип акции  №' . $i,
                'position' => $i,
            ]);

            $promo = Promo::where('id', $i)->first();
            $seed_pic = public_path('media/media_seeders/460x280_' . rand(1, 2) . '.png');
            $seed_pic_temp = public_path('media/media_seeders/temp_460x280_' . rand(1, 2) . '.png');
            File::copy($seed_pic, $seed_pic_temp);
            $promo->addMedia($seed_pic_temp)->toMediaCollection('promo_pics');
        }
    }
}

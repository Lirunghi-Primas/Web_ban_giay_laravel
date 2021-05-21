<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $men = Category::create([
            'name' => 'Nam',
            'slug' => 'nam'
        ]);

        $women = Category::create([
            'name' => 'Nữ',
            'slug' => 'nu'
        ]);

        $kid = Category::create([
            'name' => 'Trẻ em',
            'slug' => 'tre-em'
        ]);

        Category::create([
            'name' => 'Giày thể thao nam',
            'slug' => 'giay-the-thao-nam',
            'parent_id' => $men->id,
        ]);

        Category::create([
            'name' => 'Giày sandal nam',
            'slug' => 'giay-sandal-nam',
            'parent_id' => $men->id,
        ]);

        Category::create([
            'name' => 'Giày chạy bộ nam',
            'slug' => 'giay-chay-bo-nam',
            'parent_id' => $men->id,
        ]);

        Category::create([
            'name' => 'Giày thời trang nữ',
            'slug' => 'giay-thoi-trang-nu',
            'parent_id' => $women->id,
        ]);

        Category::create([
            'name' => 'Giày búp bê nữ',
            'slug' => 'giay-bup-be-nu',
            'parent_id' => $women->id,
        ]);

        Category::create([
            'name' => 'Dép nữ',
            'slug' => 'dep-nu',
            'parent_id' => $women->id,
        ]);

        Category::create([
            'name' => 'Giày tập đi trẻ em',
            'slug' => 'giay-tap-di-tre-em',
            'parent_id' => $kid->id,
        ]);

        Category::create([
            'name' => 'Giày thể thao trẻ em',
            'slug' => 'giay-the-thao-tre-em',
            'parent_id' => $kid->id,
        ]);

        Category::create([
            'name' => 'Dép trẻ em',
            'slug' => 'dep-tre-em',
            'parent_id' => $kid->id,
        ]);
    }
}

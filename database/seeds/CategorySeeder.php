<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cat = new Category();
        $cat->name = 'Uncategorized';
        $cat->slug = 'uncategorized';
        $cat->can_delete = false;
        $cat->save();
    }
}

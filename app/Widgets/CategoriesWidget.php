<?php

namespace App\Widgets;

use App\Widgets\Contract\ContractWidget;
use App\Category;


class CategoriesWidget implements ContractWidget
{
    public function execute()
    {
        $data = Category::all();
        return view('widgets::categories', [
            'data' => $data
            ]
        );
    }
}

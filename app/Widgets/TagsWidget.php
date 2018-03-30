<?php

namespace App\Widgets;

use App\Widgets\Contract\ContractWidget;
use App\Tag;

class TagsWidget implements ContractWidget
{
    public function execute()
    {
        $data = Tag::all();
        return view('widgets::tags', [
                'data' => $data
            ]
        );
    }
}

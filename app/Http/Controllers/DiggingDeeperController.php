<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DiggingDeeperController extends Controller
{

    public function collections()
    {
        $result =[];
        /**
         * @var \Illuminate\Database\Eloquent\Collection $eloquentCollection
         */

        $eloquentCollection = BlogPost::withTrashed()->get();

        //dd(__METHOD__, __FUNCTION__, $eloquentCollection, $eloquentCollection->toArray());

        $collection = collect($eloquentCollection->toArray());

        $result['where']['data'] = $collection
            ->where('category_id', 10)
            ->values()
           ->keyBy('id');

        $result['where']['count'] = $result['where']['data']->count();
        $result['where']['isEmpty'] = $result['where']['data']->isEmpty();
        $result['where']['isNotEmpty'] = $result['where']['data']->isNotEmpty();

        $result['map']['all'] = $collection->map(function (array $item){
            $newItem = new \stdClass();
            $newItem->item_id = $item['id'];
            $newItem->item_name = $item['title'];
            $newItem->exists = is_null($item['deleted_at']);

            return $newItem;
        });

        $result['map']['not_exists'] = $result['map']['all']->where('exists', '=', false);

        $collection->transform(function (array $item){
            $newItem = new \stdClass();
            $newItem->item_id = $item['id'];
            $newItem->item_name = $item['title'];
            $newItem->exists = is_null($item['deleted_at']);
            $newItem->created_at = Carbon::parse($item['created_at']);
            return $newItem;
        });

        $s1 = collect([5,3,1,77,8])->sort()->values();
        $s2 = $collection->sortBy('created_at');
        $s3 = $collection->sortByDesc('item_id');

        dd(compact('s1', 's2', 's3'));
    }
}

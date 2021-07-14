<?php


namespace App\Http\Controllers\Admin\Api;


use App\Models\Admin\CatalogAttribute;
use App\Models\Admin\CatalogProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CatalogProductController
{
    public function index(Request $request)
    {
        $search_term = $request->input('q');

        if ($search_term)
        {
            $results = CatalogProduct::where('title', 'LIKE', '%'.$search_term.'%')->paginate(10);
        }
        else
        {
            $results = CatalogProduct::paginate(10);
        }

        return $results;
    }

    public function show($id)
    {
        return CatalogProduct::find($id);
    }

    public function getAttributesAutocomplete(Request $request)
    {
        $search_term = $request->input('q');
        $keys        = $request->input('keys');

        $catalogAttribute = new CatalogAttribute();

        if ($keys && is_array($keys)) {
            $catalogAttribute = $catalogAttribute->whereIn('id', $keys);

        } elseif ($keys) {
            $catalogAttribute = $catalogAttribute->where('id', (int) $keys);
        }

        if ($search_term) {
            $catalogAttribute = $catalogAttribute->where('title', 'LIKE', '%' . $search_term . '%');
        }

        $results = $catalogAttribute->paginate(10);


        return $results;
    }
}

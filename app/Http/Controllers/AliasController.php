<?php

namespace App\Http\Controllers;

use App\Models\Alias;
use Illuminate\Http\Request;

class AliasController extends Controller
{
    /**
     * Handle the incoming request.
     * Return controller from aliases table by last item of path or 404
     *
     * @param \Illuminate\Http\Request $request
     * @return
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __invoke(Request $request, Alias $aliasModel)
    {
        $slug = $request->path();

        $parts = explode('/', $slug);

        $last = array_pop($parts);

        $aliasInfo = $aliasModel->where('slug',$last)->first();
        if ($aliasInfo) {
            $model = app($aliasInfo->model)::findOrFail($aliasInfo->model_id);

          return  (app()->make($aliasInfo->controller))->show($request, $model);
        } else {
            abort('404');
        }
    }
}

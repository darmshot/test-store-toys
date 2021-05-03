<?php


namespace App\Services;


use App\Models\Alias;
use App\Models\CatalogCategory;

class AliasService
{
    public function update($data)
    {
        if ($data['slug']) {
            Alias::updateOrCreate([
                'model'    => $data['model'],
                'model_id' => $data['model_id']
            ], [
                'slug'       => $data['slug'],
                'controller' => $data['controller'],
            ]);
        } else {
            Alias::where('model', $data['model'])->where('model_id', $data['model_id'])->delete();
        }
    }

    public function remove($data)
    {
        Alias::where('model', $data['model'])->where('model_id', $data['model_id'])->delete();
    }
}

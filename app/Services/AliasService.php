<?php


namespace App\Services;


use App\Models\Admin\Alias;
use Illuminate\Support\Str;

class AliasService
{
    private $attempts = 3;

    public function updateOrCreate($data)
    {
        if ($data['slug']) {
            $this->tryAddAlias($data);
        } else {
            $this->remove($data);
        }
    }

    public function remove($data)
    {
        Alias::where('model', $data['model'])->where('model_id', $data['model_id'])->delete();
    }

    private function tryAddAlias($data)
    {
        if ($this->attempts < 0) {
            throw new \ErrorException('error add slug to alias');
        }

        try {
            $this->attempts --;
            $this->makeUpdateOrCreateAlias($data);
            $this->updateModelSlug($data);

        } catch (\Exception $exception) {
            $this->setSlugPostfix($data);
            $this->tryAddAlias($data);
        }

    }

    private function setSlugPostfix(&$data)
    {
        preg_match('/-(\d)$/', $data['slug'], $matches);

        if (isset($matches[1])) {
            $newCounter = ++ $matches[1];
            $data['slug'] = str_replace($matches[0],'-'.$newCounter, $data['slug']);
        } else {
            $data['slug'] .= '-1';
        }
    }

    private function updateModelSlug($data)
    {
        $model      = app($data['model']);
        $item       = $model->find($data['model_id']);
        $item->slug = $data['slug'];
        $item->save();
    }

    private function makeUpdateOrCreateAlias($data)
    {
        Alias::updateOrCreate([
            'model'    => $data['model'],
            'model_id' => $data['model_id']
        ], [
            'slug'       => $data['slug'],
            'controller' => $data['controller'],
        ]);
    }
}

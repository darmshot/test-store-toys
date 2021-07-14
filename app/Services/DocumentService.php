<?php


namespace App\Services;


class DocumentService
{
    private $scriptVars = array();
    private $title = null;
    private $description = null;
    private $metas = array();

    public function addScriptVar(string $key, array $value)
    {
        $this->scriptVars[$key] = $value;
    }

    public function getScriptVars():string
    {
        return json_encode($this->scriptVars, JSON_UNESCAPED_UNICODE);
    }

    public function addMetas(string $name, string $content = '')
    {
        $this->metas[$name] = $content;
    }

    public function getMetas()
    {
        return $this->metas;
    }
    public function setTitle($value)
    {
        $this->title = $value;
    }

    public function getMetaTitle()
    {
        return $this->title ?? null;
    }

    public function setDescription($value)
    {
        $this->description = $value;
    }

    public function getDescription()
    {
        return $this->description ?? null;
    }

    public function setKeywords()
    {

    }
}

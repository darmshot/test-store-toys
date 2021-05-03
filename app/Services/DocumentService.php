<?php


namespace App\Services;


class DocumentService
{
    private $scriptVars = array();

    public function addScriptVar($key, array $value)
    {
        $this->scriptVars[$key] = json_encode($value,JSON_UNESCAPED_UNICODE);
    }

    public function getScriptVars()
    {
        return $this->scriptVars;
    }
}

<?php


namespace App\Services\Parsers\Contracts;


interface TemplateContract
{
    public function load(string $url, array $data = []): array;
}

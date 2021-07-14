<?php


namespace App\Services\Thumb\Contracts;


interface TemplateContract
{

    public function isMultiImage(): bool;

    public function setPath(string $path);

    public function getPlaceholder(): ?string;

    public function getSrc(): ?string;

    public function getSrcset(): ?string;

    public function getSizes(): ?string;

    public function getWidth(): ?string;

    public function getHeight(): ?string;

}

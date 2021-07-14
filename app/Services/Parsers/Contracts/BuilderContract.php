<?php


namespace App\Services\Parsers\Contracts;


interface BuilderContract
{
    public function getId(): ?int;

    public function getIdInsertOrUpdate(): ?int;

    public function setFields(array $fields): self;
}

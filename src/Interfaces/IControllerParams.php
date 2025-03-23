<?php

namespace DumpsterfireRouter\Interfaces;

interface IControllerParams
{
    public function setParams(array $params): self;
}
<?php

namespace DumpsterfireRouter\Interfaces;

use DumpsterfireComponents\PageComponent;

interface ControllerInterface
{
    public function getPage(): PageComponent;
}
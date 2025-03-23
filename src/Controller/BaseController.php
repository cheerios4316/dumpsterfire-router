<?php

namespace DumpsterfireRouter\Controller;

abstract class BaseController
{
    protected array $rawParams = [];
    protected function autoAssignParams(array $params): self
    {
        foreach ($params as $key => $value) {
            if(is_numeric($key)) {
                continue;
            }

            $this->rawParams[$key] = $value;

            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        return $this;
    }

    public function getRawParams(): array
    {
        return $this->rawParams;
    }
}
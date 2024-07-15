<?php

namespace BusinessRU\Open\Api\Requests;

class DataCommandFilterRequest implements \JsonSerializable
{
    public function __construct(
        private ?string $filter_date_create_from = null,
        private ?string $filter_date_create_to = null,
        private ?string $filter_date_update_from = null,
        private ?string $filter_date_update_to = null,
        private ?string $filter_date_result_from = null,
        private ?string $filter_date_result_to = null,
        private ?int    $page = null,
        private ?string $c_num = null,
    )
    {
    }

    public function jsonSerialize(): mixed
    {
        return array_filter(get_object_vars($this));
    }

    public function toArray()
    {
        return $this->jsonSerialize();
    }
}
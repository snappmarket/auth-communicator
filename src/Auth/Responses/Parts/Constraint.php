<?php

namespace SnappMarket\Auth\Responses\Parts;


class Constraint
{
    /**
     * @var string
     */
    protected $code;


    /**
     * @var string
     */
    protected $value;



    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }



    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }



    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }



    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}

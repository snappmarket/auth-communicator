<?php


namespace SnappMarket\Auth\Responses\Parts;


class Permission
{
    /**
     * @var int
     */
    protected $id;


    /**
     * @var string
     */
    protected $title;



    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }



    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }



    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }



    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    

}

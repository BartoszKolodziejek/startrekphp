<?php
/**
 * Created by PhpStorm.
 * User: barto
 * Date: 29.05.2018
 * Time: 22:44
 */

namespace App\Http\Middleware;


class Sector
{
    private $quadrant;
    private $type=".";
    private $X;
    private $Y;

    /**
     * Sector constructor.
     * @param $quadrant
     * @param $X
     * @param $Y
     */
    public function __construct($quadrant, $X, $Y)
    {
        $this->quadrant = $quadrant;
        $this->X = $X;
        $this->Y = $Y;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getQuadrant()
    {
        return $this->quadrant;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getX()
    {
        return $this->X;
    }

    /**
     * @return mixed
     */
    public function getY()
    {
        return $this->Y;
    }




}
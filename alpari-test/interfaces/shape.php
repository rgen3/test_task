<?php

namespace interfaces;

interface shape
{
    /**
     * Uses in child classes to draw an object
     *
     * @return mixed
     */
    public function draw();

    /**
     * Uses in calls to validate and compound shape
     *
     * @return mixed
     */
    public function create();

}
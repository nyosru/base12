<?php
namespace App\classes\common;

abstract class PDFGenerator
{
    protected $data_object;

    public function __construct($data_object)
    {
        $this->data_object=$data_object;
    }

    abstract public function generate();
}
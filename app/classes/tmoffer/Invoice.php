<?php
namespace App\classes\tmoffer;


use App\Tmoffer;

class Invoice
{
    private $tmoffer;
    private $installment;
    private $html;
    private $filename;

    public function __construct(Tmoffer $tmoffer,$installment,$html,$filename='')
    {
        $this->tmoffer=$tmoffer;
        $this->installment=$installment;
        $this->html=$html;
        $this->filename=$filename;
    }

    /**
     * @return mixed
     */
    public function getTmoffer()
    {
        return $this->tmoffer;
    }

    /**
     * @return mixed
     */
    public function getInstallment()
    {
        return $this->installment;
    }

    /**
     * @return mixed
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }


}
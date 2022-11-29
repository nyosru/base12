<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 8/25/20
 * Time: 6:01 PM
 */

namespace App\classes;
use App\Faq;
use App\Cartoon;

class FaqCartoon
{
    private $classname;

    public function __construct($classname)
    {
        $this->classname=$classname;
    }

    public function getClassname(){
        return 'App\\'.$this->classname;
    }

    public function getCategoryClassname(){
        return 'App\\'.$this->classname.'Category';
    }
}
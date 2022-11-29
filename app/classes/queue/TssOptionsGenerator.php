<?php
namespace App\classes\queue;


abstract class TssOptionsGenerator
{
    private function __construct()
    {
    }

    abstract public function get($status_id);

    public static function cipostatusTssOptionsGenerator(){
        return new CipostatusTssOptionsGenerator();
    }

    public static function globalStatusTssOptionsGenerator(){
        return new GlobalStatusTssOptionsGenerator();
    }
}
<?php
namespace App\classes\tsstranslator;

class TssContext implements \Iterator
{
    private $index=0;
    private $array_keys;


    /*
    %%%TM%%% = WORDMARK или <img src='logo'>
    %%%Country%%% = страна знака
    %%%TM_Office%%% = ведомство для знака
    %%%AppNo%%% = номер заявки
    %%%TM_URL_Office%%% = ссылка на знак на сайте ведоства
    %%%TM_URL_TMF%%% = ссылка на знак на юзер кабинет
    %%%TM_Filed_Date%%% = дата подачи в формате Dec 15, 2018
    %%%TM_Last_Status_Date%%% = дата последнего официального статуса в формате Dec 15, 2018
    %%%TM_Last_Status%%% = последний официальный статус
    */

    private $params = [
        'TM'=>['value' => '', 'description' => '','type'=>'text','format'=>''],
        'Country'=>['value' => '', 'description' => '','type'=>'text','format'=>''],
        'TM_Office'=>['value' => '', 'description' => '','type'=>'text','format'=>''],
        'AppNo'=>['value' => '', 'description' => '','type'=>'text','format'=>''],
        'TM_URL_Office'=>['value' => '', 'description' => '','type'=>'text','format'=>''],
        'TM_URL_TMF'=>['value' => '', 'description' => '','type'=>'text','format'=>''],
        'TM_Filed_Date'=>['value' => '', 'description' => '','type'=>'date','format'=>'MMM D, YYYY'],
        'TM_Last_Status_Date_Full'=>['value' => '', 'description' => '','type'=>'date','format'=>'MMMM D, YYYY'],
        'TM_Last_Status_Date'=>['value' => '', 'description' => '','type'=>'date','format'=>'MMM D, YYYY'],
        'TM_Last_Status'=>['value' => '', 'description' => '','type'=>'text','format'=>''],
        'RegAppNo'=>['value' => '', 'description' => '','type'=>'text','format'=>''],
        'TM_Reg_Date'=>['value' => '', 'description' => '','type'=>'date','format'=>'MMM D, YYYY'],
        'TM_Filed_Date_Full'=>['value' => '', 'description' => '','type'=>'date','format'=>'MMMM D, YYYY'],
        'TM_Reg_Date_Full'=>['value' => '', 'description' => '','type'=>'date','format'=>'MMMM D, YYYY'],
        'Today'=>['value' => '', 'description' => '','type'=>'date','format'=>'MMM D, YYYY'],
        'Today_Full'=>['value' => '', 'description' => '','type'=>'date','format'=>'MMMM D, YYYY'],
        'Today_MY'=>['value' => '', 'description' => '','type'=>'date','format'=>'MMMM of YYYY'],
        'TM_Filed_Date_MY'=>['value' => '', 'description' => '','type'=>'date','format'=>'MMMM of YYYY'],
        'TM_Reg_Date_MY'=>['value' => '', 'description' => '','type'=>'date','format'=>'MMMM of YYYY'],
        'TM_Last_Status_Date_MY'=>['value' => '', 'description' => '','type'=>'date','format'=>'MMMM of YYYY'],
        'Client_Email'=>['value' => '', 'description' => '','type'=>'text','format'=>''],
        'Client_Phone'=>['value' => '', 'description' => '','type'=>'text','format'=>''],
        'Client_FirstName'=>['value' => '', 'description' => '','type'=>'text','format'=>''],
        'Client_LastName'=>['value' => '', 'description' => '','type'=>'text','format'=>''],
        'TM_Owner'=>['value' => '', 'description' => '','type'=>'text','format'=>''],
        'G_and_S'=>['value' => '', 'description' => '','type'=>'text','format'=>''],
        'G_or_S'=>['value' => '', 'description' => '','type'=>'text','format'=>''],

        'TM_TMF_Package'=>['value' => '', 'description' => '','type'=>'text','format'=>''],
        'TM_TMF_Package_IMG'=>['value' => '', 'description' => '','type'=>'text','format'=>''],
        'TM_Searchreport_URL'=>['value' => '', 'description' => '','type'=>'text','format'=>''],
        'TM_Searchreport_Code'=>['value' => '', 'description' => '','type'=>'text','format'=>''],
        'TM_TMF_Guarantee'=>['value' => '', 'description' => '','type'=>'text','format'=>''],
        'TM_TMF_Guarantee_IMG'=>['value' => '', 'description' => '','type'=>'text','format'=>''],
        'tmf-satisfaction-widget'=>['value'=>'','description'=>'','type'=>'text','format'=>'']
    ];

    public function getParams(){
        return $this->params;
    }

    public function setValue($key,$value){
        if(isset($this->params[$key])) {
            $this->params[$key]['value'] = $value;
            $this->array_keys=array_keys($this->params);
        }
    }

    public function getValue($key){
        if(isset($this->params[$key]))
            return $this->params[$key];
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->params[$this->array_keys[$this->index]];
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->index++;
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->array_keys[$this->index];
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return ($this->index<count($this->array_keys));
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->index=0;
    }
}
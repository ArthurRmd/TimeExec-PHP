<?php

class TimeExec {

    public $arrayTime = [];
    public $time;


    public function start()
    {
        $this->time = microtime(true);
    }

    public function event()
    {
       array_push( $this->arrayTime, (microtime(true) - $this->time) );         
    }

    public function stop()
    {
        $this->event();
        foreach ($this->arrayTime as $key => $value) {
            echo $this->arrayTime[$key] . '<br>';
        }       
    }
    
}
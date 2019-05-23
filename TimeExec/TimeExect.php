<?php


class TimeExec {

    public $arrayTime = [];
    public $time;


    public function start() : void
    {
        $this->time = microtime(true);
    }

    public function event($line = null) : void
    {
        $event = [
            'microSecond' => microtime(true),
            'line' => $line
        ];
        array_push( $this->arrayTime, $event  );         
    }

    public function stop($line = null) : array
    {
        $this->event($line);
        $max = ($this->arrayTime[count($this->arrayTime) - 1]['microSecond']  - $this->time )/100;

        foreach ($this->arrayTime as $key => $value) {
            $this->arrayTime[$key]['microSecond'] = $this->arrayTime[$key]['microSecond'] - $this->time;
            $this->arrayTime[$key]['microSecondSinceLastEvent'] = $key ?  $this->arrayTime[$key]['microSecond'] - $this->arrayTime[$key - 1]['microSecond'] : $this->arrayTime[$key]['microSecond']; 
            $this->arrayTime[$key]['timeFormat'] =  $this->convertTime($this->arrayTime[$key]['microSecond']);
            $this->arrayTime[$key]['sinceLastEvent'] = $this->convertTime(  $this->arrayTime[$key]['microSecondSinceLastEvent'] ); 
            $this->arrayTime[$key]['pourcent'] = $this->convertPourcent($this->arrayTime[$key]['microSecondSinceLastEvent'] / $max) ;
        }
       
        dump($this->arrayTime);
        return $this->arrayTime;
    }

     public function convertTime( $time) : string
    {
        $time =  number_format($time, 6, '.', '');
        
        if ( $time < 0.0000999){
            $time =  strval( $time * 1000000).'µs';
        } elseif ( $time < 1) {
            $time = number_format($time * 10000, 2, '.','');
            $time = strval($time) .'ms';
        } else {
            $time = number_format($time , 2, '.','');
            $time = strval($time) .'s';
        }
        
        return $time;
    }


    public function convertPourcent($nb)
    {
        return number_format($nb, 2, '.', '').'%';
    }

    public function func( Closure $func) : void
    {
        $this->start();
        $func();
        $this->stop();
    }


    public function sleep( $nb) : void 
    {
        usleep(1000000 * $nb );
    }


    
}
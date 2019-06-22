<?php

 /**
  * @author Arthur Remond <arthur.remond@protonmail.com>
  * @license MIT
  * @version 1.0.0
  */

class TimeExec {

    public static $arrayTime = [];
    public static $time;


    public static function start() : void
    {
        self::$time = microtime(true);
    }

    public static function event($line = null) : void
    {
        $event = [
            'microSecond' => microtime(true),
            'line' => $line
        ];
        array_push( self::$arrayTime, $event  );         
    }

    public static function stop($line = null) : array
    {
        self::event($line);
        $max = (self::$arrayTime[count(self::$arrayTime) - 1]['microSecond']  - self::$time )/100;

        foreach (self::$arrayTime as $key => $value) {
            self::$arrayTime[$key]['microSecond'] = self::$arrayTime[$key]['microSecond'] - self::$time;
            self::$arrayTime[$key]['microSecondSinceLastEvent'] = $key ?  self::$arrayTime[$key]['microSecond'] - self::$arrayTime[$key - 1]['microSecond'] : self::$arrayTime[$key]['microSecond']; 
            self::$arrayTime[$key]['timeFormat'] =  self::convertTime(self::$arrayTime[$key]['microSecond']);
            self::$arrayTime[$key]['sinceLastEvent'] = self::convertTime(  self::$arrayTime[$key]['microSecondSinceLastEvent'] ); 
            self::$arrayTime[$key]['pourcent'] = self::convertPourcent(self::$arrayTime[$key]['microSecondSinceLastEvent'] / $max) ;
        }
       
        self::show(self::$arrayTime);
        return self::$arrayTime;
    }

     public static function convertTime( $time) : string
    {
        $time =  number_format($time, 6, '.', '');
        
        if ( $time < 0.0000999){
            $time =  strval( $time * 1000000).'µs';
        } elseif ( $time < 1) {
            $time = number_format($time * 1000, 2, '.','');
            $time = strval($time) .'ms';
        } else {
            $time = number_format($time , 2, '.','');
            $time = strval($time) .'s';
        }
        
        return $time;
    }


    public  static function convertPourcent($nb)
    {
        return number_format($nb, 2, '.', '').'%';
    }

    public static function func( Closure $func) : void
    {
        self::start();
        $func();
        self::stop();
    }


    public static function sleep( $nb) : void 
    {
        usleep(1000000 * $nb );
    }


    
    public static function show($array) : void
    {
         $html = '<table> 
                 <tr>
                     <th> Line </th>
                     <th>  Time </th>
                     <th>  Time since last event </th>
                     <th>  Pourcent </th>
                 </tr>';

        $colored = false;
         foreach (self::$arrayTime as $key => $value) {
      
            $html .= '<tr ';
            $html .= $colored ? "class='colored' >" : ">";
            $colored = $colored ? false : true;
            $html .= '<td class="line">'. self::$arrayTime[$key]['line']  .'</td>';
            $html .= '<td>'. self::$arrayTime[$key]['timeFormat']  .'</td>';
            $html .= '<td>'.  self::$arrayTime[$key]['sinceLastEvent'] .'</td>';
            $html .= '<td>'. self::$arrayTime[$key]['pourcent']  .'</td>';
            $html .='</tr>'; 
        
        } 

        echo  $html .'</table> <link href="https://fonts.googleapis.com/css?family=Karla&display=swap" rel="stylesheet">';

   
      

      echo "<style>  
      table{
          border-collapse: collapse;
      }

      .colored {
        background-color: rgb(240,240,240);
      }

      td, th{   
          border: 1.5px solid black;
          padding: 12px;
          font-family: 'Karla', sans-serif;
      } 

      th {
          background-color: rgb(165, 165, 165);
      }

      .line {
       font-weight: 600; 
      }
      
      </style>";
    }


    
}
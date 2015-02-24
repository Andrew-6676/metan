<?php
/*
    класс для засекания времени
*/
class DTimer
{
    protected static $startTime;
    protected static $points = array();

    public static function run()
    {
        self::$startTime = microtime(true);
    }

    public static function log($message='')
    {
        if (self::$startTime === null)
            self::run();

        self::$points[] = array('message'=>$message, 'time'=>sprintf('%0.4f', microtime(true) - self::$startTime));
    }

    public static function show()
    {
        $oldtime = 0;

        echo '
            <table id="time_table">
             <tr>
                <th></th>
                <th>Время от <br>прошолй метки</th>
                <th>Общее время</th>
            </tr>
        ';

        foreach(self::$points as $item){

            $message = $item['message'];
            $time = $item['time'] * 1;
            $diff = ($item['time'] - $oldtime) * 1;

            echo "
                <tr>
                    <td>{$message}</td>
                    <td style='text-align:right; width:50px'>{$diff} c</td>
                    <td style='text-align:right; width:50px''>{$time} c</td>
                </tr>
            ";

            $oldtime = $item['time'];
        };
        echo "</table>\n";
    }
}
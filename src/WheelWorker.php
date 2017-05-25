<?php
/**
 * Created by PhpStorm.
 * User: evolution
 * Date: 17-5-23
 * Time: 下午2:21
 */

namespace Evolution\WheelTimer;


class WheelWorker extends \Thread {
    public $wheel;
    public $workerpool;

    public function __construct($wheel,$workerpool)
    {
        $this->wheel = $wheel;
        $this->workerpool = $workerpool;
    }

    public function show($id)
    {
        echo "\n 消费者　threadid is {$id}\n　tick=".$this->wheel->current_tick."\r\n";
    }

    function run(){
        try{
            while (1){
                $this->wheel->tickIncr();
                $params = $this->wheel->get();
                print_r($params);
                $this->workerpool->dispatch($params);
                sleep($this->wheel->tic_interval);
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }finally{
            echo "end\n";
        }
    }
}

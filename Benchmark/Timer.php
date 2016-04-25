<?php

class Benchmark_Timer
{
    protected $start    = 0;
    protected $time     = 0;
    protected $is_pause = true;

    public function start()
    {
        $this->time  = 0;
        $this->pause = false;
        $this->start = microtime(true);
    }

    public function getTime()
    {
        if ($this->is_pause) {
            return $this->time;
        } else {
            return $this->time + (microtime(true) - $this->start);
        }
    }

    public function pause()
    {
        $this->time += (microtime(true) - $this->start);
        $this->is_pause = true;
    }

    public function resume()
    {
        $this->is_pause = false;
        $this->start = microtime(true);
    }

    public function stop()
    {
        return $this->pause();
    }
}
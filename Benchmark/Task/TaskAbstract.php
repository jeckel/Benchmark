<?php

abstract class Benchmark_Task_TaskAbstract implements Benchmark_Task_Interface
{
    protected $config;
    protected $timer;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function setTimer(Benchmark_Timer $timer)
    {
        $this->timer = $timer;
    }

    public function getConfig()
    {
        return $this->config;
    }
}
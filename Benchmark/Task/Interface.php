<?php
/**
 * Benchmark task interface
 * All task should implement this interface to be able to be benchmarked the sameway
 */
interface Benchmark_Task_Interface
{
    public function __construct(array $config);
    public function getConfig();
    public function setTimer(Benchmark_Timer $timer);
    public function init();
    public function process();
}


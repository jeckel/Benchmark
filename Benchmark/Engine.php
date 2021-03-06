<?php

/**
 * Benchmark engine
 */
class Benchmark_Engine
{
    protected $config;

    protected $engine;

    protected $file;

    protected $timer;

    public function __construct($config, $engine)
    {
        $this->config = $config;
        $this->engine = $engine;
        $this->timer  = new Benchmark_Timer;
    }

    protected function init()
    {
        $log_filename = sprintf($this->config['log_file_mask'], $this->engine);
        $this->file = fopen($log_filename, 'w');
        $this->log("Start loading data into table");
    }

    protected function close()
    {
        $this->log("Table loaded successfully");
        fclose($this->file);
    }

    protected function log($text)
    {
        fwrite($this->file, $text . "\n");
    }

    public function process(Benchmark_Task_Interface $task)
    {
        $this->init();

        $task->setTimer($this->timer);
        $task->init();

        $task_config = $task->getConfig();
        $nb_process = isset($task_config['nb_process']) ? $task_config['nb_process'] : $this->config['dflt_nb_process'];

        for ($i = 0; $i <= $nb_process; $i++) {

            $task->process();

            if ($i % $this->config['dflt_nb_process_offset_log'] == 0) {
                $this->log(sprintf("%01.2f : %d lines inserted", $this->timer->getTime(), $i));
            }
        }

        $this->log(sprintf('Average time per row : %01.6f seconds', $this->timer->getTime() / $i));

        $this->close();
    }
}

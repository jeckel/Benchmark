<?php
/**
 * Benchmark script
 *
 * @author Julien MERCIER <julien@tvty.tv<
 */

// Load configuration file
$config = include 'config/config.global.php';
if (is_file('config/config.local.php')) {
    $config = array_replace_recursive($config, include 'config/config.local.php');
}

var_dump($config); die;

/**
 * Autoload
 */
function __autoload($class_name) {
    include str_replace('_', DIRECTORY_SEPARATOR, $class_name) . '.php';
}


// Check entry parameters
if (count($argv) == 1) {
    die("Argument missing, you need to specify one of the task to run\n");
}


$taskName = strtolower($argv[1]);
if (! isset($config['tasks'][$taskName])) {
    die(
        sprintf(
            "Engine '%s' unknown, please select one the known Engine : %s\n",
            $taskName,
            implode(", ", array_keys($config['tasks']))
        )
    );
}


echo "Instanciate engine...\n";
$benchmark = new Benchmark_Engine($config['engine'], $taskName);
$task_classname = $config['tasks'][$taskName]['task_classname'];
$task = new $task_classname($config['tasks'][$taskName]);

echo "Starting benchmark of task '$taskName'.\n";
$benchmark->process($task);
echo "Benchmark ended\n";
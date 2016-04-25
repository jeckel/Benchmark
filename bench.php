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

/**
 * Autoload
 */
function __autoload($class_name) {
    include str_replace('_', DIRECTORY_SEPARATOR, $class_name) . '.php';
}


// Check entry parameters
if (count($argv) == 1) {
    die(sprintf("Argument missing, you need to specify one of the tasks to run (%s)\n", implode(", ", array_keys($config['tasks']))));
}

if ($argv[1] == '--all') {
    echo "Process ALL tasks \n";
    foreach($config['tasks'] as $taskName => $taskConfig) {
        processTask($taskName, $config);
    }
    echo "Finish processing all tasks\n";
} else {

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
    processTask($taskName, $config);
}

function processTask($taskName, $config)
{
    echo "Instanciate engine...\n";
    $benchmark = new Benchmark_Engine($config['engine'], $taskName);
    $task_classname = $config['tasks'][$taskName]['task_classname'];
    $task = new $task_classname($config['tasks'][$taskName]);

    echo "Starting benchmark of task '$taskName'.\n";
    $benchmark->process($task);
    echo "Processing of task'$taskName' ended\n";
}
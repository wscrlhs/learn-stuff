<?php
/*
 * 僵尸进程
 * 僵尸进程是指父进程在fork出子进程，而后子进程在结束后，父进程并没有调用wait或者waitpid等完成对其清理善后工作，导致该子进程进程ID、文件描述符等依然保留在系统中，极大浪费了系统资源。
 */
$pid = pcntl_fork();
if( $pid > 0 ){
    // 下面这个函数可以更改php进程的名称
    cli_set_process_title('php father process');
    // 让主进程休息60秒钟
    sleep(60);
} else if( 0 == $pid ) {
    cli_set_process_title('php child process');
    // 让子进程休息10秒钟，但是进程结束后，父进程不对子进程做任何处理工作，这样这个子进程就会变成僵尸进程
    sleep(10);
} else {
    exit('fork error.'.PHP_EOL);
}

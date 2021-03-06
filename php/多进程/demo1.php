<?php

/*
 *
 * 在php中我们使用pcntl_fork()来创建多进程。fork出来新进程则成为子进程，原进程则成为父进程，子进程拥有父进程的副本。这里要注意：
 * 
 * 子进程与父进程共享程序正文段
 * 子进程拥有父进程的数据空间和堆、栈的副本，注意是副本，不是共享
 * 父进程和子进程将继续执行fork之后的程序代码
 * fork之后，是父进程先执行还是子进程先执行无法确认，取决于系统调度（取决于信仰）
 */

$pid = pcntl_fork();
if( $pid > 0 ){
    echo "我是父亲".PHP_EOL;
} else if( 0 == $pid ) {
    echo "我是儿子".PHP_EOL;
} else {
    echo "fork失败".PHP_EOL;
}




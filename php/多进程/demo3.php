<?php
for( $i = 1; $i <= 3 ; $i++ ){
    $pid = pcntl_fork();
    if( $pid > 0 ){
        echo '父亲pid:'.$pid.PHP_EOL;
        // do nothing ...
    } else if( 0 == $pid ){
        echo "儿子".PHP_EOL;
    }
}

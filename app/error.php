<?php

/**
 * Show error
 */
map(404, function ($code, $msg = '') {
    print phtml('error', [
        'code' => $code,
        'msg' => $msg
    ]);
});

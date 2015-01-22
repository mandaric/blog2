<?php

/**
 * Show error
 */
map([404, 500], function ($code, $msg = '') {
    print phtml('error', [
        'code' => $code,
        'msg' => $msg
    ]);
});

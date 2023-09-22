<?php
function reverseMail(string $text): string {
    return preg_replace_callback(
        '/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/',
        /**
         * @param string[][]
         * @return string
         */
        function ($mailAddressInText) {
            return strrev($mailAddressInText[0]);
        },
        $text,
    );
}

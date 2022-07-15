<?php

namespace xdeanboy\Services;

use xdeanboy\Models\Users\User;

class EmailSender
{
    /**
     * @param string $emailReceiver
     * @param string $title
     * @param string $templateMessage
     * @param array $params
     * @return void
     */
    public static function send(
        string $emailReceiver,
        string $title,
        string $templateMessage,
        array $params = []
    ): void
    {
        extract($params);

        ob_start();
        include __DIR__ . '/../../../templates/email/' . $templateMessage;
        $buffer = ob_get_contents();
        ob_end_clean();

        mail($emailReceiver, $title, $buffer, 'Content-Type: text/html; charset=utf8');
    }
}
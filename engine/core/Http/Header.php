<?php

namespace Engine\Core\Http;

class Header
{
    /**
     * Check to see if the headers have been sent to the browser.
     *
     * @param string $header Check to see if a particular header has been sent.
     * @return bool
     */
    public static function sent(string $header = ''): bool
    {
        if ('' === $header) {
            return headers_sent();
        } else {

            $header = strtolower($header);

            foreach (static::all() as $sent) {
                $name = explode(':', $sent);
                $name = strtolower($name[0]);

                if ($name === $header) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Get the headers that have been sent to the browser.
     *
     * @return array
     */
    public static function all(): array
    {
        return headers_list();
    }

    /**
     * Sends a raw HTTP header.
     *
     * @param string $header The header to send.
     * @param string $data The data to send to the header.
     * @param bool $replace Replace similar headers that have been sent.
     * @return void
     */
    public static function send(string $header, string $data = '', bool $replace = true): void
    {
        header($header . (('' !== $data) ? ':' . $data : ''), $replace);
    }

    /**
     * Remove a previously set header.
     *
     * @param string $header The header to remove.
     * @return void
     */
    public static function remove(string $header): void
    {
        header_remove($header);
    }
}

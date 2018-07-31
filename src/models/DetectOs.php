<?php
/**
 * {description}
 *
 * @author
 */

namespace Model;

class DetectOs
{
    /**
     * @return string
     */
    protected function getUserOs(): string
    {
        if (!isset($_SERVER['HTTP_USER_AGENT'])) {
            return '';
        }

        $userAgent = $_SERVER['HTTP_USER_AGENT'];

        if (preg_match('/macintosh|mac os x/i', $userAgent)) {
            return 'MacOS';
        }

        return '';
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function is(string $key): bool
    {
        return $key === $this->getUserOs();
    }
}
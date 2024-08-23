<?php
declare(strict_types=1);

namespace ArmorCMS\Web\Enum;

class FlashMessageEnum
{
    /**
     * @var string
     */
    const DONE = 'done';
    
    /**
     * @var string
     */
    const ERROR = 'error';
    
    /**
     * @var string
     */
    const INFO = 'info';
    
    /**
     * @var array
     */
    protected static $labels = [
        self::DONE => self::DONE,
        self::ERROR => self::ERROR,
        self::INFO => self::INFO,
    ];
}

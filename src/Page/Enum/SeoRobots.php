<?php
declare( strict_types=1 );

namespace ArmorCMS\Page\Enum;

enum SeoRobots: string
{
    case ALL = 'all';
    case NOINDEX = 'noindex';
    case NOFOLLOW = 'nofollow';
    case NOARCHIVE = 'noarchive';
    case NONE = 'none';
    case NOSITELINKSSEARCHBOX = 'nositelinkssearchbox';
    case NOSNIPPET = 'nosnippet';
    case INDEXIFEMBEDDED = 'indexifembedded';
}

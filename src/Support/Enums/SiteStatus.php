<?php

namespace Selene\Modules\SitesModule\Support\Enums;

use MyCLabs\Enum\Enum;

/**
 * Class SiteStatus
 * @package Selene\Modules\SitesModule\Support\Enums
 */
class SiteStatus extends Enum
{
    protected const PUBLISHED = 'publish';
    protected const DRAFT = 'draft';
    protected const ARCHIVE = 'archive';
}

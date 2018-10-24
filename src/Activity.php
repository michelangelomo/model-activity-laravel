<?php

namespace Michelangelo\ModelActivity;

abstract class Activity {

    public const CREATED = 1;

    public const UPDATED = 2;

    public const DELETED = 3;

    public const RESTORED = 4;

    public const FORCE_DELETED = 5;

    public static $status = [
        self::CREATED,
        self::UPDATED,
        self::DELETED,
        self::RESTORED,
        self::FORCE_DELETED
    ];

    public static function inStatus(int $type) : bool {
        return (in_array($type, self::$status));
    }

}
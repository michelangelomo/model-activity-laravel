<?php

namespace Michelangelo\ModelActivity;

abstract class Activity {

    public const CREATED = 1;

    public const UPDATED = 2;

    public const DELETED = 3;

    public const RESTORED = 4;

    public const FORCE_DELETED = 5;

}
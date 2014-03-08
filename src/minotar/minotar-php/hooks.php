<?php

/**
 * Default hooks for the IoC container. These are loaded on its first boot.
 */
return array(
    'Minotar\\MinotarAdapterInterface' => 'Minotar\\MinotarCacheAdapter'
);

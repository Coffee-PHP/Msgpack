<?php

/**
 * MsgpackComponentRegistrarTest.php
 *
 * Copyright 2020 Danny Damsky
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package coffeephp\msgpack
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2020-08-31
 */

declare (strict_types=1);

namespace CoffeePhp\Msgpack\Test\Integration;


use CoffeePhp\ComponentRegistry\ComponentRegistry;
use CoffeePhp\Di\Container;
use CoffeePhp\Msgpack\Contract\MsgpackTranslatorInterface;
use CoffeePhp\Msgpack\Integration\MsgpackComponentRegistrar;
use CoffeePhp\Msgpack\MsgpackTranslator;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

/**
 * Class MsgpackComponentRegistrarTest
 * @package coffeephp\msgpack
 * @since 2020-08-31
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @see MsgpackComponentRegistrar
 */
final class MsgpackComponentRegistrarTest extends TestCase
{
    /**
     * @see MsgpackComponentRegistrar::register()
     */
    public function testRegister(): void
    {
        $di = new Container();
        $registry = new ComponentRegistry($di);
        $registry->register(MsgpackComponentRegistrar::class);

        assertTrue(
            $di->has(MsgpackTranslatorInterface::class)
        );
        assertTrue(
            $di->has(MsgpackTranslator::class)
        );

        assertInstanceOf(
            MsgpackTranslator::class,
            $di->get(MsgpackTranslator::class)
        );

        assertSame(
            $di->get(MsgpackTranslator::class),
            $di->get(MsgpackTranslatorInterface::class)
        );
    }
}

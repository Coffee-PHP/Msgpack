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


use CoffeePhp\Binary\Contract\BinaryTranslatorInterface;
use CoffeePhp\Binary\Integration\BinaryComponentRegistrar;
use CoffeePhp\Di\Container;
use CoffeePhp\Edi\Contract\EdiArrayTranslatorInterface;
use CoffeePhp\Edi\Contract\EdiExtendedArrayTranslatorInterface;
use CoffeePhp\Edi\Contract\EdiObjectTranslatorInterface;
use CoffeePhp\Edi\Contract\EdiTranslatorInterface;
use CoffeePhp\Msgpack\Contract\MsgpackTranslatorInterface;
use CoffeePhp\Msgpack\MsgpackTranslator;
use CoffeePhp\Msgpack\Integration\MsgpackComponentRegistrar;
use CoffeePhp\Serialize\Contract\SerializerInterface;
use CoffeePhp\Unserialize\Contract\UnserializerInterface;
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
    public function testRegisterWithoutDependencies(): void
    {
        $di = new Container();
        $registrar = new MsgpackComponentRegistrar();
        $registrar->register($di);

        assertTrue(
            $di->has(SerializerInterface::class)
        );
        assertTrue(
            $di->has(UnserializerInterface::class)
        );
        assertTrue(
            $di->has(EdiArrayTranslatorInterface::class)
        );
        assertTrue(
            $di->has(EdiExtendedArrayTranslatorInterface::class)
        );
        assertTrue(
            $di->has(EdiObjectTranslatorInterface::class)
        );
        assertTrue(
            $di->has(EdiTranslatorInterface::class)
        );
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
        assertSame(
            $di->get(MsgpackTranslatorInterface::class),
            $di->get(EdiTranslatorInterface::class)
        );
        assertSame(
            $di->get(MsgpackTranslatorInterface::class),
            $di->get(EdiObjectTranslatorInterface::class)
        );
        assertSame(
            $di->get(MsgpackTranslatorInterface::class),
            $di->get(EdiExtendedArrayTranslatorInterface::class)
        );
        assertSame(
            $di->get(MsgpackTranslatorInterface::class),
            $di->get(EdiArrayTranslatorInterface::class)
        );
        assertSame(
            $di->get(MsgpackTranslatorInterface::class),
            $di->get(SerializerInterface::class)
        );
        assertSame(
            $di->get(MsgpackTranslatorInterface::class),
            $di->get(UnserializerInterface::class)
        );
    }

    /**
     * @see BinaryComponentRegistrar::register()
     * @see MsgpackComponentRegistrar::register()
     */
    public function testRegisterWithDependencies(): void
    {
        $di = new Container();
        $binaryRegistrar = new BinaryComponentRegistrar();
        $registrar = new MsgpackComponentRegistrar();
        $binaryRegistrar->register($di);
        $registrar->register($di);

        assertTrue(
            $di->has(SerializerInterface::class)
        );
        assertTrue(
            $di->has(UnserializerInterface::class)
        );
        assertTrue(
            $di->has(EdiArrayTranslatorInterface::class)
        );
        assertTrue(
            $di->has(EdiExtendedArrayTranslatorInterface::class)
        );
        assertTrue(
            $di->has(EdiObjectTranslatorInterface::class)
        );
        assertTrue(
            $di->has(EdiTranslatorInterface::class)
        );
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
        assertSame(
            $di->get(BinaryTranslatorInterface::class),
            $di->get(EdiTranslatorInterface::class)
        );
        assertSame(
            $di->get(BinaryTranslatorInterface::class),
            $di->get(EdiObjectTranslatorInterface::class)
        );
        assertSame(
            $di->get(BinaryTranslatorInterface::class),
            $di->get(EdiExtendedArrayTranslatorInterface::class)
        );
        assertSame(
            $di->get(BinaryTranslatorInterface::class),
            $di->get(EdiArrayTranslatorInterface::class)
        );
        assertSame(
            $di->get(BinaryTranslatorInterface::class),
            $di->get(SerializerInterface::class)
        );
        assertSame(
            $di->get(BinaryTranslatorInterface::class),
            $di->get(UnserializerInterface::class)
        );
    }
}

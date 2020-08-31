<?php

/**
 * MsgpackTranslatorTest.php
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
 * @since 2020-08-27
 */

declare(strict_types=1);

namespace CoffeePhp\Msgpack\Test\Unit;


use CoffeePhp\Msgpack\MsgpackTranslator;
use PHPUnit\Framework\TestCase;
use stdClass;

use function msgpack_pack;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertSame;

/**
 * Class MsgpackTranslatorTest
 * @package coffeephp\msgpack
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2020-08-27
 * @see MsgpackTranslator
 */
final class MsgpackTranslatorTest extends TestCase
{
    /**
     * @see MsgpackTranslator::serializeArray()
     * @see MsgpackTranslator::unserializeArray()
     */
    public function testSerializeAndUnserializeArray(): void
    {
        $array = [
            'a' => 'b',
            'c' => 2,
            'd' => true,
            'e' => null,
            null => 2,
            2 => null
        ];

        $instance = new MsgpackTranslator();

        $serialized = $instance->serializeArray($array);

        assertSame(
            msgpack_pack($array),
            $serialized
        );

        $unserialized = $instance->unserializeArray($serialized);

        assertSame(
            $array,
            $unserialized
        );
    }

    /**
     * @see MsgpackTranslator::serializeObject()
     * @see MsgpackTranslator::unserializeObject()
     */
    public function testSerializeAndUnserializeClass(): void
    {
        $class = new stdClass();
        $class->a = 'b';
        $class->c = 2;
        $class->d = true;
        $class->e = null;
        $class->null = 2;

        $instance = new MsgpackTranslator();

        $serialized = $instance->serializeObject($class);

        assertSame(
            msgpack_pack($class),
            $serialized
        );

        $unserialized = $instance->unserializeObject($serialized);

        assertEquals(
            $class,
            $unserialized
        );
    }
}

<?php

/**
 * MsgpackTranslator.php
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

namespace CoffeePhp\Msgpack;

use CoffeePhp\Msgpack\Contract\MsgpackTranslatorInterface;
use CoffeePhp\Msgpack\Exception\MsgpackSerializeException;
use CoffeePhp\Msgpack\Exception\MsgpackUnserializeException;
use Throwable;

use function msgpack_pack;
use function msgpack_unpack;

/**
 * Class MsgpackTranslator
 * @package coffeephp\msgpack
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2020-08-27
 */
final class MsgpackTranslator implements MsgpackTranslatorInterface
{

    /**
     * @inheritDoc
     * @psalm-suppress MixedReturnType, MixedInferredReturnType, MixedReturnStatement
     */
    public function serializeArray(array $array): string
    {
        try {
            return msgpack_pack($array);
        } catch (Throwable $e) {
            throw new MsgpackSerializeException($e->getMessage(), (int)$e->getCode(), $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function unserializeArray(string $string): array
    {
        try {
            return (array)msgpack_unpack($string);
        } catch (Throwable $e) {
            throw new MsgpackUnserializeException($e->getMessage(), (int)$e->getCode(), $e);
        }
    }

    /**
     * @inheritDoc
     * @psalm-suppress MixedReturnType, MixedInferredReturnType, MixedReturnStatement
     */
    public function serializeObject(object $object): string
    {
        try {
            return msgpack_pack($object);
        } catch (Throwable $e) {
            throw new MsgpackSerializeException($e->getMessage(), (int)$e->getCode(), $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function unserializeObject(string $string): object
    {
        try {
            return (object)msgpack_unpack($string);
        } catch (Throwable $e) {
            throw new MsgpackUnserializeException($e->getMessage(), (int)$e->getCode(), $e);
        }
    }
}

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


use CoffeePhp\Binary\Exception\BinaryUnserializeException;
use CoffeePhp\Msgpack\Contract\MsgpackTranslatorInterface;
use CoffeePhp\Msgpack\Exception\MsgpackSerializeException;
use CoffeePhp\Msgpack\Exception\MsgpackUnserializeException;
use Throwable;

use function get_class;
use function is_array;
use function is_string;
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
     */
    public function serializeArray(array $array): string
    {
        try {
            $serialized = msgpack_pack($array);
            if (!is_string($serialized)) {
                throw new MsgpackSerializeException(
                    'Data returned from array is not a msgpack string.'
                );
            }
            return $serialized;
        } catch (MsgpackSerializeException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new MsgpackSerializeException(
                "Failed to serialize data: {$e->getMessage()}",
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function unserializeArray(string $string): array
    {
        try {
            $unserialized = msgpack_unpack($string);
            if (!is_array($unserialized)) {
                throw new MsgpackUnserializeException(
                    "Data returned from msgpack string is not an array ; String: $string"
                );
            }
            return $unserialized;
        } catch (MsgpackUnserializeException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new MsgpackUnserializeException(
                "Failed to unserialize string: $string ; Error: {$e->getMessage()}",
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function serializeObject(object $class): string
    {
        try {
            $serialized = msgpack_pack($class);
            if (!is_string($serialized)) {
                $className = get_class($class);
                throw new MsgpackSerializeException(
                    "Data returned from class is not a binary string: $className"
                );
            }
            return $serialized;
        } catch (MsgpackSerializeException $e) {
            throw $e;
        } catch (Throwable $e) {
            $className = get_class($class);
            throw new MsgpackSerializeException(
                "Failed to serialize class: $className ; Error: {$e->getMessage()}",
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function unserializeObject(string $string): object
    {
        try {
            $unserialized = msgpack_unpack($string);
            if (!is_object($unserialized)) {
                throw new MsgpackUnserializeException(
                    "Data returned from msgpack string failed to unserialize into an object: $string"
                );
            }
            return $unserialized;
        } catch (BinaryUnserializeException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new BinaryUnserializeException(
                "Failed to unserialize string: $string ; Error: {$e->getMessage()}",
                $e->getCode(),
                $e
            );
        }
    }
}

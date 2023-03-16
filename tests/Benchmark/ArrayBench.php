<?php

declare(strict_types=1);

namespace Tests\Benchmark;

use Illuminate\Support\Arr;
use Spiral\Http\Request\InputBag;
use Yiisoft\Arrays\ArrayHelper;

class ArrayBench
{
    private const ARR_PATH = 'foo.quux.corge.grault.garply.xyzzy.quux.corge.grault.garply.xyzzy.quux.corge.grault.garply.xyzzy.quux.corge.grault.garply.xyzzy.thud';
    private InputBag $bag;
    private array $array;

    public function setUp(): void
    {
        $this->bag = new InputBag($this->array = $this->getArray());
    }

    /**
     * @BeforeMethods("setUp")
     */
    public function benchSpiral(): void
    {
        $this->bag->get(self::ARR_PATH);
    }

    /**
     * @BeforeMethods("setUp")
     */
    public function benchSpiralWithObject(): void
    {
        (new InputBag($this->array))->get(self::ARR_PATH);
    }

    /**
     * @BeforeMethods("setUp")
     */
    public function benchLaravel(): void
    {
        Arr::get(
            $this->array,
            self::ARR_PATH,
        );
    }

    /**
     * @BeforeMethods("setUp")
     */
    public function benchYii(): void
    {
        ArrayHelper::getValueByPath(
            $this->array,
            self::ARR_PATH,
        );
    }

    private function getArray(): array
    {
        return [
            'foo' => [
                'bar' => [
                    'baz' => 'qux',
                ],
                'quux' => [
                    'corge' => [
                        'grault' => [
                            'garply' => [
                                'waldo' => [
                                    'fred' => 'plugh',
                                ],
                                'xyzzy' => [
                                    'quux' => [
                                        'corge' => [
                                            'grault' => [
                                                'garply' => [
                                                    'waldo' => [
                                                        'fred' => 'plugh',
                                                    ],
                                                    'xyzzy' => [
                                                        'quux' => [
                                                            'corge' => [
                                                                'grault' => [
                                                                    'garply' => [
                                                                        'waldo' => [
                                                                            'fred' => 'plugh',
                                                                        ],
                                                                        'xyzzy' => [
                                                                            'quux' => [
                                                                                'corge' => [
                                                                                    'grault' => [
                                                                                        'garply' => [
                                                                                            'waldo' => [
                                                                                                'fred' => 'plugh',
                                                                                            ],
                                                                                            'xyzzy' => [
                                                                                                'thud' => 'Hello world!',
                                                                                            ],
                                                                                        ],
                                                                                    ],
                                                                                ],
                                                                            ],
                                                                        ],
                                                                    ],
                                                                ],
                                                            ],
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'garply' => [
                'waldo' => [
                    'fred' => 'plugh',
                ],
                'xyzzy' => [
                    'thud' => 'thud',
                ],
            ],
            'thud' => [
                'thud' => [
                    'thud' => 'thud',
                ],
            ],
        ];
    }
}
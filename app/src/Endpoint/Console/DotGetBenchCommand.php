<?php

declare(strict_types=1);

namespace App\Endpoint\Console;

use Illuminate\Support\Arr;
use Spiral\Console\Command;
use DragonCode\Benchmark\Benchmark;
use Spiral\Http\Request\InputBag;
use Yiisoft\Arrays\ArrayHelper;

class DotGetBenchCommand extends Command
{
    protected const NAME = 'bench';
    protected const DESCRIPTION = '';

    private const ARR_PATH = 'foo.quux.corge.grault.garply.xyzzy.quux.corge.grault.garply.xyzzy.quux.corge.grault.garply.xyzzy.quux.corge.grault.garply.xyzzy.thud';

    protected function perform(): void
    {
        $array = $this->getArray();

        $bag = new InputBag($array);

        (new Benchmark())
            ->iterations(100000)
            ->withoutData()
            ->compare([
                'Spiral' => fn () => $bag->get(self::ARR_PATH),
                'Yii' => fn () => ArrayHelper::getValueByPath(
                    $array,
                    self::ARR_PATH,
                ),
                'Laravel' => fn () => Arr::get(
                    $array,
                    self::ARR_PATH,
                ),
            ]);
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

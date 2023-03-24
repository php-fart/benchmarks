<?php

declare(strict_types=1);

namespace App\Endpoint\Console;

use Illuminate\Support\Arr;
use Spiral\Console\Attribute\AsCommand;
use Spiral\Console\Attribute\Option;
use Spiral\Console\Command;
use DragonCode\Benchmark\Benchmark;
use Spiral\Http\Request\InputBag;
use Yiisoft\Arrays\ArrayHelper;

#[AsCommand(
    name: 'bench:dot-get',
    description: 'Bench dot get functions performance',
)]
class DotGetBenchCommand extends Command
{
    private const ARR_PATH = 'foo.quux.corge.grault.garply.xyzzy.quux.corge.grault.garply.xyzzy.quux.corge.grault.garply.xyzzy.quux.corge.grault.garply.xyzzy.thud';

    #[Option(shortcut: 'i', description: 'Iterations count')]
    private int $iterations = 1_000;

    protected function perform(): void
    {
        $array = $this->getArray();

        $bag = new InputBag($array);

        (new Benchmark())
            ->iterations($this->iterations)
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

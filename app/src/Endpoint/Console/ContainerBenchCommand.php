<?php

declare(strict_types=1);

namespace App\Endpoint\Console;

use App\Containers\CompositeContainer;
use App\Containers\Laravel;
use App\Containers\League;
use App\Containers\PhpDi;
use App\Containers\SampleClass;
use App\Containers\Spiral;
use App\Containers\Symfony;
use App\Containers\TestClass;
use App\Containers\TestClass1;
use App\Containers\Yii;
use DragonCode\Benchmark\Benchmark;
use Spiral\Console\Attribute\AsCommand;
use Spiral\Console\Attribute\Option;
use Spiral\Console\Command;

#[AsCommand(
    name: 'bench:containers',
    description: 'Bench containers performance',
)]
final class ContainerBenchCommand extends Command
{
    #[Option(shortcut: 'i', description: 'Iterations count')]
    private int $iterations = 1_000;

    private readonly CompositeContainer $cc;

    public function __construct(string $name = null)
    {
        parent::__construct($name);

        $this->cc = new CompositeContainer();
        $this->cc->addContainer(new Spiral());
        $this->cc->addContainer(new Yii());
        $this->cc->addContainer(new Laravel());
        $this->cc->addContainer(new League());
        $this->cc->addContainer(new Symfony());
        $this->cc->addContainer(new PhpDi());
    }

    public function __invoke()
    {
        $this->cc->bind('foo', function () {
            return new TestClass(new SampleClass(new TestClass1()));
        });

        $this->cc->init();

        $this->info('Benching container performance with getting by name.');
        (new Benchmark())
            ->iterations($this->iterations)
            ->withoutData()
            ->compare([
                'Spiral' => fn () => $this->cc->get(Spiral::class, 'foo'),
                'Yii' => fn () => $this->cc->get(Yii::class, 'foo'),
                'Laravel' => fn () => $this->cc->get(Laravel::class, 'foo'),
                'League' => fn () => $this->cc->get(League::class, 'foo'),
                'Symfony' => fn () => $this->cc->get(Symfony::class, 'foo'),
                'PHP DI' => fn () => $this->cc->get(PhpDi::class, 'foo'),
            ]);

        $this->info('Benching container performance with autowiring.');
        (new Benchmark())
            ->iterations($this->iterations)
            ->withoutData()
            ->compare([
                'Spiral' => fn () => $this->cc->make(Spiral::class, TestClass::class),
                'Yii' => fn () => $this->cc->make(Yii::class, TestClass::class),
                'Laravel' => fn () => $this->cc->make(Laravel::class, TestClass::class),
                'League' => fn () => $this->cc->make(League::class, TestClass::class),
                'PHP DI' => fn () => $this->cc->make(PhpDi::class, TestClass::class),
                // 'Symfony' => fn () => $this->cc->make(Symfony::class, TestClass::class),
            ]);
    }
}
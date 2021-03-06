<?php
declare (strict_types=1);

namespace Tardigrades\SectionField\Generator;

use Tardigrades\Entity\SectionInterface;

class Generators implements GeneratorsInterface
{
    /** @var array */
    private $generators;

    /** @var array */
    private $buildMessages = [];

    /** @var array */
    private $writables = [];

    public function __construct(array $generators)
    {
        $this->generators = $generators;
    }

    public function generateBySection(SectionInterface $section): array
    {
        $writables = [];

        /** @var GeneratorInterface $generator */
        foreach ($this->generators as $generator) {
            try {
                $writables[] = $generator->generateBySection($section);
            } catch (\Exception $exception) {
                $this->buildMessages[] = $exception->getMessage();
            }
            $this->buildMessages = array_merge($this->buildMessages, $generator->getBuildMessages());
        }

        return $writables;
    }

    public function getWritables(): array
    {
        return $this->writables;
    }

    public function getBuildMessages(): array
    {
        return $this->buildMessages;
    }
}

<?php

namespace Tardigrades\Command;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;
use Tardigrades\Entity\Field;
use Tardigrades\Entity\FieldType;

class CreateFieldCommand extends Command
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct(null);
    }

    protected function configure()
    {
        $this
            ->setName('sf:create-field')
            ->setDescription('Creates a field.')
            ->setHelp('Create field based on a config file.')
            ->addArgument('config', InputArgument::REQUIRED, 'The field configuration yml')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $input->getArgument('config');
        $fieldConfigYml = Yaml::parse(file_get_contents($config));

        if (key($fieldConfigYml) === 'field' && !empty($fieldConfigYml['field']['type'])) {
            $fieldTypeRepo = $this->entityManager->getRepository(FieldType::class);
            $fieldType = $fieldTypeRepo->findOneBy([
                'type' => $fieldConfigYml['field']['type']
            ]);

            if (empty($fieldType)) {
                $output->writeln('<error>Invalid field type. Either it\'s not installed or we have a typo</error>');
                return;
            }

            $field = new Field();
            $field->setName($fieldConfigYml['field']['name']);
            $field->setHandle($this->camelCase($fieldConfigYml['field']['name']));
            $field->setFieldType($fieldType);
            $field->setConfig((object) $fieldConfigYml);

            $this->entityManager->persist($field);
            $this->entityManager->flush();

            $output->writeln('<info>Field created!</info>');

            print_r($fieldConfigYml);

            return;
        }

        $output->writeln('<error>Invalid field config.</error>');
    }

    private function camelCase($str, array $noStrip = [])
    {
        $str = preg_replace('/[^a-z0-9' . implode("", $noStrip) . ']+/i', ' ', $str);
        $str = trim($str);
        $str = ucwords($str);
        $str = str_replace(" ", "", $str);
        $str = lcfirst($str);

        return $str;
    }
}

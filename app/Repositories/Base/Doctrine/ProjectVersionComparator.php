<?php

declare(strict_types=1);

namespace App\Repositories\Base\Doctrine;

use Doctrine\Migrations\Version\AlphabeticalComparator;
use Doctrine\Migrations\Version\Comparator;
use Doctrine\Migrations\Version\Version;
use MJS\TopSort\Implementations\ArraySort;

/**
 * @see https://www.goetas.com/blog/multi-namespace-migrations-with-doctrinemigrations-30/
 */
class ProjectVersionComparator implements Comparator
{
    private AlphabeticalComparator $defaultSorter;
    private array $dependencies;

    public function __construct()
    {
        dd(__METHOD__);
        $this->defaultSorter = new AlphabeticalComparator();
        $this->dependencies = $this->buildDependencies();
    }

    private function buildDependencies(): array
    {
        $sorter = new ArraySort();

        $sorter->add('Project\Core');
        $sorter->add('Project\Domains\Admin\Country', ['Project\Core']);
        // $sorter->add('Project\ModuleB', ['Project\Core']);
        // $sorter->add('Project\ModuleC', ['Project\ModuleB']);

        return array_flip($sorter->sort());
    }

    private function getNamespacePrefix(Version $version): string
    {
        if (preg_match('~^App\[^\]+~', (string) $version, $mch)) {
            return $mch[0];
        }

        throw new \Exception('Can not find the namespace prefix for the provide migration version.');
    }

    public function compare(Version $a, Version $b): int
    {
        $prefixA = $this->getNamespacePrefix($a);
        $prefixB = $this->getNamespacePrefix($b);

        return $this->dependencies[$prefixA] <=> $this->dependencies[$prefixB]
            ?: $this->defaultSorter->compare($a, $b);
    }
}

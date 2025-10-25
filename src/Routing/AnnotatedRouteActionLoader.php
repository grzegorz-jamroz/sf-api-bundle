<?php
declare(strict_types=1);

namespace Ifrost\ApiBundle\Routing;

use Ifrost\ApiBundle\Traits\WithFindClassTrait;
use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Config\Resource\DirectoryResource;
use Symfony\Component\Routing\RouteCollection;

class AnnotatedRouteActionLoader extends FileLoader
{
    use WithFindClassTrait;

    public function load(mixed $resource, ?string $type = null): RouteCollection
    {
        if (!is_dir($dir = $this->locator->locate($resource))) {
            return new RouteCollection();
        }

        $collection = new RouteCollection();
        $collection->addResource(new DirectoryResource($dir, '/\.php$/'));
        $files = iterator_to_array(new \RecursiveIteratorIterator(
            new \RecursiveCallbackFilterIterator(
                new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::FOLLOW_SYMLINKS),
                function (\SplFileInfo $current) {
                    return !str_starts_with($current->getBasename(), '.');
                },
            ),
            \RecursiveIteratorIterator::LEAVES_ONLY,
        ));
        usort($files, function (\SplFileInfo $a, \SplFileInfo $b) {
            return (string) $a > (string) $b ? 1 : -1;
        });

        foreach ($files as $file) {
            if (!$file->isFile() || !str_ends_with($file->getFilename(), '.php')) {
                continue;
            }

            if ($class = $this->findClass($file)) {
                $refl = new \ReflectionClass($class);
                if ($refl->isAbstract()) {
                    continue;
                }

                (new AddAnnotatedRouteActionHandler($class, $collection))->handle();
            }
        }

        return $collection;
    }

    public function supports(mixed $resource, ?string $type = null): bool
    {
        return 'ifrost_api' === $type;
    }
}

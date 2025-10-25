<?php
declare(strict_types=1);

namespace Ifrost\ApiBundle\Routing;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Annotation\Route as RouteAttribute;

class AddAnnotatedRouteActionHandler
{
    public function __construct(
        private string $className,
        private RouteCollection $routes,
    )
    {
    }

    public function handle(): void
    {
        if (!class_exists($this->className)) {
            throw new \InvalidArgumentException(sprintf('Class "%s" does not exist.', $this->className));
        }

        $class = new \ReflectionClass($this->className);

        if ($class->isAbstract()) {
            throw new \InvalidArgumentException(sprintf('Annotations from class "%s" cannot be read as it is abstract.', $class->getName()));
        }

        try {
            $attribute = $this->getAttribute($class);
        } catch (\Exception) {
            return;
        }

        $this->routes->add(
            $attribute->getName(),
            new Route(
                $attribute->getPath(),
                ['_controller' => $this->className],
                $attribute->getRequirements(),
                $attribute->getOptions(),
                $attribute->getHost(),
                $attribute->getSchemes(),
                $attribute->getMethods(),
                $attribute->getCondition()
            )
        );
    }

    /**
     * @throws \Exception
     */
    private function getAttribute(\ReflectionClass $class): RouteAttribute
    {
        $attributeClassName = RouteAttribute::class;
        $attributes = $class->getAttributes($attributeClassName, \ReflectionAttribute::IS_INSTANCEOF);
            $attributes[0] ?? throw new \Exception(sprintf('Action "%s" has to declare "%s" attribute.', $class->getName(), $attributeClassName));

        return $attributes[0]->newInstance();
    }
}

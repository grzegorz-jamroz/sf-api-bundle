<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Routing;

use Exception;
use ReflectionAttribute;
use ReflectionClass;
use Stringable;
use Symfony\Component\Routing\Annotation\Route as RouteAttribute;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class AddAnnotatedRouteActionHandler
{
    /**
     * @param class-string $className
     */
    public function __construct(
        private string $className,
        private RouteCollection $routes,
    ) {
    }

    public function handle(): void
    {
        $class = new ReflectionClass($this->className);

        try {
            $attribute = $this->getAttribute($class);
        } catch (Exception) {
            return;
        }

        if (
            $attribute->getName() === null
            || $attribute->getPath() === null
        ) {
            return;
        }

        /** @var array<string|Stringable> $requirements */
        $requirements = $attribute->getRequirements();
        /** @var string[] $schemes */
        $schemes = $attribute->getSchemes();
        /** @var string[] $methods */
        $methods = $attribute->getMethods();

        $this->routes->add(
            $attribute->getName(),
            new Route(
                $attribute->getPath(),
                ['_controller' => $this->className],
                $requirements,
                $attribute->getOptions(),
                $attribute->getHost(),
                $schemes,
                $methods,
                $attribute->getCondition()
            )
        );
    }

    /**
     * @param ReflectionClass<object> $class
     *
     * @throws Exception
     */
    private function getAttribute(ReflectionClass $class): RouteAttribute
    {
        $attributeClassName = RouteAttribute::class;
        $attributes = $class->getAttributes($attributeClassName, ReflectionAttribute::IS_INSTANCEOF);
        $attributes[0] ?? throw new Exception(sprintf('Action "%s" has to declare "%s" attribute.', $class->getName(), $attributeClassName));

        return $attributes[0]->newInstance();
    }
}

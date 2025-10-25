declare(strict_types=1);

namespace Ifrost\ApiBundle\Tests\Variant\Action;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/invalid-action-without-php-code', name: 'invalid_action_without_php_code', methods: ['POST'])]
abstract class InvalidActionWithoutPhpCode
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse();
    }
}

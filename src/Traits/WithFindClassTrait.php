<?php

/**
 * Inspired/Copied from Symfony\Component\Routing\Loader\AttributeFileLoader::findClass.
 */
declare(strict_types=1);

namespace Ifrost\ApiBundle\Traits;

use InvalidArgumentException;
use SplFileInfo;

trait WithFindClassTrait
{
    /**
     * Returns the full class name for the first class in the file.
     *
     * @return class-string|false
     */
    protected function findClass(string|SplFileInfo $file): string|false
    {
        $class = false;
        $namespace = false;

        if ($file instanceof SplFileInfo) {
            $file = $file->getPathname();
        }

        $content = file_get_contents($file) ?: '';

        if ($content === '') {
            return false;
        }

        $tokens = token_get_all($content);

        if (1 === \count($tokens) && \T_INLINE_HTML === $tokens[0][0]) {
            throw new InvalidArgumentException(sprintf('The file "%s" does not contain PHP code. Did you forgot to add the "<?php" start tag at the beginning of the file?', $file));
        }

        $nsTokens = [\T_NS_SEPARATOR => true, \T_STRING => true];
        if (\defined('T_NAME_QUALIFIED')) {
            $nsTokens[\T_NAME_QUALIFIED] = true;
        }
        for ($i = 0; isset($tokens[$i]); ++$i) {
            $token = $tokens[$i];
            if (!isset($token[1])) {
                continue;
            }

            if (true === $class && \T_STRING === $token[0]) {
                /** @var class-string $className */
                $className = $namespace . '\\' . $token[1];

                return $className;
            }

            if (true === $namespace && isset($nsTokens[$token[0]])) {
                $namespace = $token[1];
                while (isset($tokens[++$i][1], $nsTokens[$tokens[$i][0]])) {
                    $namespace .= $tokens[$i][1];
                }
                $token = $tokens[$i];
            }

            if (\T_CLASS === $token[0]) {
                // Skip usage of ::class constant and anonymous classes
                $skipClassToken = false;
                for ($j = $i - 1; $j > 0; --$j) {
                    if (!isset($tokens[$j][1])) {
                        if ('(' === $tokens[$j] || ',' === $tokens[$j]) {
                            $skipClassToken = true;
                        }
                        break;
                    }

                    if (\T_DOUBLE_COLON === $tokens[$j][0] || \T_NEW === $tokens[$j][0]) {
                        $skipClassToken = true;
                        break;
                    } elseif (!\in_array($tokens[$j][0], [\T_WHITESPACE, \T_DOC_COMMENT, \T_COMMENT])) {
                        break;
                    }
                }

                if (!$skipClassToken) {
                    $class = true;
                }
            }

            if (\T_NAMESPACE === $token[0]) {
                $namespace = true;
            }
        }

        return false;
    }
}

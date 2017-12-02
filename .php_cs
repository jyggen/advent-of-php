<?php

declare(strict_types=1);

/*
 * This file is part of boo/advent-of-php.
 *
 * (c) Jonas Stendahl <jonas@stendahl.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use function Boo\CodeStandard\get_php_cs_fixer_rules;

$header = <<<'EOF'
This file is part of boo/advent-of-php.

(c) Jonas Stendahl <jonas@stendahl.me>

This source file is subject to the MIT license that is bundled
with this source code in the file LICENSE.
EOF;

$finder = Finder::create();
$config = Config::create();
$rules = \array_replace(get_php_cs_fixer_rules(), [
    'header_comment' => [
        'header' => $header,
    ],
    'native_function_invocation' => true,
]);

$finder->in(__DIR__);
$finder->name('.php_cs');
$finder->name('generate-classes');
$finder->ignoreDotFiles(false);

$config->setFinder($finder);
$config->setRiskyAllowed(true);
$config->setRules($rules);

return $config;

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

$header = <<<'EOF'
This file is part of boo/advent-of-php.

(c) Jonas Stendahl <jonas@stendahl.me>

This source file is subject to the MIT license that is bundled
with this source code in the file LICENSE.
EOF;

$finder = Finder::create();
$config = Config::create();
$rules = [
    '@PHP71Migration' => true,
    '@PHP71Migration:risky' => true,
    '@PHPUnit60Migration:risky' => true,
    '@Symfony' => true,
    '@Symfony:risky' => true,
    'align_multiline_comment' => true,
    'array_syntax' => [
        'syntax' => 'short',
    ],
    'combine_consecutive_issets' => true,
    'combine_consecutive_unsets' => true,
    'compact_nullable_typehint' => true,
    'header_comment' => [
        'header' => $header,
    ],
    'heredoc_to_nowdoc' => true,
    'linebreak_after_opening_tag' => true,
    'list_syntax' => [
        'syntax' => 'short',
    ],
    'mb_str_functions' => true,
    'no_multiline_whitespace_before_semicolons' => true,
    'no_null_property_initialization' => true,
    'no_php4_constructor' => true,
    'no_short_echo_tag' => true,
    'no_superfluous_elseif' => true,
    'no_unreachable_default_argument_value' => true,
    'no_useless_else' => true,
    'no_useless_return' => true,
    'ordered_class_elements' => true,
    'ordered_imports' => true,
    'php_unit_strict' => true,
    'phpdoc_add_missing_param_annotation' => true,
    'phpdoc_order' => true,
    'phpdoc_types_order' => true,
    'strict_comparison' => true,
    'strict_param' => true,
];

$finder->in(__DIR__);
$finder->name('.php_cs');
$finder->name('generate-classes');
$finder->ignoreDotFiles(false);

$config->setFinder($finder);
$config->setRiskyAllowed(true);
$config->setRules($rules);

return $config;

<?php
$finder = Symfony\Component\Finder\Finder::create()
    ->in([
        __DIR__ . '/'
    ])
    ->exclude("vendor")
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);


return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'no_unused_imports' => true,
        'not_operator_with_successor_space' => true,
        'trailing_comma_in_multiline' => true,
        'phpdoc_scalar' => true,
        'unary_operator_spaces' => true,
        'binary_operator_spaces' => true,
        'blank_line_before_statement' => [
            'statements' => ['break', 'continue', 'declare', 'return', 'throw', 'try'],
        ],
        'phpdoc_single_line_var_spacing' => true,
        'align_multiline_comment' => true,
        'phpdoc_var_without_name' => true,
        'phpdoc_add_missing_param_annotation' => true,
        'phpdoc_no_empty_return' => true,
        'no_superfluous_phpdoc_tags' => true,
        'no_empty_phpdoc' => true,
        'no_empty_comment' => true,
        'declare_strict_types' => true,
        'no_multiline_whitespace_around_double_arrow' => true,
        'class_attributes_separation' => [
            'elements' => [
                'method' => 'one',
            ],
        ],
        'method_argument_space' => [
            'on_multiline' => 'ensure_fully_multiline',
            'keep_multiple_spaces_after_comma' => true,
        ],
        'single_trait_insert_per_statement' => true,
    ])
    ->setFinder($finder);
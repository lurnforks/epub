<?php

/**
 * @see https://mlocati.github.io/php-cs-fixer-configurator
 */

return PhpCsFixer\Config::create()->setRules([
    '@PSR12' => true,

    // Arrays
    'array_indentation' => true,
    'array_syntax' => ['syntax' => 'short'],
    'list_syntax' => ['syntax' => 'short'],
    'no_whitespace_before_comma_in_array' => true,
    'trailing_comma_in_multiline_array' => true,

    // Classes
    'class_attributes_separation' => [
        'elements' => [
            'const',
            'method',
            'property',
        ]
    ],
    'new_with_braces' => true,
    'no_blank_lines_after_class_opening' => true,

    // Operators
    'logical_operators' => true,
    'not_operator_with_successor_space' => true,
    'object_operator_without_whitespace' => true,

    // Code fixes
    'combine_consecutive_issets' => true,
    'combine_consecutive_unsets' => true,
    'explicit_string_variable' => true,
    'lambda_not_used_import' => true,
    'no_superfluous_elseif' => true,
    'no_unused_imports' => true,
    'no_useless_else' => true,
    'ternary_to_null_coalescing' => true,

    // Case transformations
    'lowercase_static_reference' => true,
    'magic_constant_casing' => true,
    'magic_method_casing' => true,
    'native_function_casing' => true,

    // Whitespace
    'align_multiline_comment' => ['comment_type' => 'all_multiline'],
    'blank_line_before_statement' => ['statements' => ['if', 'for', 'foreach', 'do', 'while', 'switch', 'try', 'return']],
    'cast_spaces' => ['space' => 'single'],
    'concat_space' => ['spacing' => 'one'],
    'blank_line_after_opening_tag' => true,
    'linebreak_after_opening_tag' => true,
    'no_multiline_whitespace_around_double_arrow' => true,
    'no_multiline_whitespace_before_semicolons' => true,
    'no_singleline_whitespace_before_semicolons' => true,
    'no_spaces_around_offset' => ['positions' => ['inside', 'outside']],
    'no_trailing_whitespace' => true,
    'single_blank_line_before_namespace' => true,
    'whitespace_after_comma_in_array' => true,
]);

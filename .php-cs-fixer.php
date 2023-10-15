<?php

use PhpCsFixer\Finder;
use PhpCsFixer\Config;

$finder = Finder::create()
    // ->exclude('somedir')
    // ->notPath('src/Symfony/Component/Translation/Tests/fixtures/resources.php')
    ->in(__DIR__)
;

$config = new Config();
return $config->setRules([
        // Symfony rules
        // '@Symfony' => true,
        // 'full_opening_tag' => false,

        '@PSR12' => true,
        // 'strict_param' => true,

        // Array Notation
        'array_syntax' => ['syntax' => 'short'],
        'no_multiline_whitespace_around_double_arrow' => true,

        // Attribute Notation
        'attribute_empty_parentheses' => ['use_parentheses' => false],

        // Basic braces_position
        'braces_position' => [
            // classes
            'classes_opening_brace' => 'next_line_unless_newline_at_signature_end',
            'anonymous_classes_opening_brace' => 'same_line',

            // Functions
            'functions_opening_brace' => 'next_line_unless_newline_at_signature_end',
            'anonymous_functions_opening_brace' => 'same_line',

            // Control structures
            'control_structures_opening_brace' => 'same_line', // 'next_line_unless_newline_at_signature_end',
        ],

        'no_multiple_statements_per_line' => true,
        'constant_case' => ['case' => 'lower'],
        'lowercase_static_reference' => true,
        'magic_constant_casing' => true,
        'magic_method_casing' => true,
        'native_function_type_declaration_casing' => true,
        'native_function_casing' => true,
        'native_type_declaration_casing' => true,

        // Cast Notation
        'cast_spaces' => ['space' => 'single'],
        'lowercase_cast' => true,
        'modernize_types_casting' => true,
        'no_short_bool_cast' => true,
        'no_unset_cast' => true,
        'short_scalar_cast' => true,

        // Class Notation

        // Class Usage
        'date_time_immutable' => true,

        // Control Structure

        // Function Notation

        // Language Construct

        // Namespace Notation
        'blank_line_after_namespace' => true,
        // 'blank_lines_before_namespace' => [
        //     'max_line_breaks' => 1,
        // ],
        'clean_namespace' => true,
        'no_leading_namespace_whitespace' => true,
        // 'single_blank_line_before_namespace' => true,

        // Naming

        // Operator

        // PHP Tag

        // PHPUnit

        // PHPDoc

        // Return Notation

        // Semicolon

        // Strict
        'declare_strict_types' => true,
        'strict_comparison' => true,
        'strict_param' => true,

        // String Notation

        // Whitespace
        'array_indentation' => true,
    ])
    ->setFinder($finder)
;

<?php
/**
 * Class Template
 *
 * @package LiveChat\Services\Templates
 */

namespace LiveChat\Services\Templates;

use LiveChat\Services\TemplateParser;

/**
 * Class Template
 *
 * @package LiveChat\Services\Templates
 */
abstract class Template {
	/**
	 * Instance of TemplateParser.
	 *
	 * @var TemplateParser
	 */
	protected $template_parser;

	/**
	 * Instance of TemplateParser.
	 *
	 * @var array
	 */
	protected $context;

	/**
	 * Template constructor.
	 *
	 * @param TemplateParser $template_parser Instance of TemplateParser.
	 */
	public function __construct( $template_parser, $context = array() ) {
		$this->template_parser = $template_parser;
		$this->context         = $context;
	}

	/**
	 * Renders template.
	 *
	 * @return mixed
	 */
	abstract public function render();

	/**
	 * Returns new instance of Template.
	 *
	 * @param array $context
	 * @return static
	 */
	public static function create( $context = array() ) {
		return new static( TemplateParser::create( '../templates' ), $context );
	}
}

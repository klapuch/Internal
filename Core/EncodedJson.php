<?php
declare(strict_types = 1);
namespace Klapuch\Internal;

final class EncodedJson implements Text {
	/** @var mixed[] */
	private $values;

	/** @var int */
	private $options;

	public function __construct(array $values, int $options = 0) {
		$this->values = $values;
		$this->options = $options;
	}

	public function value(): string {
		return json_encode($this->values, $this->options);
	}
}
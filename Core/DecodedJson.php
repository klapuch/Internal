<?php
declare(strict_types = 1);
namespace Klapuch\Internal;

final class DecodedJson implements Collection {
	/** @var string */
	private $json;

	/** @var int */
	private $options;

	public function __construct(string $json, int $options = 0) {
		$this->json = $json;
		$this->options = $options;
	}

	public function values(): array {
		return json_decode($this->json, true, 512, $this->options);
	}
}
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

	/**
	 * @throws \UnexpectedValueException
	 * @return array
	 */
	public function values(): array {
		$decoded = json_decode($this->json, true, 512, $this->options);
		if (json_last_error() === JSON_ERROR_NONE)
			return $decoded;
		throw new \UnexpectedValueException('JSON is not valid', json_last_error());
	}
}
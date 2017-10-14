<?php
declare(strict_types = 1);
namespace Klapuch\Internal;

final class HeaderExtension implements Extension {
	private $headers;

	public function __construct(array $headers) {
		$this->headers = $headers;
	}

	public function improve(): void {
		$headers = array_filter(array_map('trim', $this->headers), 'strlen');
		(new RawHeaderExtension(
			array_map(
				function(string $field, string $value): string {
					return sprintf('%s:%s', $field, $value);
				},
				array_keys($headers),
				$headers
			)
		))->improve();
	}
}
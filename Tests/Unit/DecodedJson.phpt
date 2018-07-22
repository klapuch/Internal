<?php
declare(strict_types = 1);
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Klapuch\Internal\Unit;

use Klapuch\Internal;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class DecodedJson extends Tester\TestCase {
	public function testDecodedJson() {
		Assert::same(json_decode('{"a":1}', true), (new Internal\DecodedJson('{"a":1}'))->values());
	}
}


(new DecodedJson())->run();
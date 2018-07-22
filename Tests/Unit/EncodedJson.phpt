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

final class EncodedJson extends Tester\TestCase {
	public function testEncodedJson() {
		Assert::same(json_encode(['a' => 1]), (new Internal\EncodedJson(['a' => 1]))->value());
	}
}


(new EncodedJson())->run();
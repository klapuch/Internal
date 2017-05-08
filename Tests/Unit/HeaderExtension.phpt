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

final class HeaderExtension extends Tester\TestCase {
	public function testSentHeaders() {
		(new Internal\HeaderExtension(['Name' => 'Value', 'Foo' => 'bar']))->improve();
		Assert::contains('Name:Value', headers_list());
		Assert::contains('Foo:bar', headers_list());
	}
}


(new HeaderExtension())->run();
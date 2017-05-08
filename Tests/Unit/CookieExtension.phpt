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

final class CookieExtension extends Tester\TestCase {
	public function testNoPassedSettingWithoutAffection() {
		$header = 'Set-Cookie: PHPSESSID=xyz; path=/';
		header($header);
		$extension = new Internal\CookieExtension([]);
		$extension->improve();
		Assert::same($header, headers_list()[1]);
	}

	public function testUnknownPassedSettingWithoutAffection() {
		$header = 'Set-Cookie: PHPSESSID=xyz; path=/';
		header($header);
		$extension = new Internal\CookieExtension(['foo' => 'bar']);
		$extension->improve();
		Assert::same($header, headers_list()[1]);
	}

	public function testSettingSameSiteFlagToEnd() {
		$header = 'Set-Cookie: PHPSESSID=xyz; path=/';
		header($header);
		$extension = new Internal\CookieExtension(['SameSite' => 'strict']);
		$extension->improve();
		$cookie = headers_list()[1];
		Assert::same(sprintf('%s; SameSite=strict', $header), $cookie);
	}

	public function testKeepingCases() {
		$header = 'Set-Cookie: PHPSESSID=xyz; path=/';
		header($header);
		$extension = new Internal\CookieExtension(['SaMeSiTE' => 'strict']);
		$extension->improve();
		$cookie = headers_list()[1];
		Assert::same(sprintf('%s; SameSite=strict', $header), $cookie);
	}

	public function testNoHeaderToImprove() {
		$extension = new Internal\CookieExtension(['SameSite' => 'strict']);
		$extension->improve();
		Assert::count(1, headers_list());
	}
}


(new CookieExtension())->run();
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

final class SessionExtension extends Tester\TestCase {
	public function testRegeneratingSessionAfterElapse() {
		$extension = new Internal\SessionExtension([], 1);
		$extension->improve();
		$initId = session_id();
		$_SESSION['_timer'] = time() - 2;
		$extension->improve();
		Assert::notSame('', $initId);
		Assert::notSame($initId, session_id());
	}

	public function testInstantRegeneration() {
		$extension = new Internal\SessionExtension([], 0);
		$extension->improve();
		$initId = session_id();
		$_SESSION['_timer'] = time() - 1;
		$extension->improve();
		Assert::notSame($initId, session_id());
	}

	public function testElapseWithOverwhelmingElapse() {
		$extension = new Internal\SessionExtension([], 1);
		$extension->improve();
		$initId = session_id();
		$_SESSION['_timer'] = time() - 1;
		$extension->improve();
		Assert::same($initId, session_id());
	}

	public function testNoPassedSetting() {
		$extension = new Internal\SessionExtension([]);
		$extension->improve();
		Assert::match('~^Set-Cookie: PHPSESSID=\S+; path=/;$~', headers_list()[4]);
	}

	public function testPassingSetting() {
		$extension = new Internal\SessionExtension(['cookie_httponly' => true]);
		$extension->improve();
		Assert::contains('HttpOnly', headers_list()[4]);
		Assert::true(session_get_cookie_params()['httponly']);
	}

	public function testSettingSameSite() {
		$extension = new Internal\SessionExtension(['SameSite' => 'strict']);
		$extension->improve();
		$cookie = headers_list()[4];
		Assert::match(
			'~^Set-Cookie: PHPSESSID=\S+; path=/; SameSite=strict$~',
			$cookie
		);
	}

	public function testSettingSameSiteAsCaseInsensitive() {
		$extension = new Internal\SessionExtension(['sAmESiTe' => 'strict']);
		$extension->improve();
		$cookie = headers_list()[4];
		Assert::contains('Set-Cookie: ', $cookie);
		Assert::contains('; SameSite=strict', $cookie);
	}

	public function testProprietarSettingAfterRegeneration() {
		$extension = new Internal\SessionExtension(['SameSite' => 'strict'], 1);
		$extension->improve();
		$_SESSION['_timer'] = time() - 2;
		$extension->improve();
		$cookie = headers_list()[4];
		Assert::contains('Set-Cookie: ', $cookie);
		Assert::contains('; SameSite=strict', $cookie);
	}
}


(new SessionExtension())->run();
<?php

/**
 * @file
 * Contains Phagrancy\Http\Middleware\ValidateTokenOrPassword
 */

namespace Phagrancy\Http\Middleware;

use Phagrancy\Http\Response\NotAuthorized;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Validates that the request is using the proper access_token
 *
 * @package Phagrancy\Http\Middleware
 */
class ValidateTokenOrPassword
{
	use ValidatesToken, ValidatesPassword;

	public function __construct(?string $token, ?string $password)
	{
		$this->token    = $token;
		$this->password = $password;
	}

	public function __invoke(Request $request, Response $response, $next): ResponseInterface
	{
		$notAuthorized = new NotAuthorized();
		$allow = false;
		if ($this->token && !empty($token = $this->getTokenFromRequest($request))) {
			$allow = ($token === $this->token);
		}
		elseif ($this->validatePassword($request)) {
			$allow = true;
		}
		elseif (isset($this->password)) {
			// enforce Basic authentication
			$notAuthorized = $notAuthorized->withHeader('WWW-Authenticate', 'Basic realm="Phagrancy"');
		}

		return $allow
			? $next($request, $response)
			: $notAuthorized;
	}
}
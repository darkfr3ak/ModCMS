<?php
class HTTP {
	#====================================================================================================
	# Eigenschaften: Zugriff auf die drei Request-Variablen
	#====================================================================================================
	public static $GET  = NULL;
	public static $POST = NULL;
	public static $FILE = NULL;

	#====================================================================================================
	# Initialisiert die Eigenschaften $GET, $POST und $FILE
	#====================================================================================================
	public static function init() {
		self::$GET  = array_map('trim', $_GET);
		self::$POST = array_map('trim', $_POST);
		self::$FILE = $_FILES;
	}

	#====================================================================================================
	# Gibt eine valide Statuscodezeile für den HTTP Response-Header zurück
	#====================================================================================================
	private static function getStatuscode($code) {
		$statuscodes = array(
			'200' => 'HTTP/1.1 200 OK',
			'301' => 'HTTP/1.1 301 Moved Permanently',
			'302' => 'HTTP/1.1 302 Found',
			'303' => 'HTTP/1.1 303 See Other',
			'307' => 'HTTP/1.1 307 Temporary Redirect',
			'400' => 'HTTP/1.1 400 Bad Request',
			'401' => 'HTTP/1.1 401 Authorization Required',
			'403' => 'HTTP/1.1 403 Forbidden',
			'404' => 'HTTP/1.1 404 Not Found',
			'500' => 'HTTP/1.1 500 Internal Server Error',
			'503' => 'HTTP/1.1 503 Service Temporarily Unavailable',
		);

		return $statuscodes[$code];
	}

	#====================================================================================================
	# Prüft ob alle Elemente von $values als $_POST-Schlüssel gesetzt sind
	#====================================================================================================
	public static function issetPostValues($keys) {
		foreach($keys as $key) {
			if(!isset(self::$POST[$key])) {
				return FALSE;
			}
		}

		return TRUE;
	}

	#====================================================================================================
	# Prüft ob alle Elemente von $values als $_GET-Schlüssel gesetzt sind
	#====================================================================================================
	public static function issetGetValues($keys) {
		foreach($keys as $key) {
			if(!isset(self::$GET[$key])) {
				return FALSE;
			}
		}

		return TRUE;
	}

	#====================================================================================================
	# Gibt die HTTP-Anfragemethode zurück oder prüft diese
	#====================================================================================================
	public static function requestMethod($method = NULL) {
		if(!empty($method)) {
			if($_SERVER['REQUEST_METHOD'] == $method) {
				return TRUE;
			}
		}
		else {
			return $_SERVER['REQUEST_METHOD'];
		}
	}

	#====================================================================================================
	# Gibt die relativ aufgerufene URL zurück
	#====================================================================================================
	public static function requestURI() {
		if(isset($_SERVER['REQUEST_URI'])) {
			return $_SERVER['REQUEST_URI'];
		}
	}

	#====================================================================================================
	# Inhalt des User-Agent:-Feldes im HTTP-Header
	#====================================================================================================
	public static function useragent() {
		if(isset($_SERVER['HTTP_USER_AGENT'])) {
			return trim($_SERVER['HTTP_USER_AGENT']);
		}
		return '';
	}

	#====================================================================================================
	# Inhalt des Referer:-Feldes im HTTP-Header
	#====================================================================================================
	public static function referer() {
		if(isset($_SERVER['HTTP_REFERER'])) {
			return trim($_SERVER['HTTP_REFERER']);
		}
		return '';
	}

	#====================================================================================================
	# Gibt den HTTP-Statuscode der aktuellen Anfrage zurück oder sendet ihn
	#====================================================================================================
	public static function responseStatus($code = NULL) {
		if(!empty($code)) {
			return header(self::getStatuscode($code));
		}
		return http_response_code();
	}

	#====================================================================================================
	# Sendet einen HTTP-Redirect an den Client
	#====================================================================================================
	public static function redirect($location, $code = 303) {
		header(self::getStatuscode($code));
		header('Location: '.$location);
	}
}
?>
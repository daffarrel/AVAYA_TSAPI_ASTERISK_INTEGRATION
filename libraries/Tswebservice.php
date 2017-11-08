<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tswebservice  {

	protected $ci;

	function __construct()
	{
		$this->ci =& get_instance();
	}

	function registerAttached() {
		$token = $this->getToken();
		// echo $token;
		$credentials = "USERNAME:PASSWORD"; 
		$url = "https://IP_OF_TELEPHONY_WEB_SERVICE/axis/services/TelephonyService?wsdl";
		$body = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ses="http://xml.avaya.com/ws/session" xmlns:tel="http://TelephonyService.ws.avaya.com">
					<soapenv:Header>
						<ses:sessionID>'.$token.'</ses:sessionID>
					</soapenv:Header>
					<soapenv:Body>
						<tel:attach>EXTENSION_NUMBER</tel:attach>
					</soapenv:Body>
				</soapenv:Envelope>';

		$headers = array( 
		    'Content-Type: text/xml; charset="utf-8"', 
		    'Content-Length: '.strlen($body), 
		    'Accept: text/xml', 
		    'Cache-Control: no-cache', 
		    'Pragma: no-cache', 
		    'SOAPAction: "attach"'
		); 

		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 60); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		// Stuff I have added
		curl_setopt($ch, CURLOPT_POST, true); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $body); 
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, $credentials);

		$result = curl_exec($ch);
		$replace = array("soapenv:","ns1:");
        $clean_xml = str_ireplace($replace, '', $result);
        $xml   = simplexml_load_string($clean_xml);
        $arr = json_decode(json_encode($xml), TRUE);
        return $arr['Header']['sessionID'];
	}

	function actionConnected ($actSelected, $currentNumber, $outNumber) {
		$regID = $this->registerAttached();
		$getAction = $this->actionType($actSelected, $currentNumber, $outNumber, $regID);
		$credentials = "USERNAME:PASSWORD"; 
		$url = "https://IP_OF_TELEPHONY_WEB_SERVICE/axis/services/TelephonyService?wsdl";
		$body = $getAction['requestData'];
		$headers = array( 
		    'Content-Type: text/xml; charset="utf-8"', 
		    'Content-Length: '.strlen($body), 
		    'Accept: text/xml', 
		    'Cache-Control: no-cache', 
		    'Pragma: no-cache', 
		    'SOAPAction: '.$getAction['actType']
		); 

		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 60); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		// Stuff I have added
		curl_setopt($ch, CURLOPT_POST, true); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $body); 
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, $credentials);

		$result = curl_exec($ch); 
		$replace = array("soapenv:","ser-root:");
        $clean_xml = str_ireplace($replace, '', $result);
        $xml = simplexml_load_string($clean_xml);
        var_dump(simplexml_load_string($result));
	}

	function getToken($length = 16)
	{
	    $token = "";
	    $codeAlphabet = "9876543210";
	    $codeAlphabet.= "0123456789";
	    $codeAlphabet.= "9876543210";
	    $max = strlen($codeAlphabet); // edited

	    for ($i=0; $i < $length; $i++) {
	        $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max-1)];
	    }

	    return $token;
	}

	function crypto_rand_secure($min, $max)
	{
	    $range = $max - $min;
	    if ($range < 1) return $min; // not so random...
	    $log = ceil(log($range, 2));
	    $bytes = (int) ($log / 8) + 1; // length in bytes
	    $bits = (int) $log + 1; // length in bits
	    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
	    do {
	        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
	        $rnd = $rnd & $filter; // discard irrelevant bits
	    } while ($rnd > $range);
	    return $min + $rnd;
	}

	function actionType($actSelected, $currentNumber, $outNumber, $regID) {
		switch ($actSelected) {
			case 'outboundCall':
				$pullBack['actType'] = 'makeCall';
				$pullBack['requestData'] = '
					<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ses="http://xml.avaya.com/ws/session" xmlns:tel="http://TelephonyService.ws.avaya.com">
						<soapenv:Header>
							<ses:sessionID>'.$regID.'</ses:sessionID>
						</soapenv:Header>
						<soapenv:Body>
							<tel:makeCall>
							<originatingExtension>'.$currentNumber.'</originatingExtension>
							<destinationNumber>'.$outNumber.'</destinationNumber>
							</tel:makeCall>
						</soapenv:Body>
					</soapenv:Envelope>';
				break;
			case 'releaseCall':
				$pullBack['actType'] = 'release';
				$pullBack['requestData'] = '
					<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ses="http://xml.avaya.com/ws/session" xmlns:tel="http://TelephonyService.ws.avaya.com">
						<soapenv:Header>
							<ses:sessionID>'.$regID.'</ses:sessionID>
						</soapenv:Header>
						<soapenv:Body>
							<tel:release>'.$currentNumber.'</tel:release>
						</soapenv:Body>
					</soapenv:Envelope>';
				break;
			case 'disconnectCall':
				$pullBack['actType'] = 'disconnectActiveCall';
				$pullBack['requestData'] = '
					<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ses="http://xml.avaya.com/ws/session" xmlns:tel="http://TelephonyService.ws.avaya.com">
						<soapenv:Header>
							<ses:sessionID>'.$regID.'</ses:sessionID>
						</soapenv:Header>
						<soapenv:Body>
							<tel:disconnectActiveCall>
								<extension>'.$currentNumber.'</extension>
							</tel:disconnectActiveCall>
						</soapenv:Body>
					</soapenv:Envelope>';
				break;
			
		}
		return $pullBack;
	}

}

/* End of file Tswebservice.php */
/* Location: ./application/controllers/Tswebservice.php */
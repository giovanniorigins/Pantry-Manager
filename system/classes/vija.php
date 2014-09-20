<?php

/*
 * This file will house our slightly modified versions of php functions
 * All functions should be a public function NOT static!
 *
 */

class Vija {

    public $recent = null;

    public static function doLogout() {
	$Session = new SecureSession;
	Users::setStatus(0, Session::get('user_id'));
	$Session->Destroy();
exit(header("Location: /login"));
}

public static function text_post_clean($content = '', $strip = false) {
$dirty = array('\r', '\n', '&nbsp;');
$clean = array('', '', '');
$ret = str_replace($dirty, $clean, $content);
if ($strip)
$ret = strip_tags($ret);
return IWED_DB::escape($ret);
}

public static function is_video_url($url = null) {
if ($url == null)
return false;
$url = strtolower($url);
if (strpos($url, 'youtube') > 0) {
return true;
} elseif (strpos($url, 'vimeo') > 0) {
return true;
} else {
return false;
}
}

public static function page_protect() {
$Session = new SecureSession;
if (Session::available('user_id') AND Session::available('user_level')) {
if ($Session->AnalyseFingerPrint($Analysis) !== true) {
return false;
}
return true;
}
return false;
}

public static function GenPwd($length = 7) {
$password = "";
$possible = "0123456789bcdfghjkmnpqrstvwxyz";
//no vowels for more security
$i = 0;
while ($i < $length) {
$char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
if (!strstr($password, $char)) {
$password .= $char;
$i++;
}
}

return $password;
}

public static function isEmail($email) {
return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? TRUE : FALSE;
}

/*
* 0 doesn't always mean empty.. so annoying sometimes
*/

public static function _empty($arg) {
return ($arg === 0 or $arg === '0') ? false : empty($arg);
}

//makes everything an array.. this way we can always perform functions using foreach without fool
public static function make_array($args) {
!is_array($args) ? $retval[0] = $args : $retval = $args;
return $retval;
}

//returns just one element of an array if only one element exists
public static function array_return_right($args) {
$args = self::make_array($args);
return sizeof($args) == 1 ? $args[0] : $args;
}

//adds a string to the front of an argument
public static function add_to_front($front = '', $args, $implode = false) {
if (self::_empty($front))
return $args;
$args = self::make_array($args);
$array = array();
foreach ($args as $arg)
$array[] = $front . $arg;
return $implode ? implode('', $array) : self::array_return_right($array);
}

//adds a string behind an argument
public static function add_to_back($back = '', $args, $implode = false) {
if (self::_empty($back))
return $args;
$args = self::make_array($args);
$array = array();
foreach ($args as $arg)
$array[] = $arg . $back;
return $implode ? implode('', $array) : self::array_return_right($array);
}

//adds a string in front of and behind an argument
public static function add_to_front_then_back($front = '', $back = '', $args, $implode = false, $double_chars = null) {
$args = self::make_array($args);
$array = array();
foreach ($args as $arg)
$array[] = $front . $arg . $back;
if ($implode) {
if (!self::_empty($double_chars))
$retval = str_replace($double_chars . $double_chars, $double_chars, implode('', $array));
else
$retval = implode('', $array);
} else {
$retval = self::array_return_right($array);
}
return $retval;
}

//Script killers
public static function dvd($stuff, $bh = true, $kill = true) {
$bh = $bh ? '<br><hr>' : '';
$retval = '<pre>' . var_dump($stuff) . '</pre>' . $bh;
return $kill ? die($retval) : $retval;
}

public static function dpr($stuff, $bh = true, $kill = true) {
$bh = $bh ? '<br><hr>' : '';
$retval = '<pre>' . print_r($stuff) . '</pre>' . $bh;
return $kill ? die($retval) : $retval;
}

//End script killers
//Filter functions
public static function super_preg($remove_this = '', $type = 'int', $keep = '', $replace_with_this = '') {
if (self::_empty($remove_this))
return '';
$additional = self::_empty($keep) ? $keep = '' : self::add_to_front_then_back('', '', $keep, true, '/');
$type = strtolower($type);
switch ($type) {
case 'int' :
$regex = "/[^0-9$additional]/";
break;
case 'alpha' :
$regex = "/[^a-zA-Z$additional]/";
break;
default :
$regex = "/[^A-Za-z0-9$additional]/";
break;
}
return preg_replace($regex, $replace_with_this, $remove_this);
}

//replace foreach with array walk sooner than later...

public static function filter_anon($args = '', $type, $keep = '', $convert = '') {
if (self::_empty($args))
return '';
$args = self::make_array($args);
$support = array('int', 'alpha', 'string');
$retval = array();
foreach ($args as $arg)
$retval[] = self::super_preg($arg, $type, $keep, $convert);
return self::array_return_right($retval);
}

public static function filter_int($args) {
if (self::_empty($args))
return '';
$args = self::make_array($args);
$retval = array();
foreach ($args as $arg)
$retval[] = filter_var($arg, FILTER_VALIDATE_INT);
return self::array_return_right($retval);
}

public static function filter_url($args) {
if (self::_empty($args))
return '';
$args = self::make_array($args);
$retval = array();
foreach ($args as $arg)
$retval[] = filter_var($arg, FILTER_VALIDATE_URL);
return self::array_return_right($retval);
}

public static function filter_email($args) {
if (self::_empty($args))
return '';
$args = self::make_array($args);
$retval = array();
foreach ($args as $arg)
$retval[] = filter_var($arg, FILTER_VALIDATE_EMAIL);
return self::array_return_right($retval);
}

//End filter
//Curl functions
public static function remote_file_exists($url) {
return file_get_contents($url, NULL, NULL, 0, 1);
}

//End curl functions
//Mailer
public static function send_mail($sendto, $subject, $body, $email_from = EMAIL_ADDRESS, $email_from_name = EMAIL_FROM, $email = EMAIL_ADDRESS, $password = EMAIL_PASSWORD) {
$sendto = self::make_array($sendto);
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPDebug = 0;
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
$mail->Host = 'smtp.gmail.com';
$mail->Port = 465;
$mail->Username = $email;
$mail->Password = $password;
$mail->SetFrom($email_from, $email_from_name);
$mail->IsHTML(true);
$mail->Subject = $subject;
$mail->Body = $body;
foreach ($sendto as $receiver)
$mail->AddAddress($receiver);
return $mail->Send() == false ? false : true;
}

//end mailer
//reverses a hashmap..
public static function hash_value_key($hm) {
if (!is_array($hm))
return null;
$ret = array();
foreach ($hm as $k => $v)
$ret[$v] = $k;
return $ret;
}

//returns data uri of an image.. greatly reduces server load for many images however, not very suportive (try in chrome)
public static function get_data_uri($image, $mime = '') {
$IE6 = (ereg('MSIE 6', $_SERVER['HTTP_USER_AGENT'])) ? true : false;
$IE7 = (ereg('MSIE 7', $_SERVER['HTTP_USER_AGENT'])) ? true : false;
$IE8 = (ereg('MSIE 8', $_SERVER['HTTP_USER_AGENT'])) ? true : false;
return (($IE6 == true) || ($IE7 == true)) ? $image : 'data: ' . (function_exists('mime_content_type') ? mime_content_type($image) : $mime) . ';base64,' . base64_encode(file_get_contents($image));
}

//generate pretty urls
public static function gen_pretty_url($args) {
$args = self::make_array($args);
$ret = array();
$from = explode(',', "ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,(,),[,],'");
$to = explode(',', 'c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,,,,,,');
foreach ($args as $arg) {
$temp = preg_replace('~[^\w\d]+~', '-', str_replace($from, $to, trim($arg)));
$ret[] = strtolower(preg_replace('/^-/', '', preg_replace('/-$/', '', $temp)));
}
return self::array_return_right($ret);
}

public static function parse_user_agent($u_agent = null) {
if (is_null($u_agent) && isset($_SERVER['HTTP_USER_AGENT']))
$u_agent = $_SERVER['HTTP_USER_AGENT'];

$data = array('platform' => null, 'browser' => null, 'version' => null);

if (!$u_agent)
return $data;

if (preg_match('/\((.*?)\)/im', $u_agent, $regs)) {
preg_match_all('/(?P<platform>Android|CrOS|iPhone|iPad|Linux|Macintosh|Windows\ Phone\ OS|Windows|Silk|linux-gnu|BlackBerry|Nintendo\ Wii|Xbox)
	(?:\ [^;]*)?
	(?:;|$)/imx', $regs[1], $result, PREG_PATTERN_ORDER);

	$priority = array('Android', 'Xbox');
	$result['platform'] = array_unique($result['platform']);
	if (count($result['platform']) > 1) {
	if ($keys = array_intersect($priority, $result['platform'])) {
	$data['platform'] = reset($keys);
	} else {
	$data['platform'] = $result['platform'][0];
	}
	} elseif (isset($result['platform'][0])) {
	$data['platform'] = $result['platform'][0];
	}
	}

	if ($data['platform'] == 'linux-gnu') {
	$data['platform'] = 'Linux';
	}
	if ($data['platform'] == 'CrOS') {
	$data['platform'] = 'Chrome OS';
	}

	preg_match_all('%(?P<browser>Camino|Kindle|Kindle\ Fire\ Build|Firefox|Safari|MSIE|AppleWebKit|Chrome|IEMobile|Opera|Silk|Lynx|Version|Wget|curl|PLAYSTATION\ \d+)
		(?:;?)
		(?:(?:[/ ])(?P<version>[0-9.]+)|/(?:[A-Z]*))%x', $u_agent, $result, PREG_PATTERN_ORDER);

			$key = 0;

			$data['browser'] = $result['browser'][0];
			$data['version'] = $result['version'][0];

			if (($key = array_search('Kindle Fire Build', $result['browser'])) !== false || ($key = array_search('Silk', $result['browser'])) !== false) {
			$data['browser'] = $result['browser'][$key] == 'Silk' ? 'Silk' : 'Kindle';
			$data['platform'] = 'Kindle Fire';
			if (!($data['version'] = $result['version'][$key])) {
			$data['version'] = $result['version'][array_search('Version', $result['browser'])];
			}
			} elseif (($key = array_search('Kindle', $result['browser'])) !== false) {
			$data['browser'] = $result['browser'][$key];
			$data['platform'] = 'Kindle';
			$data['version'] = $result['version'][$key];
			} elseif ($result['browser'][0] == 'AppleWebKit') {
			if (($data['platform'] == 'Android' && !($key = 0)) || $key = array_search('Chrome', $result['browser'])) {
			$data['browser'] = 'Chrome';
			if (($vkey = array_search('Version', $result['browser'])) !== false) {
			$key = $vkey;
			}
			} elseif ($data['platform'] == 'BlackBerry') {
			$data['browser'] = 'BlackBerry Browser';
			if (($vkey = array_search('Version', $result['browser'])) !== false) {
			$key = $vkey;
			}
			} elseif ($key = array_search('Safari', $result['browser'])) {
			$data['browser'] = 'Safari';
			if (($vkey = array_search('Version', $result['browser'])) !== false) {
			$key = $vkey;
			}
			}

			$data['version'] = $result['version'][$key];
			} elseif (($key = array_search('Opera', $result['browser'])) !== false) {
			$data['browser'] = $result['browser'][$key];
			$data['version'] = $result['version'][$key];
			if (($key = array_search('Version', $result['browser'])) !== false) {
			$data['version'] = $result['version'][$key];
			}
			} elseif ($result['browser'][0] == 'MSIE') {
			if ($key = array_search('IEMobile', $result['browser'])) {
			$data['browser'] = 'IEMobile';
			} else {
			$data['browser'] = 'MSIE';
			$key = 0;
			}
			$data['version'] = $result['version'][$key];
			} elseif ($key = array_search('PLAYSTATION 3', $result['browser']) !== false) {
			$data['platform'] = 'PLAYSTATION 3';
			$data['browser'] = 'NetFront';
			}
			return $data;
			}

			public static function send_json($args) {
			header('Content-Type: application/json');
			array_walk($args, function (&$arg) {
			$dirty = array('&amp;', ',');
			$clean = array('', '', '');
			$arg = str_replace($dirty, $clean, $arg);
			});
			#die(json_encode(self::make_array($args)));
			# JSON Vulnerability Protection - http://code.angularjs.org/1.1.5/docs/api/ng.$http
			die(")]}',\n" . json_encode(self::make_array($args)));
			}

			public static function array_random($arr, $num = 1) {
			shuffle($arr);
			$r = array();
			for ($i = 0; $i < $num; $i++)
			$r[] = $arr[$i];
			return $num == 1 ? $r[0] : $r;
			}

			public static function shuffle_assoc($list) {
			if (!is_array($list))
			return $list;

			$keys = array_keys($list);
			shuffle($keys);
			$random = array();
			foreach ($keys as $key)
			$random[$key] = $list[$key];

			return $random;
			}

			public static function rec_assoc_shuffle($array) {
			$ary_keys = array_keys($array);
			$ary_values = array_values($array);
			shuffle($ary_values);
			foreach ($ary_keys as $key => $value) {
			if (is_array($ary_values[$key]) AND $ary_values[$key] != NULL) {
			$ary_values[$key] = self::rec_assoc_shuffle($ary_values[$key]);
			}
			$new[$value] = $ary_values[$key];
			}
			return $new;
			}

			public static function check_outside_file($url) {
			return true;
			//return @file_get_contents($url, NULL, NULL, 0, 1) === false ? false : true; //Slow as shitttttttt -_-"
			/*
			$ret = false;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt_array($ch, array(CURLOPT_HEADER => true, CURLOPT_NOBODY => true));
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'HEAD');
			if (curl_exec($ch))
			$ret = true;
			curl_close($ch);
			return $ret;
			*/
			}

			public static function arrayToObject($d) {
			if (is_array($d)) {
			return (object) array_map(__FUNCTION__, $d);
			} else {
			// Return object
			return $d;
			}
			}

			}

			//$string = 'abcdefg1234567lk.j098-?@><_+!';
			//Vija::filter_anon($string, 'alpha', array('456', '\-', '!', '.'), '-');
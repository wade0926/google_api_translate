<?php
$text = 'book';
echo translate($text);

function translate($text,$which_method = 1,$source_lang = 'en',$to_lang = 'zh-TW')
{
	$text = urlencode($text);
	
	switch($which_method)
	{
		//免費的api
		case 1:
			$ch = curl_init('https://translate.googleapis.com/translate_a/single?client=gtx&sl='.$source_lang.'&tl='.$to_lang.'&dt=t&q='.$text);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
			curl_setopt($ch,CURLOPT_HTTPHEADER,array('User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36'));
			$res = curl_exec($ch);
			curl_close($ch);
			
			preg_match('/\[\[\[\"(.*?)\"/',$res,$res_preg);
			return $res_preg[1];
		break;
		
		//正規，超量要收費的方法
		case 2:
			require_once('../pd/google_api_translate_key.php');
			
			$ch = curl_init('https://www.googleapis.com/language/translate/v2?key='.google_api_translate_key.'&source='.$source_lang.'&target='.$to_lang.'&q='.$text);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
			$res = curl_exec($ch);
			curl_close($ch);
			
			return $res;			
		break;		
	}
}
?>
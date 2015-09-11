<?php
$text = 'book';
echo translate($text);

function translate($text,$which_method = 2,$source_lang = 'en',$to_lang = 'zh-TW')
{
	$text = urlencode($text);
	
	switch($which_method)
	{
		//免費的api 方法
		case 1:
			$ch = curl_init('https://translate.googleapis.com/translate_a/single?client=gtx&sl='.$source_lang.'&tl='.$to_lang.'&dt=t&q='.$text);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
			curl_setopt($ch,CURLOPT_HTTPHEADER,array('User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36'));
			$res = curl_exec($ch);
			curl_close($ch);
			
			preg_match('/\[\[\[\"(.*?)\"/',$res,$res_preg);
			return $res_preg[1];
			
			//預告下星期厲害的分享。為什麼網路找不到答案？
		break;
		
		//正規，超量要收費的方法		
		case 2:
			//1. 收費方式：每次累積計量到100 萬個字元，收20塊美金(600多台幣)。如：a book = 6 個字元(空白也算)。翻一個中文也算一個字元
			require_once('../pd/google_api_translate_key.php');
						
			$ch = curl_init('https://www.googleapis.com/language/translate/v2?key='.google_api_translate_key.'&source='.$source_lang.'&target='.$to_lang.'&q='.$text);									
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
			$res = curl_exec($ch);
			curl_close($ch);		
									
			$res = json_decode($res,true);
			return $res['data']['translations'][0]['translatedText'];			
		break;
		
		//備案
		case 3:
		    //1. yandex：拿key 要留email、沒繁體(沒試過)			
			//   https://tech.yandex.com/translate/ 
			
			//2. zho.hablaa.com，只能單字、答案太多、翻不準： 			
			$target_url = 'http://hablaa.com/hs/translation/'.$text.'/eng-chi/';
			$res = file_get_contents($target_url);
			$res = json_decode($res);
			echo '<pre>';
			print_r($res);  			
		break;
	}
}
?>
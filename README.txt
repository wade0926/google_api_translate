1. 搜尋關鍵字：translate free api
2. *** Google：
 (1) 來源： http://ctrlq.org/code/19909-google-translate-api
 (2) 使用範例：
     $ch = curl_init('https://translate.googleapis.com/translate_a/single?client=gtx&sl='.$form_lang.'&tl='.$to_lang.'&dt=t&q='.urlencode($text));
     curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
     curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
     curl_setopt($ch,CURLOPT_HTTPHEADER,array('User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36'));
     $res = curl_exec($ch);
     curl_close($ch);
	
     preg_match('/\[\[\[\"(.*?)\"/',$res,$res_preg);
     return $res_preg[1];

3. http://zho.hablaa.com/api/   ：
   $translate_word = 'drink';
   $target_url = 'http://hablaa.com/hs/translation/'.$translate_word.'/eng-chi/';
   $res = file_get_contents($target_url);
   $res = json_decode($res);
   echo '<pre>';
   print_r($res);
<?php
#**********************************************#
# AutoRepost Facebook with Unicode Text PHP    *
# Find me :                                    *
# https://www.facebook.com/mr.foxdhan          *
# https://www.instagram.com/ramadhani.pratama  *
#**********************************************#

class Facebook
{
	public $access_token;
	public $normalText;
	public $target;
	public $style;
	function __construct(){
		#####SETTINGS#####
		$this->access_token = "EAA....."; //access_token facebook
		$this->target = "134484603292036"; //target user id/fp id
		$this->normalText = "yes"; //yes //no
		$this->style = 'Italic+sans+serif';
	}
	public function getFeed(){
		if(file_exists('log_status')){
			$log=json_encode(file('log_status'));
		}else{
			$log='';
		}
		$data = $this->curl("https://graph.facebook.com/".$this->target."/feed?fields=id,message,type&limit=5&access_token=".$this->access_token);
		$data = json_decode($data);
		foreach ($data->data as $key => $data) {
			$hitung_kata = strlen($data->message);
			if($hitung_kata >= 130){
				if($data->type=='link'){}else{
					if(!preg_match("/JUAL|jual|Jual|FOLLOW|Follow|follow|LIKE|Like|like|KOMEN|Komen|komen|Comment|COMMENT|comment|Hub|HUB|hub|KUNJUNGI|Kunjungi|kunjungi|VISIT|Visit|visit/i", @$data->message)){
						if(!preg_match("/".$data->id."/",$log)){
          					$x=$data->id."\n";
          					$y=fopen('log_status','a');
          					fwrite($y,$x);
          					fclose($y);
          					print 'status terbaru muncul.. repost .....<br>';
          					$this->postStatus($data->message);
						}else{
							print 'tidak ada status terbaru<br>';
						}
					}
				}
			}
		}
	}
	public function postStatus($text){
		if($this->normalText =='no'){
			$data = file_get_contents('https://id.8x.cc/random/fancy/fancy.php?style='.$this->style.'&text='.urlencode($text));
			$data = preg_match("'<h2 class=\"red\">(.*?)</h2>'", $data, $match);
			$status = $match[1];
		}else{
			$status = $text;
		}
		$req = $this->curl("https://graph.facebook.com/me/feed",
			array(
				"message" => $status,
				"method" => "post",
				"access_token" => $this->access_token)
		);
		$req = json_decode($req);
		print '<pre>'.print_r($req,1);
		$this->likeStatus($req->id);
	}
	public function likeStatus($id_post){
		$req = $this->curl("https://graph.facebook.com/".$id_post."/likes",
			array(
				"method" => "post",
				"access_token" => $this->access_token)
		);
	}
	public function curl($url, $data=null) {
		$c = curl_init();
    	curl_setopt($c, CURLOPT_URL, $url);
    	if($data != null){
        	curl_setopt($c, CURLOPT_POST, true);
        	curl_setopt($c, CURLOPT_POSTFIELDS, $data);
    	}
    	curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
    	curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    	$result = curl_exec($c);
    	curl_close($c);
    	return $result;
	}
}

$data = new Facebook();
$data = $data->getFeed();

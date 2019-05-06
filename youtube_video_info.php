
function youtube($url){
	var_dump("youtube");
	$data=ping($url);
	$data=html_entity_decode(stripslashes(urldecode($data)));
	$i=strpos($data, '"videoDetails":');
	$i+=strlen('"videoDetails":');
	if($i<100)return null;
	$crop=0;
	$temp="";
	for ($i; $i <strlen($data) ; $i++) { 
		if($data[$i]=="{")$crop+=1;
		if($data[$i]=="}")$crop-=1;
		if($crop>0)$temp.=$data[$i];
		else {$temp.="}";break;}
	}
	$data=json_decode($temp);
	$title=$data->title;
	$img=$data->thumbnail->thumbnails;
	if($img){
		$high_quality=["",0];
		foreach ($img as $info) {
			if($info->width>$high_quality[1]){
				$high_quality=[$info->url,$info->width];
			}
		}
		$img=$high_quality[0];
	}else $img="";
	if(!$title)$title="";
	return ["title"=>$title,"img"=>$img,"url"=>$url];

}

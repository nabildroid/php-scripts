<?php 
function blogger(){
	$data=ping("BLOGGER.com/atom.xml"); //it works only with atom.xml feed
	$data=html_entity_decode(urldecode($data),ENT_QUOTES);

	$posts_temp=[];
	$data=preg_split("/\<category.*?(\/\>)/",$data);
	foreach ($data as $post) 
		if(strlen($post)>100)$posts_temp[]=$post;
	array_shift($posts_temp);
	array_shift($posts_temp);

	$posts=[];
	foreach ($posts_temp as $post_temp) {
		$title=dom($post_temp,"<title")[0];
		$img=dom($post_temp,"<img",1,1)[0]["src"];
		$url=dom($post_temp,"rel='alternate'",1,1)[0]["href"];
		if(!$title||!$url||!$img)continue;
		$posts[]=["title"=>$title,"img"=>$img,"url"=>$url];
	}
	return $posts;	
}
?>

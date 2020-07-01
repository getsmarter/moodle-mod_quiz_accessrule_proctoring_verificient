<?php
function htmlframedata($qid,$cid){

	$htmlframe = "<div id='loadImg'><div><img src='accessrule/proctoring_verificient/loading.gif' /></div></div>
		<iframe id='proctortrack_iframe' src='accessrule/proctoring_verificient/launch.php?qid=$qid&cid=$cid' width='120%' height='450' onload='hideLoading()'>
		 <p>Your browser does not support iframes.</p>
		</iframe>";
	return $htmlframe;	
}

function htmlobjectdata($qid,$cid){

	$htmlframe = "<object id='contentframe' height='600px' width='100%' type='text/html' data='accessrule/proctoring_verificient/launch.php?qid=$qid&cid=$cid'></object>";
	return $htmlframe;	
}

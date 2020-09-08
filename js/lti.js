function proctoringlti(M,filename){
	    hideLoading();
		var iframe = document.getElementById('proctortrack_iframe');
		var iframe_parent_div = iframe.parentNode;
		iframe_parent_div.style.width='100%';
		iframe_parent_div.style.marginLeft = '0px';

		    if(!(document.getElementById('id_passwordheader') || document.getElementById('passwordheader'))){
		        window.history.go(-1);
		    }
		    if(filename=='startattempt.php') {
                document.getElementById('id_proctoring_verificientheader').style.display = 'none';
            }

		function hideSubmit() {
			if (filename=='startattempt.php') {
                document.getElementById('id_submitbutton').style.display = 'block';
                document.getElementById('id_cancel').style.display = 'block';
			}else{

                document.getElementById('id_submitbutton').style.display = 'none';
                document.getElementById('id_cancel').style.display = 'none';
            }
		   
		}

		function hidePass() {
	              if(document.getElementById('passwordheader')) {
	                document.getElementById('passwordheader').style.display = 'none';
	              }
		}

        var err = document.getElementsByClassName('error');
        if(err.length == 0) {
            hidePass();
	    setTimeout(hideSubmit, 3000);
        } else {
            if(err[0].classList.contains('fpassword')) {
		if(document.getElementById('proctoring_verificientheader')) {
	           document.getElementById('proctoring_verificientheader').style.display = 'none';
	        }
		if(document.getElementById('id_proctoring_verificientheader')) {
	            document.getElementById('id_proctoring_verificientheader').style.display = 'none';
		}
                
            } else {
                hidePass();
	        setTimeout(hideSubmit, 3000);
            }
    }
	
}

function hideLoading() {
  document.getElementById('loadImg').style.display='none';
}

function proctoringhidelti(){

		        if(document.getElementById('proctoring_verificientheader')) {
		            document.getElementById('proctoring_verificientheader').style.display = 'none';
		        }
			if(document.getElementById('id_proctoring_verificientheader')) {
		            document.getElementById('id_proctoring_verificientheader').style.display = 'none';
			}
		        //this may not hide iframe in other versions of moodle as id of element might be different, test with others and modify accordingly

	
}
/*<style>
#loadImg{position:absolute;z-index:999;}
#loadImg div{display:table-cell;width:1042px;height:550px;text-align:center;vertical-align:middle;}
</style>

 $html = $PAGE->requires->js_init_call("testlti");

*/

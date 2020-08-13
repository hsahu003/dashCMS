

//set base url here
const base_url = '/current-projects/CI/CI-TEMPLATE';

//generates url 
function site_url(url=''){
	return window.location.origin + base_url + '/' + url;
}



//function to apply one event function to multiple elements of same class
function grp_add_event(className,eventType,eventFun){
    //cheking if
    if (typeof className == 'string') {
        className = document.getElementsByClassName(className)
    }
    for(var i = 0; i < className.length; i++){
        className[i].addEventListener(eventType,eventFun.bind(this,i),false);
    }
}



//funxtion for ajax------------------------------------------------------------------
//parameters are {url,type(def:POST),data,asyncReq(def:true),onSuccess(){}}
function ajax(args){



	var url = args.url;
	var method_type = args.type || 'POST';
	var async = args.asyncReq || true;
    var hr = new XMLHttpRequest();
    hr.open(method_type,url,async);



    //if conyentType is set to be false set no content-type in request header
    if (typeof args.contentType == "string") 
    {
        hr.setRequestHeader("Content-type", args.contentType);
        //for testing
        var hello = 'string';
    }
    else if (args.contentType !== false ) 
    {
    	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        //for testing
        var hello = 'default';
    }

    
    hr.onreadystatechange = function(){

            //requet completed and response ready
      		if (hr.readyState == 4 && hr.status == 200) {
        		var return_data = hr.responseText;
        		args.onSuccess(return_data);	
      		}
    }

    //function to execture before sending the process
    if(typeof args.beforeSend != 'undefined')
    {
        args.beforeSend();
    }

   
    //send ajax request
    hr.send(args.data);

}
//function for ajax ENDS-----------------------------------------------------------

String.prototype.deleteWord = function (searchTerm) {
    var str = this;
    var n = str.search(searchTerm);
    while (str.search(searchTerm) > -1) {
        n = str.search(searchTerm);
        str = str.substring(0, n) + str.substring(n + searchTerm.length, str.length);
    }
    return str;
}


//function for including javascript files-------------------------------------------
function include(file) { 
  
  var script  = document.createElement('script'); 
  script.src  = file; 
  script.type = 'text/javascript'; 
  script.defer = true; 
  
  document.getElementsByTagName('head').item(0).appendChild(script); 
  
}


//---------------------------------function for lazy image load STARS--------------

function lazy_load_image(){
    var lazy_load = document.getElementsByClassName('lazy-image-load');
    const lth = lazy_load.length;
    console.log(lth);
    for (var i = 0; i < lth; i++){
        var src = lazy_load[i].getAttribute('src');

        if (src.includes("_thumb")) 
        {
            src = src.deleteWord('_thumb');
        }

        lazy_load[i].setAttribute('src',src);
        if ( i+1 == lth){
            var is_loaded = true
        }
    }

    

    if (is_loaded) {
        for (var i = 0; i < lth; i++){
            //removes the lazy-image-load class to remove thumb css
            objImg = new Image();
            objImg.src = lazy_load[0].getAttribute('src');
            objImg.onload = function() {
                lazy_load[0].classList.remove('lazy-image-load');
            }
        }
    }
}

//------------------Funcion to convert mili sec to minute and sec starts-------------------
function millis_to_minute_n_second(millis,notation=':') {
            var minutes = Math.floor(millis / 60000);
            var seconds = ((millis % 60000) / 1000).toFixed(0);
            return minutes + notation + (seconds < 10 ? '0' : '') + seconds;
        }

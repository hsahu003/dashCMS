
	const feature_name_container = document.getElementsByClassName('feature-name-container');
	const module_name = document.getElementsByClassName('module-name');
	const module_expand_btn = document.getElementsByClassName('module-expand-btn');

function sub_menu(i) {

	for (var k = 0; k < feature_name_container.length; k++) {
		
	}

	if (feature_name_container[i].classList.contains("feature-name-container-open")) {
		close_sub_menu(i);
	}else{
		
		for (var j = 0; j < feature_name_container.length; j++) {
			if (i == j) {
				open_sub_menu(j);
			}else if(feature_name_container[j].classList.contains("feature-name-container-open")){
				close_sub_menu(j);
			}
		}
	}

	//closing other modules tab
	}

function close_sub_menu(i) {
	feature_name_container[i].classList.remove("feature-name-container-open");
	feature_name_container[i].classList.add("feature-name-container-close");

	module_expand_btn[i].classList.remove("rotate-plus-90deg");
}

function open_sub_menu(i) {
	feature_name_container[i].classList.add("feature-name-container-open");
	feature_name_container[i].classList.remove("feature-name-container-close");

	module_expand_btn[i].classList.add("rotate-plus-90deg");
}

//calling the sub_menu function on all element belongs to .module-name
grp_add_event(document.getElementsByClassName('module-name'),"click",sub_menu);

/*
*
*
* function for uplaoding image with ajax for class .add-image-button
*
*
*/

/*function for common image upload feature*/
var common_image_input = document.getElementsByClassName('common-image-input');
var add_image_icon = document.getElementsByClassName('add-image-icon');
// var new_param = 0;
function common_upload_image(i,e){
	var url = common_image_input[i].getAttribute('data-url');
	if (url == null) {
		url = 'ajax/add-image';
	}
	var url = site_url(url);
	e.preventDefault();
	var file_data = common_image_input[i].files[0];
	var form_data = new FormData();
	form_data.append('file', file_data);
    

    //using ajax funtion
    ajax({
        url:url,
        data:form_data,
        contentType: false,
        beforeSend: function(){
            add_image_icon[i].setAttribute('src',site_url('assets/images/ajax-loader.gif'));
        },
        onSuccess: function(return_data){
            return_data = JSON.parse(return_data);
            console.log(return_data.image_path);
            console.log('processed');
            
            document.getElementsByClassName('add-image-btn-label')[i].style.display = "none";
            document.getElementsByClassName('image-uploded')[i].style.display = "flex";
            document.getElementsByClassName('image-uploded')[i].getElementsByTagName("img")[0].setAttribute("src", return_data.image);
            document.getElementsByClassName('ajax_image_return')[i].value = return_data.image_path;

            //creates new upload button on uploading image
            if (e.target.parentElement.parentElement.classList.contains('multiple-image-button') == true) {
                // //clone new add image section
                // var newAddImage =  e.target.parentElement.parentElement;
                // var clone = newAddImage.cloneNode(true);
                // console.log(clone);

                // //  //resetting the values if image has been uploaded
                // var image_upload_div = clone.getElementsByTagName('div')[0];
                // clone.getElementsByTagName('input')[0].value = '';

                // clone.getElementsByClassName('add-image-icon')[0].setAttribute('src',site_url('assets/images/admins/icons/add_icon.svg'));
                // clone.getElementsByClassName('add-image-btn-label')[0].style.display = "flex";
                // image_upload_div.style.display = 'none';
                // image_upload_div.getElementsByTagName('img')[0].setAttribute('src','');
                
                // //recalculating

                // new_param = new_param + 1;
                // console.log(new_param);
                // clone.getElementsByTagName('input')[0].setAttribute('onChange','common_upload_image('+ new_param + ','+ 'event' +')');
                // image_upload_div.getElementsByTagName('div')[0].setAttribute('onClick','common_remove_image('+ new_param + ','+ 'event' +')');
                // // //appending
                // e.target.parentElement.parentElement.parentElement.appendChild(clone);
            }
        }

    })
}

var common_remove_image_button = document.getElementsByClassName('common-remove-image-button');
function common_remove_image(i,e){
    //
	if (e.target.classList.contains('remove-image-icon')) {
		var url = common_remove_image_button[i].getElementsByTagName('img')[0].getAttribute('data-url');
		if (url == null) {
			url = 'ajax/remove-image';
		}
		var url = site_url(url);
		e.preventDefault();
		var image_uploaded = document.getElementsByClassName('image-uploded')[i].getElementsByTagName("img")[0].getAttribute("src");
    	var vars = "image_name="+image_uploaded;

        //using ajax function
    	ajax({
            url: url,
            data: vars,
            contentType: false,
            onSuccess: function(return_data){
                document.getElementsByClassName('add-image-btn-label')[i].style.display = "flex";
                document.getElementsByClassName('image-uploded')[i].style.display = "none";
                document.getElementsByClassName('image-uploded')[i].getElementsByTagName("img")[0].setAttribute("src", "");
                document.getElementsByClassName("common-image-input")[i].value= '';
                document.getElementsByClassName('add-image-icon')[i].setAttribute('src',site_url('assets/images/admins/icons/add_icon.svg'));
                //this prevents entire feature image button container from deleteing
                if ((e.target.parentElement.parentElement.parentElement.classList.contains('multiple-image-button') == true)) {
                    e.target.parentElement.parentElement.parentElement.style.display = 'none';
                }
                console.log(return_data);
            }
        })
 	}
}



//calling the common_upload_image function on all element belongs to the respective class
grp_add_event(common_image_input,"change",common_upload_image);
grp_add_event(common_remove_image_button,"click",common_remove_image);


    var image_input = document.getElementsByClassName('image-input');
    function upload_image(i,e){
    	var url = site_url('ajax/upload_image');
    	e.preventDefault();
    	var file_data = image_input[i].files[0];
    	console.log(e.target.parentElement.parentElement.classList);
    	var form_data = new FormData();
        form_data.append('file', file_data);
        

        var hr = new XMLHttpRequest();

        hr.open("POST",url,true);

        hr.onreadystatechange = function(){
            console.log(hr.status + ' ' + hr.readyState);
          if (hr.readyState == 4 && hr.status == 200) {
            var return_data = hr.responseText;
            console.log(return_data);
            
            if (e.target.parentElement.parentElement.classList.contains('featured-image-button') == false) {
            		//clone new add image section
            		var newAddImage =  document.getElementsByClassName('add-image-button')[0];
            		var clone = newAddImage.cloneNode(true);

           		 	//resetting the values if image has been uploaded
           		 	clone.classList.remove('featured-image-button');
            		var image_upload_div = clone.getElementsByTagName('div')[0];
            		clone.getElementsByTagName('input')[0].value = '';

            		var add_image_btn_label = clone.getElementsByTagName('label')[0];
            		add_image_btn_label.style.display = 'flex';
            		image_upload_div.style.display = 'none';
            		image_upload_div.getElementsByTagName('img')[0].setAttribute('src','');
            		image_input = document.getElementsByClassName('image-input');
            		

            		//recalculating

            		var new_param = image_input.length;
            		clone.getElementsByTagName('input')[0].setAttribute('onChange','upload_image('+ new_param + ','+ 'event' +')');
            		image_upload_div.getElementsByTagName('div')[0].setAttribute('onClick','remove_image('+ new_param + ','+ 'event' +')');
            		var news_gallary_images = document.getElementsByClassName('news-gallary-images')[0];
            		news_gallary_images.appendChild(clone);
            }
            



            document.getElementsByClassName('add-image-btn-label')[i].style.display = "none";
            document.getElementsByClassName('image-uploded')[i].style.display = "flex";
            document.getElementsByClassName('image-uploded')[i].getElementsByTagName("img")[0].setAttribute("src", "../../assets/images/uploads/" + return_data);

          }
        }

        hr.send(form_data);
    }


    var remove_image_button = document.getElementsByClassName('remove-image-button')
    function remove_image(i,e){

    	if (e.target.classList.contains('add-image-icon')) {

    		var url = '../../ajax/remove_image';
    		e.preventDefault();
    		var image_uploaded = document.getElementsByClassName('image-uploded')[i].getElementsByTagName("img")[0].getAttribute("src");
        	var hr = new XMLHttpRequest();
        	var vars = "image_name="+image_uploaded;
        	hr.open("POST",url,true);
        	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        	hr.onreadystatechange = function(){
          		if (hr.readyState == 4 && hr.status == 200) {
            		var return_data = hr.responseText;
            		document.getElementsByClassName('add-image-btn-label')[i].style.display = "flex";
                	document.getElementsByClassName('image-uploded')[i].style.display = "none";
                	document.getElementsByClassName('image-uploded')[i].getElementsByTagName("img")[0].setAttribute("src", "");
                	document.getElementsByClassName("image-input")[i].value= '';
                	//this prevents entire feature image button container from deleteing
                	if ((e.target.parentElement.parentElement.parentElement.classList.contains('featured-image-button') == false)) {
                		e.target.parentElement.parentElement.parentElement.style.display = 'none';
                	}
            		
          		}
        	}

        // send the data to PHP now... and wait for respone to update the status div

        	hr.send(vars);
     	}
    }


//dashboard news module add tag features
const add_tag_btn = document.getElementById('add-tag');
const news_tags_input = document.getElementById('news-tags');
const remove_tag = document.getElementsByClassName('remove-tag');

//event listener
if (add_tag_btn != null) {
	add_tag_btn.addEventListener('click', add_tag);
	news_tags_input.addEventListener("keyup", add_tag);
}


//function for tags
function add_tag(event){

	if ((event.keyCode === 13 || event.type === 'click') && news_tags_input.value != '' ){
		var div_container = document.createElement("div");
		div_container.classList.add('container','tags-added','mr-2');
		var div_row = document.createElement("div");
		div_row.classList.add('row','space-between','width-100');
		var div_col = document.createElement("div");
		div_col.classList.add('col');
		div_col.innerHTML = news_tags_input.value;
		div_row.appendChild(div_col);
		var div_col_times = document.createElement("div");

		div_col_times.setAttribute('onClick','remove_tag_fn('+ remove_tag.length + ',' + 'event' + ')');
		div_col_times.classList.add('col', 'ml-2','remove-tag');
		div_col_times.innerHTML = '<i class="fas fa-times-circle"></i>';
		div_row.appendChild(div_col_times);
		div_container.appendChild(div_row);
		console.log(div_container); 

		//appending in tags-added-container
		const tags_added_container = document.getElementById('tags-added-container');
		tags_added_container.appendChild(div_container);
		//emptying the input field
		news_tags_input.value = '';
	}
}

function remove_tag_fn(i,event){
	var tag = event.target.parentElement.parentElement.parentElement;
	tag.remove();
	
}

//--------------------------------function for error-display-container STARTS-----------------------------------------------//
var error_display_container = document.getElementsByClassName('error-display-container');
var error_container = document.getElementsByClassName('error-container');
/*
* this function is called when the window loads
*/
function display_err(errMessage='',i,e){

    /*if no messgae is passed, but when 
    * message is already inside error_container
    * for PHP scripts
    */  
    //                                             
    if (
            errMessage == '' 
            && error_display_container[0] != undefined 
            && error_container[0].innerText.trim().length != 0
        ) 
    {
        
        var c = error_display_container[0].children.length;
        for(var i = 0; i < c; i++)
        {   
            if (error_container[i].innerText != '') 
            {
                error_container[i].style.display = 'flex';
                console.log('leaking from here');
            }
        }
    }
    //when a messaage is passed, for javascript scripts
    else if (errMessage != '')
    {   
        /*if errMessage is passed as an string then
        * convert it into an array with one item.
        */
        if (typeof errMessage == "string") 
        {  
            errMessage = errMessage.split();
        }

        //displays the error(s)
    for(var i = 0; i < errMessage.length; i++)
    {   
        //if more than one message to display
        if (i > 0) 
        {
            var cln = error_container[0].cloneNode(true);
            cln.innerText = '';
            error_display_container[0].appendChild(cln);
        }
        error_container[i].innerText = errMessage[i]; 
        error_container[i].style.display = 'flex';
    }
    }
    
}
//--------------------------------function for error-display-container ENDS-----------------------------------------------//



//-----------------------------------------careousel slider--------------------------------------------//


/*loading functions*/
window.onload = function(){
    display_err();
    lazy_load_image();

    if (document.getElementById('carousel-slider') != undefined) {
        //carausel slider
        slider('#carousel-slider',{
                paginationDot: true,
                paginationNumber: true,
                initialSlide: 0,
                //number of cards at one slide
                cardsAtOnce: 1,
                doSetInterval:true,
                interval:'3000'
        });
    }
}

//function for slider STARS----------------------------------------------------------------------
function slider(target,params)
{   
    var cardsAtOnce =  params.cardsAtOnce || 1;
    var doSetInterval =  params.doSetInterval || false;
    var interval = params.interval || 3000;
    
    switch(window.innerWidth){
        //for xs devices
        case(window.innerWidth <= 320 ? window.innerWidth : 320):
            //if cardsAtOnce_xsm (<=320) is passed
            if (params.cardsAtOnce_xsm != null) 
            {
                cardsAtOnce = params.cardsAtOnce_xsm;
            }
            else if(params.cardsAtOnce_sm != null)
            {
                cardsAtOnce = params.cardsAtOnce_sm;
            }
            break;
        //for sm devices
        case(window.innerWidth <= 500 ? window.innerWidth : 500):
            //if cardsAtOnce_sm (<=500) is passed
            cardsAtOnce = params.cardsAtOnce_sm != null ? params.cardsAtOnce_sm : cardsAtOnce;
            break;
        //for md devices
        case(window.innerWidth <= 768 ? window.innerWidth : 768):
            //if cardsAtOnce_md (<=768) is passed
            cardsAtOnce = params.cardsAtOnce_md != null ? params.cardsAtOnce_md : cardsAtOnce;
            break;
        //for lg devices
        case(window.innerWidth <= 1024 ? window.innerWidth : 1024):
            //if cardsAtOnce_md (<=768) is passed
            cardsAtOnce = params.cardsAtOnce_lg != null ? params.cardsAtOnce_lg : cardsAtOnce;
            break;
        //for xlg devices
        case(window.innerWidth <= 1200 ? window.innerWidth : 1200):
            //if cardsAtOnce_md (<=768) is passed
            cardsAtOnce = params.cardsAtOnce_xlg != null ? params.cardsAtOnce_xlg : cardsAtOnce;
            break;
    }

    //id or class
    if (target[0] == '#') 
    {
        //removes the #
        target = target.replace('#', '');
        var slider_container = document.getElementById(target);
    }
    else if(target[0] == '.') 
    {
        //removes the .
        target = target.replace('.', '');
        //unique and only one class
        var slider_container = document.getElementsByClassName(target)[0];
    }
    else
    {
        console.log('invalid')
    }

    // if target is not passed or wrong class is passed
    if (slider_container != null || slider_container != undefined) {
   
        //slide next and previous

        //returns slider container's width
        function get_slider_container_width()
        {   
            // to avoid console error that slider_container is null       
            
                return slider_container.offsetWidth;
            
            
        }
        console.log('slider_container_width: ' + get_slider_container_width());
        var slider_wrapper = slider_container.getElementsByClassName('slider-wrapper')[0];
        var slider_slide = slider_wrapper.getElementsByClassName('slider-slide');
        var slide_count = 0;

        //how many total slides
        var slide_number = Math.ceil(slider_slide.length/cardsAtOnce);



        //selectors for sliders
        var slider_next_btn = slider_container.getElementsByClassName('slider-next-btn')[0];
        var slider_prev_btn = slider_container.getElementsByClassName('slider-prev-btn')[0];

        //event listeners for sliders
        slider_next_btn.addEventListener('click',next_slide_click)
        slider_prev_btn.addEventListener('click',prev_slide_click);

        function next_slide_click(){
            next_slide()
            //if someone clicks prev or next control btn it stops the automatic slide
            clearInterval(sliderInterval);
        }

        function prev_slide_click(){
            prev_slide()
            //if someone clicks prev or next control btn it stops the automatic slide
            clearInterval(sliderInterval);
        }

        //fuctions for slider
        function next_slide()
        {
            slide_count++;
            slide(slide_count)
        }

        function prev_slide()
        {   
            //when slider count reaches 0 it resets slider count to 1 
            if (slide_count == 0) 
            {
                slide_count = 1;
            }

            slide_count--;
            slide(slide_count);
            //reverse slide if slide count is zero
            // if (true && slide_count == 0) {
            //     slider_wrapper.style.transform = "translate3d(1200px)";
            //     console.log('its happening');
            // }
        }

        
        //pagination STARTS----------------------------------------------------------------------

        var slider_pagination = slider_container.getElementsByClassName('slider-pagination')[0];
        if (slider_pagination != null) {
            //var for paginations
            var last_pagination_bullet;

            //creating pagination bullets dynamically
            function create_pagination_bullet_fn(){
            
                for (var i = 0; i < slide_number; i++) 
                {
                    var create_pagination_bullet = document.createElement("div");
                    create_pagination_bullet.classList.add('slider-pagination-bullet');
                    slider_pagination.appendChild(create_pagination_bullet);
                }
                
            }
            //calling the function
            create_pagination_bullet_fn();

            //selectors for paginaion
            var slider_pagination_bulltes = slider_pagination.getElementsByClassName('slider-pagination-bullet');

            //eventListeners for pagination
            grp_add_event(slider_pagination_bulltes,'click',pagination_slide)

            //functions for pagination
            function pagination_slide(i){
                slide(i)
            }


        }
        

        

        //functions for slide
        function slide(i){

            //removing style from last pagination bullet
            if (last_pagination_bullet != null) {
                slider_pagination_bulltes[last_pagination_bullet].style.backgroundColor = '#ffffff85';
                slider_pagination_bulltes[last_pagination_bullet].style.transform = 'scale(1)';
            }

            //resets the slider when it reaches it's end point
            if (i == slide_number) {
                slider_wrapper.style.transform = "translate3d(0px, 0px, 0px)";
                i = 0;
            }


            slider_wrapper.style.transform = 'translate3d' + '(-' + get_slider_container_width() * i + 'px, 0px, 0px)';
            slide_count = i;
            console.log('slider_container_width:' + get_slider_container_width());

            //do this if pagination exists in HTML
            if (slider_pagination != null) {
                slider_pagination_bulltes[i].style.backgroundColor = '#58585894';
                slider_pagination_bulltes[i].style.transform = 'scale(1.1)';
                last_pagination_bullet = i;
            }
            

        } 
        
        //slide changes after certain time
        if (doSetInterval == true) {
            var sliderInterval = setInterval(next_slide, interval);
        }
        //slide pauses if mouse hover over
        var x1 = false;
        var time = 0;

        slider_container.addEventListener('mouseenter', function(){
            x1 = true;
            time++;
            console.log('time: ' + time);
        });
        slider_container.addEventListener('mouseleave', function(){
            x1 = false;
        });

    }

}
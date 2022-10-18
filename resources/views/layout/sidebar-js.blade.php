<script>
    $(document).ready(function() {
            var url = window.location;
          // console.log(url);

        
            var element = $('ul.navigation-main .menu-content li a').filter(function() {
        //     console.log(this.href == url);
            //   console.log(this);
               //element.closest('.nav-item').addClass('show');
            // console.log(url+' '+this.href);
         //   $(this).closest('.nav-item').addClass('open');
            return this.href == url /* || url.href.indexOf(this.href) == 0; */ }).addClass('active');
            if (element.is('li>ul>li>a')) {
                element.parent().parent().parent().addClass('active');
                element.parent().parent().parent().children(':first-child').prop('aria-expanded','true');
                element.parent().parent().addClass('show');
                element.removeClass('mm-active');
                if( url == element.attr('href')){
                        element.filter(function(){
                                // console.log('filter');
                                return this.href == url;
                        }).addClass('mm-active');
                        // console.log('if');
                } else {
                        // console.log('else');
                        element.addClass('mm-active');
                }
                // console.log(element);
                }
        });
</script>
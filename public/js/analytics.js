/**
 * Name: Google Analytics.js
 * Purpose:
 * Package: public/js
 * Created on: 19th September, 2016
 * Author: msfi-krishnadev
*/

// Declaration of all global variables
var userId, track_id, hit_type, information;
var socail_network, social_action, social_target;

var analysis = {

   /**
    * Function which handles all DOM events
    *
    * @param: void
    * @return: void  
    */
    global: function() {

        $(document).ready( function() {

            user_id = $('#userId').val();
            track_id = $('#track_id').val();

            // Facebook Login Social Hit Data
            $(".facebook").on('click', function() {

                information = {
                    hitType: $(this).data('hit'), 
                    SocialNetwork: 'Facebook',
                    SocialAction: 'Login',
                    SocialTarget: 'http://laravel.local.com/login',
                    hitCallback: function() {
                    console.log('send successfully');
                    }
                };

                userId = null;

                // Sending the data to analytics
                analysis.analytics(userId, track_id, information );
            });

            // Instagram Login Social Hit Data
            $(".instagram").on('click', function() {

                information = {
                    hitType: $(this).data('hit'), 
                    SocialNetwork: 'Instagram',
                    SocialAction: 'Login',
                    SocialTarget: 'http://laravel.local.com/login',
                    hitCallback: function() {
                    console.log('send successfully');
                    }
                };

                userId = null;

                // Sending the data to analytics
                analysis.analytics(userId, track_id, information );
            });
            
            analysis.analytics(userId, track_id);
        });
    },

    /**
     * Function to perform google analytics
     * 
     * @param: void
     * @return: void
    */
    analytics: function(user_id, track_id, information=null) {

        window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
       
        ga('create', track_id, 'auto'); // creating the track id of the user
        ga('set', 'userId', user_id); // setting the client as tracker

        if ( information != null)
        {
            ga('send', information);
        }

        ga('send', 'pageview');
    
    }
};

analysis.global();
/**
 * Name: Google Analytics.js
 * Purpose:
 * Package: public/js
 * Created on: 19th September, 2016
 * Author: msfi-krishnadev
*/

// Declaration of all global variables
var userId, track_id;

var analysis = {

   /**
    * Function which handles all DOM events
    *
    * @param: void
    * @return: void  
    */
    global: function() {

        $(document).ready( function() {

            userId = $('#userId').val();
            track_id = $('#track_id').val();

            analysis.analytics(userId, track_id);
        });
    },

    /**
     * Function to perform google analytics
     * 
     * @param: void
     * @return: void
    */
    analytics: function(userId, track_id) {

        window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
        ga('create', track_id, 'auto');
        ga('set', 'userId', userId);
        ga('send', 'pageview');
    }
};

analysis.global();
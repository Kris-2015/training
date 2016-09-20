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
            hit_type = $('#hit').val(); // Get the hit type of the page
            
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
        
        ga('create', track_id, 'auto'); // creating the track id of the user
        ga('set', 'userId', userId); // setting the client as tracker
        ga('send', 'pageview'); // hit type: page

        console.log(ga.q);
    }
};

analysis.global();
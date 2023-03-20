// Code (c) Kieran Metcalfe / Ascent Creative 2023
$.ascent = $.ascent?$.ascent:{};

var MailchimpSubscriptionStatus = {
        
		_init: function () {
            
			var self = this;
			this.widget = this;
			
            this.element.addClass("initialised");

            $(this.element).on('click', '.mailchimp-action', function(e) {

                $(self.element).css('opacity', 0.2);
                e.preventDefault();

                $.ajax({
                    type: 'get',
                    url: $(this).attr('href'),
                }).done(function(data) {
                    // $(self.element).html(data);
                    self.loadStatus();
                }).fail(function(data) {
                    alert(data.responseJSON.message);
                    $(self.element).css('opacity', 1);
                });

                return false;


            });

            this.loadStatus();


		},

        loadStatus: function() {

            let self = this;

            $.ajax({
                type: 'get',
                url: '/mailchimp/renderstatus',
            }).done(function(data) {
                $(self.element).html(data);
                $(self.element).css('opacity', 1);
            }).fail(function(data) {
                alert(data.responseJSON.message);
                $(self.element).css('opacity', 1);
            });

        }

    
       
}

$.widget('ascent.mailchimpsubscriptionstatus', MailchimpSubscriptionStatus);
$.extend($.ascent.MailchimpSubscriptionStatus, {
		 
		
}); 


$(document).ready(function() {
    $('.mailchimp-subscription-status:not(.initialised)').mailchimpsubscriptionstatus();
});


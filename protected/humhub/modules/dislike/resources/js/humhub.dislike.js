humhub.module('dislike', function (module, require, $) {
    var client = require('client');
    var additions = require('ui.additions');
    var Component = require('action').Component;

    var toggleDislike = function (evt) {
        client.post(evt).then(function (response) {
            if(response.currentUserDisliked) {
                additions.switchButtons(evt.$trigger, evt.$trigger.siblings('.undislike'));
                var component = Component.closest(evt.$trigger);
                if(component) {
                    component.$.trigger('humhub:dislike:disliked');
                }
            } else {
                additions.switchButtons(evt.$trigger, evt.$trigger.siblings('.dislike'));
            }
            
            _updateCounter(evt.$trigger.parent(), response.dislikeCounter);
        }).catch(function (err) {
            module.log.error(err, true);
        });
    };

    var _updateCounter = function($element, count) {
        if (count) {
            $element.find(".dislikeCount").html('(' + count + ')').show();
        } else {
            $element.find(".dislikeCount").hide();
        }

    };

    module.export({
        toggleDislike: toggleDislike
    });
});

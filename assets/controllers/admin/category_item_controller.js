import { Controller } from '@hotwired/stimulus';

const timelineSelector = "#timeline-carousel";

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    connect() {
        $(timelineSelector).owlCarousel({
            items: 1,
            loop: false,
            margin:0,
            nav: true,
            navText : ["<i class='mdi mdi-chevron-left'></i>","<i class='mdi mdi-chevron-right'></i>"],
            dots: false,
            responsive:{
                576:{
                    items:2
                },

                768:{
                    items:4
                },
            }
        });

        $('#timeline-carousel .event-list').each((i, e) => {
            if ($(e).hasClass('active')) {
                $(timelineSelector).trigger("to.owl.carousel", [i, 1])
            }
        })
    }
}
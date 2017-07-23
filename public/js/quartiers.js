$(document).ready(function() {

    var is_in_svg = false;
    var color;
    var color_touch;
    var drop_counter = 0;
    var correct = 0;
    var wrong = 0;
    var quart_correct = [];
    var user_id = document.cookie.split("=")[1];

    // Define an object that relates the id of the dragged element to the color of the correct polygon
    var id_color = {
        quart_1 : '#D7FCEB', quart_2 : '#EAB3FC', quart_3 : '#FCB3B3', quart_4 : '#B8D0FC',
        quart_5 : '#FCEDB3', quart_6 : '#C3FCB6', quart_7 : '#FCE3D7', quart_8 : '#FCCCEB',
        quart_9 : '#B6EFFC', quart_10 : '#BEB8FC', quart_11 : '#BDFCD7', quart_12 : '#EDFCCF',
        quart_13 : '#E0CAFC', quart_14 : '#FCCEB3', quart_15 : '#EDFCB3', quart_16 : '#D4E8FC',
        quart_17 : '#FCB3D9', quart_18 : '#FCCFD4'
        }

    // $(document).on('mousemove', function(event) {
    //     console.log("pageX= " + event.pageX + "PageY= " + event.pageY);
    // });

    // A hover effect: change the color of the plygon's border when the mouse enter the polygon
    $('path').mouseenter(function () {
        $(this).css('stroke' , '#C36', );
        $(this).css('stroke-width', '4');

    });
    $('path').mouseleave(function () {
        $(this).css("stroke", '');
        $(this).css('stroke-width', '');
    });


    // To detemine the polygon on which the mouse exists we used 'fill' instead of
    // id because jquery events were much better in catching the 'fill' attribute
    // than the 'id' attribute
    $('path').mouseover(function() {
        // color = $(this).attr('fill');
        is_in_svg = true;
        console.log(color);
    })


    // Determine whether the mouse is inside the SVG element or not
    $("#Layers").mouseover(function(e) {
        is_in_svg = true;
    });
    $("#Layers").mouseleave(function(e) {
        is_in_svg = false;
    });


    // A function to shorten the names of the neighborhoods
    function shorten_name(name) {
        if (name.slice(-1) !== '.') {
        var name_list = name.split("-");
        return '<i class="fa fa-map-marker" aria-hidden="true"></i>' +
             "  " + name_list[0] + " ...";
        }
    }

    // Shorten the name of the neighborhood when start dragging to better present it on the map
    $(".drag-me").mousedown(function() {
        $(this).html(shorten_name($(this).text()));
    });

    // Make the neighborhood names draggable
    $(".drag-me").draggable({
        cancel: false,
        drag: function(e, ui) {
            $(this).parent().css('overflow', 'visible'); // To make the name visible outside the button
        },
        // Determine where to accept dropping the element and where to revert it
        revert: function(e) {
            var revert_offset = $(this).offset();  // The current postion of the dragged element
            // To select the polygon overwhich the drop is happening
            // the elementFromPoint() method returns only the top element in the page at the specified position
            // which is in our case the dragged name itself. To solve this, we hide the dragged text just before the
            // execution of the method and show it again after that.
            $(this).hide();
            var element = document.elementFromPoint(revert_offset.left + 5, revert_offset.top + 15);
            var element2;
            console.log('element : '  + $(element).prop('tagName'));
            // We add a second hide/show loop to handle the case where there is another text above the polygon
            if ($(element).prop('tagName') != 'path') {
                $(element).hide();
                element2 = document.elementFromPoint(revert_offset.left, revert_offset.top);
                console.log('element2 : '  + $(element2).prop('tagName'));
                $(element).show();
                element = element2;
            }
            $(this).show();

            // Check if the dragged element is over a plygon or not
            if (is_in_svg || $(element).prop('tagName') == 'path') {
                return false;
            }
            return true;
        },
        revertDuration: 200,
        // offset the mouse cursor to stop the dragged text from preventing the mouse events of the
        // polygons from happening
        cursorAt: { left: -5, bottom: -15 },
        // When the drop happen
        stop: function() {
            var drop_offset = $(this).offset(); // The current postion of the dropped element
            $(this).hide();
            // the offset() method practically gives the coordinates of the top left corner of the element
            // including the border and padding. To get the coordinates of the bottom of the marker we added
            // 5 px to X and add 15 px to Y
            var element = document.elementFromPoint(drop_offset.left + 5, drop_offset.top + 15);
            console.log("Drop postion " + drop_offset.left + "  " +  drop_offset.top);
            console.log("corrected postion " + (drop_offset.left + 5) + "  " +  (drop_offset.top + 15)) ;
            if ($(element).prop('tagName') != 'path') {
                $(element).hide();
                element2 = document.elementFromPoint(drop_offset.left, drop_offset.top);
                console.log('element2 : '  + $(element2).prop('tagName'));
                $(element).show();
                element = element2;
            }
            $(this).show();
            color_touch = $(element).attr('fill');
            console.log('element_fill: ' + color_touch);
            if (is_in_svg || color_touch) {
                drop_counter += 1;
                console.log(drop_counter);
                $("#drop-audio").get(0).play();
                $("path[fill='" + color_touch + "']").css("fill", '#555');
                $("path[fill='" + color_touch + "']").css("stroke", '#BBB');
                $("path[fill='" + color_touch + "']").css("opacity", '0.6');
            }

            if (color_touch == id_color[$(this).attr('id')]) {
                $(this).css("text-shadow", "1px 1px 1px black, 6px 6px 14px green");
                var quart_id = $(this).attr('id').split("_")[1];
                quart_correct.push(quart_id);
                console.log(quart_correct);
                correct += 1;
            } else {
                $(this).css("text-shadow", "1px 1px 1px black, 2px 2px 3px green, 6px 6px 14px red");
                wrong += 1;
            }

            // Use ajax to send the list of the correctly chosen neighborhoods with the user id
            // to the server
            if (drop_counter === 18) {
                $.ajax({ // begin ajax
                    url: '../private/ajax/quartiers.ajax.php',
                    type: 'GET',
                    data: {
                        'id' : user_id,
                        'quart_correct' : quart_correct
                    }
                }) // end ajax


                alert("Game Over!\n" + "You have " + correct + " right answers " + "and " +
                    wrong + " wrong answers.");
                }

        }
    });





    // // There is a problem with making the SVG polygons droppable using jQuery UI
    // // I found suggested solutions in:
    // // https://stackoverflow.com/questions/12402030/jquery-svg-making-objects-droppable

    // // another possible solution
    // // http://bl.ocks.org/thudfactor/6611441
    // $(".polygon").droppable({
    //     drop: function(event, ui) {
    //         alert("a name is dropped");
    //     }
    // })
})
$(".onlinepoll").click(function (e) {

    e.preventDefault();
    var value_id = $('input[name=OnlinePoll]:radio:checked').val();
    var poll_id = $('input[name=OnlinePollID]').val();

    var dataString = 'value_id=' + value_id + '&poll_id=' + poll_id;


    if (value_id == '' || value_id == null) { alert('Please select your option.'); }



    else {


        $(".pollbutton").fadeIn(200).after('<img style="float:left;" class="pollloader" src="' + file_url + 'images/ajax_loader_bar.gif" />');
        $(".onlinepoll").fadeOut();


        $.ajax({
            type: 'POST',
            url: site_url + "onlinepoll",
            data: dataString,
            cache: false,

            success: function (html) {
                console.log(html);
                $(".pollbutton").fadeIn(200).after('<p style="color:red;">' + html.total_vote + '</p>');
                $(".pollloader").hide();

            }
        });

    }








});

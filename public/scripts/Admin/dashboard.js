$(function(){

    const timeIn = ROOT + "assets/img/admin/Time-in.png";
    const timeOut = ROOT + "assets/img/admin/Time-out.png";

    const timeState = (element) => {
        var img = $(element).find('img');
        var src = img.attr('src');
        if(src.includes('Time-in.png')){
            img.attr('src', timeOut);
            $("#timeStatusText").text('Time In');
        } else {
            img.attr('src', timeIn);
            $("#timeStatusText").text('Time Out');
        }
    }

    const meetingState = (element) => {
        var statusText1 = $(element).find('small');
        var statusText2 = $('.d-flex.justify-content-center p');
        if (statusText1.text() === 'Meeting In' || statusText2.text() === 'Available') {
            statusText1.text('Meeting Out');
            statusText2.text('Not Available');
            statusText2.css('background-color', '#FFC5C5');
            statusText2.css('border', '1px solid #DF0404');
            statusText2.css('color', '#DF0404');
        } else {
            statusText1.text('Meeting In');
            statusText2.text('Available');
            statusText2.css('background-color', 'hsl(166, 58%, 78%)');
            statusText2.css('border', 'hsl(166, 100%, 26%)');
            statusText2.css('color', 'hsl(166, 100%, 26%)');
        }
    }

    const breakState = (element) => {
        var statusText = $(element).find('small');
        if (statusText.text() === 'Break In') {
            statusText.text('Break Out');
        } else {
            statusText.text('Break In');
        }
    }

    $("#timeToggle").click(function(e){
        e.preventDefault();
        var img = $(this).find('img');
        var src = img.attr('src');
        if(src.includes('Time-in.png')){
            httpRequest(0, true, this);            
        } else {
            httpRequest(0, false, this);            
        }
    });

    
    $('#breakToggle').click(function(e) {
        e.preventDefault();
        var statusText = $(this).find('small');
        if (statusText.text() === 'Break In') {
            httpRequest(1, true, this);
        } else {
            httpRequest(1, false, this);
        }
    });

    $('#meetingToggle').click(function(e) {
        e.preventDefault();
        var statusText1 = $(this).find('small');
        var statusText2 = $('.d-flex.justify-content-center p');
        if (statusText1.text() === 'Meeting In' && statusText2.text() === 'Available') {
            httpRequest(2, true, this);
        } else {
            httpRequest(2, false, this);
        }
    });
    
    const actionToggler = (response, element) => {
        switch(response) {
            case 0:
                timeState(element);
                break;
            case 1:
                breakState(element);
                break;
            case 2:
                meetingState(element);
                break;
            default:
                console.error('Invalid action');
                break
        }
    }

    const httpRequest = (action, status, element) => {
        $.ajax({
            url: "Admin/Status",
            method: "POST",
            data: JSON.stringify({
                action: action,
                status: status
            }),
            contentType: "application/json",
            processData: false,
            success: function(response){
                actionToggler(response.operation, element);
            },
            error: function(err){
                console.error(err);
            }
        })
    }
})
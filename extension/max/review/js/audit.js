$(function()
{
    $('table.reviewcl .issueResult, table.reviewcl .resolved').change(function()
    {
        var result = $(this).val();
        if(result == 1)
        {
            $(this).closest('tr').find('.opinion').attr('readonly', true);
            $(this).closest('tr').find('.opinionDate').removeClass('showing').addClass('hidden');
        }
        else
        {
            $(this).closest('tr').find('.opinion').attr('readonly', false);
            $(this).closest('tr').find('.opinionDate').removeClass('hidden').addClass('showing');
        }
    })

    $(".issueResult").on("click", function()
    {
        var issueResult  = [];
        var reviewStatus = '';
        $("input[name^='issueResult']:checked").each(function(i, el)
        {
            var choose = $(el).attr("name");
            var userChoose = [];
            userChoose['issue']  = choose;
            userChoose['result'] = $(el).attr("value");
            issueResult.push(userChoose);
        })

        var success = 1;
        for(var i = 0; i < issueResult.length; i++)
        {
            if( issueResult[i]['result'] == "0")
            {
                $("input[name='result'][value='pass']").removeAttr('checked').attr('disabled','disabled');
                if(!$("input[name='result'][value='fail']").attr('checked')){$("input[name='result'][value='needfix']").attr('checked', true);}
                success = 0;
            }
        }

        if(success)
        {
            $("input[name='result'][value='pass']").removeAttr('disabled').attr('checked',true);
            $("input[name='result'][value='fail']").attr('checked', false);
            $("input[name='result'][value='needfix']").attr('checked', false);
        }
    })

    $("#fullScreenBtn").on("click", fullScreenReview())

    function fullScreenReview()
    {
        $("#mainContent").css("z-index", "999999");
    }
})

import $ from 'jquery';
import ajax from 'core/ajax';

export const init = () => {
    get_response();
};

/**
 * Delete a content
 */
function get_response() {

    $("#submit-question").off();
    $("#submit-question").on('click', function () {
        var bot_id = $(this).data('bot_id');
        var prompt = $('#user-prompt').val();
        console.log(bot_id);
        console.log(prompt);
        //Delete the record
        var gpt_response = ajax.call([{
            methodname: 'fakesmarts_get_gpt_response',
            args: {
                bot_id: bot_id,
                prompt: prompt
            }
        }]);

        gpt_response[0].done(function (result) {
            console.log(result);
            $('#fakesmarts-conversation').append().html(`<p> ${result}</p>`);
        }).fail(function () {
            alert('An error has occurred.');
        });
    });
}
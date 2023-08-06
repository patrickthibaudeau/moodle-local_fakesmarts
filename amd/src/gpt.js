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
        var content  = $('#fakesmarts-test-input').val();
        // console.log(bot_id);
        // console.log(prompt);
        //Delete the record
        var gpt_response = ajax.call([{
            methodname: 'fakesmarts_get_gpt_response',
            args: {
                bot_id: bot_id,
                prompt: prompt,
                content: content
            }
        }]);

        gpt_response[0].done(function (result) {
            // console.log(result);
            let data = JSON.parse(result);
            console.log(data);
            $('#fakesmarts-conversation').append().html(`<p> ${data.message}</p>`);
            $('#fakesmarts-prompt-tokens').html(data.prompt_tokens);
            $('#fakesmarts-completion-tokens').html(data.completion_tokens);
            $('#fakesmarts-total-tokens').html(data.total_tokens);
            $('#fakesmarts-cost').html('$' + data.cost.toPrecision(6));
        }).fail(function () {
            alert('An error has occurred.');
        });
    });
}
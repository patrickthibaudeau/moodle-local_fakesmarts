import $ from 'jquery';
import notification from 'core/notification';
import ajax from 'core/ajax';

export const init = () => {
    delete_bot();
};

/**
 * Delete a content
 */
function delete_bot() {

    $(".delete-bot").off();
    $(".delete-bot").on('click', function () {
        var id = $(this).data('id');

        notification.confirm('Delete',
            'Are you sure you want to delete this bot? All content will also be deleted. It will not be possible to recover.',
            'Delete',
            M.util.get_string('cancel', 'local_fakesmarts'), function () {
                //Delete the record
                var delete_content = ajax.call([{
                    methodname: 'fakesmarts_bot_delete',
                    args: {
                        id: id
                    }
                }]);

                delete_content[0].done(function () {
                    location.reload();
                }).fail(function () {
                    alert('An error has occurred. The record was not deleted');
                });
            });

    });
}
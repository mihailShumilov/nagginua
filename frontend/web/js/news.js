/**
 * Created by godson on 12/21/14.
 */
$(document).ready(function () {
    if ($(location).attr('hash')) {
        $($(location).attr('hash')).show();
    }

    $(".sourceSwitch").click(function () {
        $(".pendingNews").hide();
        $("#" + $(this).attr("href").substr(1)).show();
    });
});
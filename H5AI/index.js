$(document).ready(function() {
    $('.treeview').find('ul').hide();
 
    $('.treeview-folder span').click(function() {
        $(this).parent().find('ul:first').toggle('medium');
 
        if ($(this).parent().attr('className') == 'treeview-folder') {
            return;
        }
    });
});
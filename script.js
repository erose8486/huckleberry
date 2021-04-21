var ViewModel = function(){
    var self = this;

    self.members = ko.observableArray([])
    self.memberData = ko.observableArray([])

    self.getMembers = function(){
        $.post('ajax.php', {action: 'get_members'}, function(response){
            response = JSON.parse(response)
            if(response.success){
                self.members(response.members)
            }
        })
    }
}
var vm = new ViewModel();

$(function(){
    ko.applyBindings(vm);
    $('#todays-date').text(new Date().toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric' }))   
    $('#month').text(new Date().toLocaleDateString('en-US', { month: 'long', year: 'numeric'}))   
    
    vm.getMembers()

    $(document).on('submit', 'form', function(e){
        e.preventDefault()
        var missing_required = false;
        $('input', this).each(function(){
            if($(this).attr('required') && !$(this).val()){
                missing_required = true;
            }
        })
        if(missing_required) {
            alert('Please fill in all required fields.')
            return;
        }
        
        var data = $(this).serialize()
        $.post('ajax.php', data, function(response){
            response = JSON.parse(response)
            console.log(response)
            if(response.success){
                $('#ajax_message').addClass('success').html(response.message + '<span class="close">&times;</span>').show()
                vm.getMembers()
            }else{
                $('#ajax_message').addClass('error').html(response.message + '<a href="mailto:erosenberg8486@gmail.com?subject=Error debug info&body=' + response.debug + '">click here to shoot me an email.</a><span class="close">&times;</span>').show()
            }
        })
    })
    $(document).on('click', '#ajax_message .close', function(){
        $('#ajax_message').html('').hide()
    })
})
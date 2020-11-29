function callApiPerson(action, person = null, name = null){
    jQuery.ajax({
        type: "POST",
        url: "apiCall.php",
        data: {action : action, 
               person : person, 
                 name : name},
        success: function(response) {
            if (action == 'getAllPerson'){
                var data = JSON.parse(response);
                var tabela = $("#tabPerson");
                var rows = "";
                tabela.find("tbody td").remove();
                data.forEach(function (item) {
                    rows += "<tr id='"+item.id_person+"'>";
                    rows += " <td>" + item.id_person + "</td>";
                    rows += " <td> " +
                               "<span class='fixed_name'>" + item.name + "</span>" +
                               "<input type='text' class='alt_name' value='" + item.name + "' style='display:none'></td>";
                    rows += " <td> <div class='text-right'> "+
                                "<button type='button' class='btn btn-info btn-sm load_contacts'>Contatos</button> "+
                                "<button type='button' class='btn btn-primary btn-sm change_person'>Alterar</button> "+
                                "<button type='button' class='btn btn-success btn-sm putPerson' style='display:none'>Salvar</button> "+
                                "<button type='button' class='btn btn-danger btn-sm deletePerson'>Apagar</button> "+
                            "</div></td>";
                    rows += "</tr>";
                });
                tabela.find("tbody").html(rows);
            }else if (action == 'addPerson'){
                $('#firstName').val('');
                callApiPerson('getAllPerson');
            }else{
                callApiPerson('getAllPerson');
            }
        },
        error: function(response) {
            console.log(response);
        }
    });
}
function callApiContact(action, person = null, contact = null, email = null, phone = null, whats = null){
    jQuery.ajax({
        type: "POST",
        url: "apiCall.php",
        data: {action : action, 
               person : person,
              contact : contact,
                email : email,
                phone : phone,
                whats : whats},
        success: function(response) {
            if (action == 'getAllContact'){
                var data = JSON.parse(response);
                var tabela = $("#tabContact");
                var rows = "";
                tabela.find("tbody td").remove();
                data.forEach(function (item) {
                    rows += "<tr id='"+item.id_contact+"'>";
                    rows += " <td>" + item.id_contact + "</td>";
                    rows += " <td> " +
                               "<span class='fixed_email'>" + item.email + "</span>" +
                               "<input type='text' class='alt_email' value='" + item.email + "' style='display:none'></td>";
                    rows += " <td> " +
                               "<span class='fixed_phone'>" + item.phone_number + "</span>" +
                               "<input type='text' class='alt_phone' value='" + item.phone_number + "' style='display:none'></td>";
                    rows += " <td> " +
                               "<span class='fixed_whats'>" + item.whatsapp_number + "</span>" +
                               "<input type='text' class='alt_whats' value='" + item.whatsapp_number + "' style='display:none'></td>";
                    rows += " <td> <div class='text-right'> "+
                                "<button type='button' class='btn btn-primary btn-sm change_contact'>Alterar</button> "+
                                "<button type='button' class='btn btn-success btn-sm putContact' style='display:none'>Salvar</button> "+
                                "<button type='button' class='btn btn-danger btn-sm deleteContact'>Apagar</button> "+
                            "</div></td>";
                    rows += "</tr>";
                });
                tabela.find("tbody").html(rows);
            }else if (action == 'addPerson'){
                $('#firstName').val('');
                callApiContact('getAllContact', person);
            }else{
                callApiContact('getAllContact', person);
            }
            console.log(response);
        },
        error: function(response) {
            console.log(response);
        }
    });
}
$(document).ready(function() {
    // Pessoas
    callApiPerson('getAllPerson');
    $('#addPerson').on('click', function(){
        callApiPerson('addPerson', null, $('#firstName').val());
    });
    $(document).on('click', '.deletePerson', function(){
        callApiPerson('deletePerson', $(this).parents('tr').attr("id"), null);
    });
    $(document).on('click', '.change_person', function(){
        $('#tabPerson>tbody>tr#'+$(this).parents('tr').attr("id") + '>td>.fixed_name').hide();
        $('#tabPerson>tbody>tr#'+$(this).parents('tr').attr("id") + '>td>.alt_name').show();
        $('#tabPerson>tbody>tr#'+$(this).parents('tr').attr("id") + '>td>div>.change_person').hide();
        $('#tabPerson>tbody>tr#'+$(this).parents('tr').attr("id") + '>td>div>.putPerson').show();
    });
    $(document).on('click', '.putPerson', function(){
        callApiPerson('putPerson', $(this).parents('tr').attr("id"), $('#tabPerson>tbody>tr#'+$(this).parents('tr').attr("id") + '>td>.alt_name').val());
    });
    // Contatos
    $(document).on('click', '.load_contacts', function(){
        $('.main_contact').show();
        $('#idPerson').val($(this).parents('tr').attr("id"));
        $('#firstNameContact').val($('#tabPerson>tbody>tr#'+$(this).parents('tr').attr("id") + '>td>.alt_name').val());
        callApiContact('getAllContact', $(this).parents('tr').attr("id"));
    });
    $('#addContact').on('click', function(){
        callApiContact('addContact', $('#idPerson').val(), null, $('#email').val(), $('#phoneNumber').val(), $('#whatsappNumber').val());
    });
    $(document).on('click', '.change_contact', function(){
        $('#tabContact>tbody>tr#'+$(this).parents('tr').attr("id") + '>td>.fixed_email').hide();
        $('#tabContact>tbody>tr#'+$(this).parents('tr').attr("id") + '>td>.alt_email').show();
        $('#tabContact>tbody>tr#'+$(this).parents('tr').attr("id") + '>td>.fixed_phone').hide();
        $('#tabContact>tbody>tr#'+$(this).parents('tr').attr("id") + '>td>.alt_phone').show();
        $('#tabContact>tbody>tr#'+$(this).parents('tr').attr("id") + '>td>.fixed_whats').hide();
        $('#tabContact>tbody>tr#'+$(this).parents('tr').attr("id") + '>td>.alt_whats').show();
        $('#tabContact>tbody>tr#'+$(this).parents('tr').attr("id") + '>td>div>.change_contact').hide();
        $('#tabContact>tbody>tr#'+$(this).parents('tr').attr("id") + '>td>div>.putContact').show();
    });
    $(document).on('click', '.putContact', function(){
        callApiContact('putContact', 
                       $('#idPerson').val(),
                       $(this).parents('tr').attr("id"), 
                       $('#tabContact>tbody>tr#'+$(this).parents('tr').attr("id") + '>td>.alt_email').val(),
                       $('#tabContact>tbody>tr#'+$(this).parents('tr').attr("id") + '>td>.alt_phone').val(),
                       $('#tabContact>tbody>tr#'+$(this).parents('tr').attr("id") + '>td>.alt_whats').val()
                      ); 
    });
    $(document).on('click', '.deleteContact', function(){
        callApiContact('deleteContact', null, $(this).parents('tr').attr("id"));
    });
});
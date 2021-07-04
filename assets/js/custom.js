// Início dos Iniciadores do Materialize
$(document).ready(function () {
    $('.sidenav').sidenav();
});

$('.dropdown-trigger').dropdown();

$(document).ready(function () {
    $('.tooltipped').tooltip();
});

$(document).ready(function () {
    $('.fixed-action-btn').floatingActionButton();
});

$(document).ready(function () {
    $('.modal').modal();
});

$(document).ready(function () {
    $('select').formSelect();
});

$(document).ready(function () {
    $('.modal').modal();
});
//Fim dos Iniciadores do Materialize

//Início das Funções Customizadas
var api_url = 'https://tarefas-invisiveis.herokuapp.com/API/';
//Adiciona uma máscara em todos os inputs da classe "dataHora".
$(document).ready(function () {
    $('.dataHora').inputmask('99:99 de 99/99/9999');
});

//Adiciona campo selecionável com membros a serem vinculados a uma tarefa.
$('.designar').click(function () {
    $('.designar').remove();
    var grupo_id = $('input[name = "grupo_id"]').val();
    $('.adicionavel').append('<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>');
    $.get(api_url + "buscar_participantes_grupo_familiar/" + grupo_id, function (resposta) {
        if (resposta) {
            resultado = JSON.parse(resposta);
            for (var i in resultado) {
                $('.adicionavel').append('<div class="input-field col s12"><p><label><input id="membros_grupo[]" name="membros_grupo[]" value="' + resultado[i.toString()]['id'] + '" type="checkbox" /><span>' + resultado[i.toString()]['first_name'] + ' ' + resultado[i.toString()]['last_name'] + '</span></label></p></div>');
            }
        } else {
            $('.adicionavel').prepend('<button class="btn waves-effect waves-light primario designar" type="button" name="designar">Designar</button>');
        }
    })
    $('.preloader-wrapper').remove();
});
//Fim das Funções Customizadas
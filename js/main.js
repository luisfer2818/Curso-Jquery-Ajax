$(function() {
    var requestList = $.ajax({
        method: "GET",
        url: "post.php",
        data: { listAll: "list" },
        dataType: "json"
    });

    requestList.done(function(e) {
        console.log(e);
        var table = '<thead><tr><th>ID</th><th>Name</th><th>E-mail</th><th>Telefone</th><th>Data</th></tr></thead><tbody>';
        for (var k in e) {
            table += '<tr> <th scope = "row" >' + e[k].id + '</th>';
            table += '<td>' + e[k].name + '</td>';
            table += '<td>' + e[k].email + '</td>';
            table += '<td>' + e[k].tel + '</td>';
            table += '<td>' + e[k].date + '</td></tr>';
        }
        table += '</tbody>';
        $('#contatos').html(table);
    });

    $('#AjaxRequest').submit(function() {
        var form = $(this).serialize();
        var request = $.ajax({
            method: "POST",
            url: "post.php",
            data: form,
            dataType: "json"
        });

        request.done(function(e) { //requisição realizada com sucesso
            $('#msg').html(e.msg);

            if (e.status) {
                $('#AjaxRequest').each(function() {
                    this.reset();
                });
                var table = '<tr> <th scope="row">' + e.contatos.id + '</th>';
                table += '<td>' + e.contatos.name + '</td>';
                table += '<td>' + e.contatos.email + '</td>';
                table += '<td>' + e.contatos.tel + '</td>';
                table += '<td>' + e.contatos.date + '</td></tr>';
                $('#contatos tbody').prepend(table);
            }

        });

        request.fail(function(e) { //requisição deu erro
            console.log("fail");
            console.log(e);
        });

        request.always(function(e) { //sempre terá um retorno negativo ou positivo
            console.log("always");
            console.log(e);
        });

        return false;
    });
});
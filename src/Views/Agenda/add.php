<?php
//Id do contato
$id = $params['contato']['id'];
?>

<form action="/agenda/insert<?php if ($id) : echo "/$id"; endif; ?>">

    <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="str_nome" aria-describedby="nomeHelp"
               placeholder="Digite o nome completo" required
               value="<?php echo $params['contato']['str_nome']; ?>">
        <small id="nomeHelp" class="form-text text-muted">O nome do contato deve ser unico.</small>
    </div>

    <div class="form-group">
        <label for="telefone_celular">Telefone Celular</label>
        <input type="tel" class="form-control" id="telefone_celular" name="num_celular"
               aria-describedby="telefoneHelp" placeholder="Digite o telefone celular" required
               value="<?php echo $params['telefone']['num_celular']; ?>">
        <small id="telefoneHelp" class="form-text text-muted">Phone Number (Format: +99(99)9999-9999)</small>
    </div>

    <div class="form-group">
        <label for="telefone_residencial">Telefone Residencial</label>
        <input type="tel" class="form-control" id="telefone_residencial" name="num_residencial"
               aria-describedby="telefoneResidencialHelp" placeholder="Digite o telefone residencial"
               value="<?php echo $params['telefone']['num_residencial']?>">
        <small id="telefoneResidencialHelp" class="form-text text-muted">Phone Number (Format: +99(99)9999-9999)</small>
    </div>

    <button type="submit" class="btn btn-primary float-right"><span class="spanBtn"></span> Submit</button>
</form>

<script>
    $(function () {

        var title = ($('#id').val() != '') ? 'Editar contato' : 'Salvar contato';
        $('.modal-title').html(title);

        $('form').submit(function (e) {
            e.preventDefault();
            $('.btn-primary').html('<span class="fa fa-refresh glyphicon-refresh-animate"></span> Loading...');
            insert(getFormData($(this)));
        });

        function getFormData(form) {
            var array = form.serializeArray();
            var indexed_array = {};

            $.map(array, function(n, i){
                indexed_array[n['name']] = n['value'];
            });

            return indexed_array;
        }

        function insert(data) {
            $.ajax({
                type: "POST",
                url: $('form').attr('action'),
                data: data,
                success: function (res) {
                    console.log('res', res.contato);
                    if (res.status == 200) {

                        getContato(res.contato);

                        setTimeout(function () {
                            $('#myModal').modal('hide');

                            $(".alert-body").text('Registro salvo com sucesso.');
                            $(".alert").addClass('alert-success show');
                        },3000);
                    }
                },
                error: function (err) {
                    setTimeout(function () {
                        $('#myModal').modal('hide');

                        $(".alert-body").text('Ops... Tivemos um erro.');
                        $(".alert").addClass('alert-warning  show');
                    },3000);
                },
                dataType: 'json'
            });
        }

        function getContato(id) {
            $.ajax({
                type: "POST",
                url: '/agenda/contatoAction',
                data: {'id':id},
                success: function (res) {
                    $('.contato-list').append(
                        '<a href="#myModal" role="button" class="btn" data-remote-target="#myModal .modal-body"' +
                        'data-toggle="modal" data-load-remote="/agenda/add/"'+res.contato.id+'>' +
                        res.contato.str_nome + '</a>'
                    );
                },
                dataType: 'json'
            });
        }
    })
</script>
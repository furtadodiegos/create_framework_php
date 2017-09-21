<!--Chama o arquivo base com o html e os scripts-->
<?php require __DIR__.'/../base.php'; ?>

<a href="#myModal" role="button" class="btn float-right" data-toggle="modal" data-load-remote="/agenda/add"
   data-remote-target="#myModal .modal-body">
    <i class="fa fa-plus" aria-hidden="true"></i>
    Contato
</a>


<table class="table table-striped table-responsive">
    <thead class="thead-default">
    <tr>
        <th>#</th>
        <th>Nome</th>
        <th>Telefone Celular</th>
        <th>Telefone Residencial</th>
        <th>Ações</th>
    </tr>
    </thead>
    <tbody class="contato-list">
    <?php foreach ($params as $val): ?>
        <tr>
            <th scope="row"><?php echo $val['id']; ?></th>
            <td><?php echo $val['str_nome']; ?></td>
            <td><?php echo $val['num_celular']; ?></td>
            <td><?php echo $val['num_residencial']; ?></td>
            <td align="center">
                <a href="#myModal" role="button" class="btn" data-toggle="modal" data-remote-target="#myModal .modal-body"
                   data-load-remote="/agenda/add/<?php echo $val['id']; ?>">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                </a>
                <a href="#myModal" role="button" class="btn" data-toggle="modal" data-remote-target="#myModal .modal-body"
                   data-load-remote="/agenda/add/<?php echo $val['id']; ?>">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>


</div>

</div>
<div class="col-lg-3 feed-right">
    <div class="card mb-2">
        <div class="card-header">
            <i class="fa fa-bell-o"></i> Feed</div>
        <div class="list-group list-group-flush small">
            <a class="list-group-item list-group-item-action" href="#">
                <div class="media">
                    <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/45x45" alt="">
                    <div class="media-body">
                        <strong>David Miller</strong>posted a new article to
                        <strong>David Miller Website</strong>.
                        <div class="text-muted smaller">Today at 5:43 PM - 5m ago</div>
                    </div>
                </div>
            </a>
            <a class="list-group-item list-group-item-action" href="#">
                <div class="media">
                    <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/45x45" alt="">
                    <div class="media-body">
                        <strong>Samantha King</strong>sent you a new message!
                        <div class="text-muted smaller">Today at 4:37 PM - 1hr ago</div>
                    </div>
                </div>
            </a>
            <a class="list-group-item list-group-item-action" href="#">
                <div class="media">
                    <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/45x45" alt="">
                    <div class="media-body">
                        <strong>Jeffery Wellings</strong>added a new photo to the album
                        <strong>Beach</strong>.
                        <div class="text-muted smaller">Today at 4:31 PM - 1hr ago</div>
                    </div>
                </div>
            </a>
            <a class="list-group-item list-group-item-action" href="#">
                <div class="media">
                    <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/45x45" alt="">
                    <div class="media-body">
                        <i class="fa fa-code-fork"></i>
                        <strong>Monica Dennis</strong>forked the
                        <strong>startbootstrap-sb-admin</strong>repository on
                        <strong>GitHub</strong>.
                        <div class="text-muted smaller">Today at 3:54 PM - 2hrs ago</div>
                    </div>
                </div>
            </a>
            <a class="list-group-item list-group-item-action" href="#">View all activity...</a>
        </div>
        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
    </div>
</div>
</div>
</div>
</div>

<script>
    $(function () {
        $('[data-load-remote]').on('click',function(e) {
            e.preventDefault();
            var $this = $(this);
            var remote = $this.data('load-remote');
            if(remote) {
                $($this.data('remote-target')).load(remote);
            }
        });
    })
</script>
</body>

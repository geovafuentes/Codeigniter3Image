<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Items</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <!-- Botón de cerrar sesión con icono -->
                        <br>
                        <button class="btn btn-outline-danger" onclick="logout()">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<div class="container mt-5">
    <h2>Crud de items</h2>
    <input class="form-control mb-3" id="searchInput" type="text" placeholder="Buscar item...">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus"></i> Agregar Items</button>
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="itemsTable">
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= $item['id']; ?></td>
                    <td><?= $item['name']; ?></td>
                    <td><?= $item['description']; ?></td>
                    <td><img src="<?= base_url('uploads/' . $item['image']); ?>" alt="" width="100"></td>
                    <td>
                        <button type="button" class="btn btn-warning editBtn" data-id="<?= $item['id']; ?>"><i class="fas fa-edit"></i> Editar</button>
                        <button type="button" class="btn btn-danger deleteBtn" data-id="<?= $item['id']; ?>"><i class="fas fa-trash-alt"></i> Eliminar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div class="modal" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addForm" action="<?= base_url('items/create'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title">Add Item</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nombre:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Descripcion:</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Imagen:</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Agregar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" action="" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Item</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="form-group">
                        <label for="edit_name">Nombre:</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_description">Descripción:</label>
                        <textarea class="form-control" id="edit_description" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_description">Imagen:</label>
                        <br>
                        <img id="current_image" src="" alt="Current Image" width="100">
                    </div>
                    <div class="form-group">
                        <label for="edit_image">Actualizar Imagen:</label>
                        <input type="file" class="form-control" id="edit_image" name="image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Filter table based on search input
    $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#itemsTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

$('.editBtn').on('click', function() {
    var id = $(this).data('id');
    $.ajax({
        url: '<?= base_url('items/view/'); ?>' + id,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#edit_id').val(data.id);
            $('#edit_name').val(data.name);
            $('#edit_description').val(data.description);

            // Set the current image URL
            var currentImage = '<?= base_url('uploads/'); ?>' + data.image;
            $('#current_image').attr('src', currentImage); // Assuming an image tag with id 'current_image'

            $('#editForm').attr('action', '<?= base_url('items/edit/'); ?>' + data.id);
            $('#editModal').modal('show');
        }
    });
});
    $('.deleteBtn').on('click', function() {
        var id = $(this).data('id');
        if (confirm('Are you sure you want to delete this item?')) {
            window.location.href = '<?= base_url('items/delete/'); ?>' + id;
        }
    });
    
});

function logout() {
        $.ajax({
            url: "<?php echo site_url('login/logout'); ?>",
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                // Redirigir a la página de inicio de sesión u otro lugar
                window.location.replace("<?php echo site_url('login'); ?>");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error logging out');
            }
        });
    }
</script>
</body>
</html>

<?php
require_once '../startup/connectBD.php'; 
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$id = $_SESSION['id_usuario'];

$sql_checklist = "SELECT `id_checklist`, `titulo_checklist`, `data_checklist`, `estado_checklist`, `hora_checklist`, `desc_checklist`, `usuario_id_usuario` FROM `checklist` WHERE usuario_id_usuario = '$id'";
$result_checklist = $mysqli->query($sql_checklist);

$dados_checklist = [];

if ($result_checklist && $result_checklist->num_rows > 0) {
    while ($paleta = $result_checklist->fetch_assoc()) {
        $dados_checklist[] = $paleta;
    }
} 


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checklist</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        footer{
            position: fixed;
            top: 10%;
        }
    </style>
</head>
<body class="planner-body">
<script src="./js/topo.js"></script>

<main class="main-planner">
    <div class="container mt-4 dasl">
        <?php
        if (isset($_SESSION['mensagem'])) {
            echo '<div class="alert alert-info" role="alert">' . $_SESSION['mensagem'] . '</div>';
            unset($_SESSION['mensagem']); // Limpa a mensagem após exibi-la
        }
        ?>

        <!-- Modal de Adicionar Checklist -->
        <div class="modal fade" id="addChecklistModal" tabindex="-1" aria-labelledby="addChecklistModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addChecklistModalLabel">Adicionar Checklist</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../backBack/cadastro/checklist.php" method="POST">
                            <div class="mb-3">
                                <label for="titulo_checklist" class="form-label">Título do Checklist</label>
                                <input type="text" class="form-control" id="titulo_checklist" name="titulo_checklist" required>
                            </div>
                            <div class="mb-3">
                                <label for="data_checklist" class="form-label">Data</label>
                                <input type="date" class="form-control" id="data_checklist" name="data_checklist" required>
                            </div>
                            <div class="mb-3">
                                <label for="estado_checklist" class="form-label">Estado</label>
                                <select class="form-control" id="estado_checklist" name="estado_checklist" required>
                                    <option value="" disabled selected>Selecione um estado</option>
                                    <option value="Feito">Feito</option>
                                    <option value="Fazendo">Fazendo</option>
                                    <option value="À fazer">À fazer</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="hora_checklist" class="form-label">Hora</label>
                                <input type="time" class="form-control" id="hora_checklist" name="hora_checklist" required>
                            </div>
                            <div class="mb-3">
                                <label for="desc_checklist" class="form-label">Descrição</label>
                                <textarea class="form-control" id="desc_checklist" name="desc_checklist" rows="3" required></textarea>
                            </div>
                            <input type="hidden" name="usuario_id_usuario" value="1"> <!-- Ajuste o ID do usuário conforme necessário -->
                            <button type="submit" class="btn btn-primary">Adicionar Checklist</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Planejamento com Colunas -->
        <div class="planner">
            <div class="planner-column" id="todo" ondrop="drop(event)" ondragover="allowDrop(event)">
                <h2>A Fazer</h2>
                <?php foreach ($dados_checklist as $checklist): ?>
                    <?php if ($checklist['estado_checklist'] === 'À fazer'): ?>
                        <div class="task" draggable="true" ondragstart="drag(event)" id="task<?php echo $checklist['id_checklist']; ?>">
                            <?php echo htmlspecialchars($checklist['titulo_checklist']); ?>
                            <button class="btn edit-btn" onclick="openEditModal('task<?php echo $checklist['id_checklist']; ?>')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn delete-btn" onclick="openDeleteModal('task<?php echo $checklist['id_checklist']; ?>')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <div class="planner-column" id="in-progress" ondrop="drop(event)" ondragover="allowDrop(event)">
                <h2>Fazendo</h2>
                <?php foreach ($dados_checklist as $checklist): ?>
                    <?php if ($checklist['estado_checklist'] === 'Fazendo'): ?>
                        <div class="task" draggable="true" ondragstart="drag(event)" id="task<?php echo $checklist['id_checklist']; ?>">
                            <?php echo htmlspecialchars($checklist['titulo_checklist']); ?>
                            <button class="btn edit-btn" onclick="openEditModal('task<?php echo $checklist['id_checklist']; ?>')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn delete-btn" onclick="openDeleteModal('task<?php echo $checklist['id_checklist']; ?>')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <div class="planner-column" id="done" ondrop="drop(event)" ondragover="allowDrop(event)">
                <h2>Feito</h2>
                <?php foreach ($dados_checklist as $checklist): ?>
                    <?php if ($checklist['estado_checklist'] === 'Feito'): ?>
                        <div class="task" draggable="true" ondragstart="drag(event)" id="task<?php echo $checklist['id_checklist']; ?>">
                            <?php echo htmlspecialchars($checklist['titulo_checklist']); ?>
                            <button class="btn edit-btn" onclick="openEditModal('task<?php echo $checklist['id_checklist']; ?>')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn delete-btn" onclick="openDeleteModal('task<?php echo $checklist['id_checklist']; ?>')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <button class="add-btn mt-3" data-bs-toggle="modal" data-bs-target="#addChecklistModal">+</button>
        </div>
    </div>
</main>

<!-- Modal para Edição de Tarefa -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Tarefa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form action="../backBack/update/editar_checklist.php" method="POST">
                    <input type="hidden" id="editTaskId" name="id_checklist"> <!-- Campo oculto para o ID da tarefa -->
                    <div class="mb-3">
                        <label for="editTaskTitle" class="form-label">Título</label>
                        <input type="text" id="editTaskTitle" name="titulo_checklist" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editTaskDate" class="form-label">Data</label>
                        <input type="date" id="editTaskDate" name="data_checklist" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editTaskState" class="form-label">Estado</label>
                        <select id="editTaskState" name="estado_checklist" class="form-control" required>
                            <option value="Feito">Feito</option>
                            <option value="Fazendo">Fazendo</option>
                            <option value="À fazer">À fazer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editTaskTime" class="form-label">Hora</label>
                        <input type="time" id="editTaskTime" name="hora_checklist" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editTaskDesc" class="form-label">Descrição</label>
                        <textarea id="editTaskDesc" name="desc_checklist" class="form-control" rows="3" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveTaskBtn" onclick="document.querySelector('#editTaskId').form.submit();">Salvar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Excluir Tarefa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza de que deseja excluir esta tarefa?</p>
            </div>
            <div class="modal-footer">
                <form action="../backBack/delete/excluir_checklist.php" method="POST">
                    <input type="hidden" id="deleteTaskId" name="id_checklist">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>




<script>
    function openEditModal(id) {
    const checklistId = id.replace('task', ''); // Remove 'task' para pegar o número

    const task = <?php echo json_encode($dados_checklist); ?>.find(t => t.id_checklist == checklistId);
    
    if (task) {
        document.getElementById('editTaskId').value = task.id_checklist; // Passa o ID para o campo oculto
        document.getElementById('editTaskTitle').value = task.titulo_checklist;
        document.getElementById('editTaskDate').value = task.data_checklist;
        document.getElementById('editTaskState').value = task.estado_checklist;
        document.getElementById('editTaskTime').value = task.hora_checklist;
        document.getElementById('editTaskDesc').value = task.desc_checklist;

        var editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.show();
    } else {
        console.error("Tarefa não encontrada.");
    }
}




function openDeleteModal(id) {
    const checklistId = id.replace('task', ''); // Pega o número do ID removendo 'task'
    document.getElementById('deleteTaskId').value = checklistId; // Define o valor do campo hidden
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}


</script>
<script src="js/footer.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>

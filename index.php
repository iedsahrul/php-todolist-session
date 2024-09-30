<?php
session_start();

// Inisialisasi session to-do list
if (!isset($_SESSION['todos'])) {
    $_SESSION['todos'] = [];
}

// Tambah To-Do
if (isset($_POST['add'])) {
    $todo = $_POST['todo'];
    if (!empty($todo)) {
        $_SESSION['todos'][] = $todo;
    }
}

// Hapus To-Do
if (isset($_GET['delete'])) {
    $index = $_GET['delete'];
    if (isset($_SESSION['todos'][$index])) {
        unset($_SESSION['todos'][$index]);
        $_SESSION['todos'] = array_values($_SESSION['todos']); // Reindex array
    }
}

// Edit To-Do
if (isset($_POST['edit'])) {
    $index = $_POST['index'];
    $todo = $_POST['todo'];
    if (isset($_SESSION['todos'][$index])) {
        $_SESSION['todos'][$index] = $todo;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List dengan Session & Bootstrap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">To-Do List</h1>
        
        <!-- Form Tambah To-Do -->
        <form method="post" class="mb-4">
            <div class="input-group">
                <input type="text" name="todo" class="form-control" placeholder="Tambahkan to-do..." required>
                <button class="btn btn-primary" type="submit" name="add">Tambah</button>
            </div>
        </form>

        <!-- Tampilkan To-Do List -->
        <?php if (!empty($_SESSION['todos'])): ?>
            <ul class="list-group">
                <?php foreach ($_SESSION['todos'] as $index => $todo): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo htmlspecialchars($todo); ?>
                        <div>
                            <a href="index.php?edit=<?php echo $index; ?>" class="btn btn-warning btn-sm me-2">Edit</a>
                            <a href="index.php?delete=<?php echo $index; ?>" class="btn btn-danger btn-sm">Hapus</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-center">Tidak ada to-do saat ini. Tambahkan yang baru!</p>
        <?php endif; ?>

        <!-- Form Edit To-Do jika 'edit' dipilih -->
        <?php if (isset($_GET['edit'])): 
            $index = $_GET['edit'];
            if (isset($_SESSION['todos'][$index])): ?>
            <div class="mt-4">
                <form method="post">
                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                    <div class="input-group">
                        <input type="text" name="todo" class="form-control" value="<?php echo htmlspecialchars($_SESSION['todos'][$index]); ?>" required>
                        <button class="btn btn-success" type="submit" name="edit">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        <?php endif; endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

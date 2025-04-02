<?php
session_start();

// Check if the user is an admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php'); // Redirect to home if not admin
    exit();
}

// Available product tables
$tables = ['sneakers', 'clothing', 'accessories', 'tech', 'lifestyle'];

// Determine which table to display
$currentTable = isset($_GET['table']) && in_array($_GET['table'], $tables) ? $_GET['table'] : $tables[0];

try {
    // Connect to the database
    $pdo = new PDO('mysql:host=localhost;dbname=tradeup', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch products from the selected table
    $stmt = $pdo->query("SELECT id, name, price, image FROM $currentTable");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="main-container">
            <h1>Admin Dashboard</h1>

            <!-- Table Filter Links -->
            <div class="table-filters">
                <?php foreach ($tables as $table): ?>
                    <a href="admin_dashboard.php?table=<?= $table ?>" class="<?= $currentTable === $table ? 'active' : '' ?>">
                        <?= ucfirst($table) ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <a href="add_product.php" class="btn btn-primary">Add New Product</a>

            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" width="50"></td>
                            <td><?= htmlspecialchars($product['name']) ?></td>
                            <td>₩<?= number_format($product['price']) ?></td>
                            <td>
                                <a href="edit_product.php?id=<?= $product['id'] ?>&table=<?= $currentTable ?>" class="btn btn-edit">Edit</a>
                                <a href="delete_product.php?id=<?= $product['id'] ?>&table=<?= $currentTable ?>" class="btn btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <style>
        .table-filters {
            margin-bottom: 20px;
        }
        .table-filters a {
            margin-right: 10px;
            text-decoration: none;
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            color: #333;
        }
        .table-filters a.active {
            background-color: #007BFF;
            color: white;
            border-color: #007BFF;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        .btn {
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-primary {
            background-color: #007BFF;
            color: white;
        }
        .btn-edit {
            background-color: #FFC107;
            color: black;
        }
        .btn-delete {
            background-color: #DC3545;
            color: white;
        }
    </style>
</body>
</html>

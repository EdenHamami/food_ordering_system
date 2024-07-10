<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List Dishes</title>
</head>
<body>
    <h2>List of Dishes</h2>
    <a href="create_dish.html">Create New Dish</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
        <?php
        include_once '../config/database.php';
        include_once '../models/Dish.php';

        $database = new Database();
        $db = $database->getConnection();

        $dish = new Dish($db);
        $stmt = $dish->read();
        $dishes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($dishes as $dish) {
            echo "<tr>";
            echo "<td>" . $dish['id'] . "</td>";
            echo "<td>" . $dish['name'] . "</td>";
            echo "<td>" . $dish['description'] . "</td>";
            echo "<td>" . $dish['price'] . "</td>";
            echo "<td>" . $dish['category'] . "</td>";
            echo "<td>
                    <a href='edit_dish.html?id=" . $dish['id'] . "&name=" . urlencode($dish['name']) . "&description=" . urlencode($dish['description']) . "&price=" . $dish['price'] . "&category=" . urlencode($dish['category']) . "'>Edit</a>
                    <a href='../public/dishes/delete_dish.php?id=" . $dish['id'] . "'>Delete</a>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>

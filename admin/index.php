<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['image'])) {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($image);
    $upload_ok = 1;
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES['image']['tmp_name']);
    if ($check !== false) {
        $upload_ok = 1;
    } else {
        echo "File is not an image.";
        $upload_ok = 0;
    }

    // Check file size
    if ($_FILES['image']['size'] > 500000) {
        echo "Sorry, your file is too large.";
        $upload_ok = 0;
    }

    // Allow certain file formats
    if ($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $upload_ok = 0;
    }

    // Check if $upload_ok is set to 0 by an error
    if ($upload_ok == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            if ($id) {
                // Update product
                $sql = "UPDATE products SET name=?, price=?, category_id=?, description=?, image=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sdsssi", $name, $price, $category_id, $description, $image, $id);
                if ($stmt->execute()) {
                    $success = "Product updated successfully!";
                } else {
                    $error = "Error updating product!";
                }
            } else {
                // Add new product
                $sql = "INSERT INTO products (name, price, category_id, description, image) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sdsss", $name, $price, $category_id, $description, $image);
                if ($stmt->execute()) {
                    $success = "Product added successfully!";
                } else {
                    $error = "Error adding product!";
                }
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Delete product
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM products WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        $success = "Product deleted successfully!";
    } else {
        $error = "Error deleting product!";
    }
}

// Fetch product to edit
$edit_product = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $sql = "SELECT * FROM products WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $edit_product = $result->fetch_assoc();
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add/Edit Product</title>
    <link rel="stylesheet" href="../css/logout.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="admin-container">
        <div class="header">
        <h2>Admin Panel</h2>
        <a href="logout.php" class="logout-btn">Logout</a> <!-- Tambahkan kelas logout-btn di sini -->
        </div>
        <h3><?php echo $edit_product ? "Edit Product" : "Add Product"; ?></h3>
        <main>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $edit_product['id'] ?? ''; ?>">
                <label for="name">Product Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $edit_product['name'] ?? ''; ?>" required>
                <br>
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" value="<?php echo $edit_product['price'] ?? ''; ?>" required>
                <br>
                <label for="category_id">Category:</label>
                <select id="category_id" name="category_id" required>
                    <?php
                    $sql = "SELECT * FROM categories";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        $selected = $edit_product && $edit_product['category_id'] == $row['id'] ? 'selected' : '';
                        echo "<option value='" . $row['id'] . "' $selected>" . $row['name'] . "</option>";
                    }
                    ?>
                </select>
                <br>
                <label for="description">Description:</label>
                <textarea id="description" name="description" required><?php echo $edit_product['description'] ?? ''; ?></textarea>
                <br>
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" <?php echo $edit_product ? '' : 'required'; ?>>
                <br>
                <button type="submit"><?php echo $edit_product ? "Update Product" : "Add Product"; ?></button>
            </form>
            <?php
            if (isset($success)) echo "<p>$success</p>";
            if (isset($error)) echo "<p>$error</p>";
            ?>
        </main>

        <h3>Existing Products</h3>
        <div class="product-list">
            <?php
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product'>";
                    echo "<img src='../uploads/" . $row['image'] . "' alt='" . $row['name'] . "'>";
                    echo "<h4>" . $row['name'] . "</h4>";
                    echo "<p>Price: Rp" . $row['price'] . "</p>";
                    echo "<p>Category: " . $row['category_id'] . "</p>";
                    echo "<p>Description: " . $row['description'] . "</p>";
                    echo "<a href='?edit_id=" . $row['id'] . "'>Edit</a>";
                    echo "<a href='?delete_id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this product?\");'>Delete</a>";
                    echo "</div>";
                }
            } else {
                echo "<p>No products found.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>

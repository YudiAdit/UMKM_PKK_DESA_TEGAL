<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';

// Menampilkan error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    if ($_FILES['image']['size'] > 5000000) {
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
                    header("Location: index.php");
                    exit();
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
                    header("Location: index.php");
                    exit();
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
    <link rel="shortcut icon" href="Aseet/BG UMKM.png" type="">
    
    <title>Add/Edit Product</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/logout.css">
</head>
<body>
    <div class="admin-container">
        <div class="header">
        <h2>Halaman Tambah Produk</h2>
        <a href="logout.php" class="logout-btn">Logout</a> <!-- Tambahkan kelas logout-btn di sini -->
        </div>
        <h3><?php echo $edit_product ? "Ubah Produk" : "Tambah Produk"; ?></h3>
        <main>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $edit_product['id'] ?? ''; ?>">
                <label for="name">Nama Produk:</label>
                <input type="text" id="name" name="name" value="<?php echo $edit_product['name'] ?? ''; ?>" required>
                <br>
                <label for="price">Harga:</label>
                <input type="number" id="price" name="price" step="0.01" value="<?php echo $edit_product['price'] ?? ''; ?>" required>
                <br>
                <label for="category_id">Kategori :</label>
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
                <label for="description">Depskripsi :</label>
                <textarea id="description" name="description" required><?php echo $edit_product['description'] ?? ''; ?></textarea>
                <br>
                <label for="image">Foto Produk:</label>
                <input type="file" id="image" name="image" <?php echo $edit_product ? '' : 'required'; ?>>
                <p class="file-size-info">Maksimal ukuran file adalah 5 MB.</p>
                <br>
                <button type="submit"><?php echo $edit_product ? "Perbarui Produk" : "Tambahkan Produk"; ?></button>
            </form>
            <?php
            if (isset($success)) echo "<p>$success</p>";
            if (isset($error)) echo "<p>$error</p>";
            ?>
        </main>

        <h3>Produk Tersedia</h3>
        <div class="product-list">
            <?php
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product'>";
                    echo "<img src='../uploads/" . $row['image'] . "' alt='" . $row['name'] . "'>";
                    echo "<h4>" . $row['name'] . "</h4>";
                    echo "<p>harga: Rp" . number_format( $row['price'], 0, ',', '.' ) . "</p>";
                    echo "<p>kategori: " . $row['category_id'] . "</p>";
                    echo "<p>Deskripsi: " . $row['description'] . "</p>";
                    echo "<a href='?edit_id=" . $row['id'] . "'>Ubah Produk</a>";
                    echo "<a href='?delete_id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this product?\");'>Hapus Produk</a>";
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

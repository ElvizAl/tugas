<?php
include 'db/koneksi.php'; // Include the database connection

// Check if the member ID is provided
if (!isset($_GET['id'])) {
    echo "Member ID is missing.";
    exit();
}

$member_id = $_GET['id'];

// Fetch the member's current data from the database
$query = "SELECT * FROM anggota WHERE id_anggota = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$member_id]);
$member = $stmt->fetch();

if (!$member) {
    echo "Member not found.";
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the updated form data
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $date_of_birth = $_POST['date_of_birth'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $status = $_POST['status'];

    // Update the member's data in the database
    $update_query = "UPDATE anggota SET nama_lengkap = ?, jenis_kelamin = ?, tanggal_lahir = ?, no_telpon = ?, email = ?, alamat = ?, status_anggota = ? WHERE id_anggota = ?";
    $stmt = $pdo->prepare($update_query);
    $stmt->execute([$full_name, $gender, $date_of_birth, $phone, $email, $address, $status, $member_id]);

    // Redirect to the members list page after updating
    header("Location: anggota.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Member</title>

    <!-- Add Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f4f6f9;
        }

        .container {
            max-width: 600px;
            margin-top: 50px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            text-align: center;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            padding: 20px;
        }

        .form-group label {
            font-weight: 600;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            color: #007bff;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Edit Member</h4>
        </div>
        <div class="card-body">
            <!-- Edit member form -->
            <form action="edit-anggota-content.php?id=<?php echo $member['id_anggota']; ?>" method="POST">
                <div class="form-group">
                    <label for="full_name">Nama Lengkap</label>
                    <input type="text" class="form-control" name="full_name" value="<?php echo htmlspecialchars($member['nama_lengkap']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="gender">Jenis Kelamin</label>
                    <select class="form-control" name="gender" required>
                        <option value="Laki-laki" <?php echo $member['jenis_kelamin'] == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                        <option value="Perempuan" <?php echo $member['jenis_kelamin'] == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date_of_birth">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="date_of_birth" value="<?php echo $member['tanggal_lahir']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">No Telepon</label>
                    <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($member['no_telpon']); ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($member['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea class="form-control" name="address"><?php echo htmlspecialchars($member['alamat']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="status">Member Status</label>
                    <select class="form-control" name="status">
                        <option value="Aktif" <?php echo $member['status_anggota'] == 'Aktif' ? 'selected' : ''; ?>>Aktif</option>
                        <option value="Tidak Aktif" <?php echo $member['status_anggota'] == 'Tidak Aktif' ? 'selected' : ''; ?>>Tidak Aktif</option>
                        <option value="Suspend" <?php echo $member['status_anggota'] == 'Suspend' ? 'selected' : ''; ?>>Ditangguhkan</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Update Member</button>
            </form>
        </div>
    </div>

    <div class="footer">
        <a href="anggota.php">Kembali ke daftar member</a>
    </div>
</div>

<!-- Add jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

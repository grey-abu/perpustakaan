<?php
session_start();

// Cek apakah user sudah login, kalau belum redirect ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "perpustakaan");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$username = $_SESSION['username'] ?? 'Guest';

// Ambil kata kunci pencarian
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Query ambil data buku
$query = "SELECT * FROM buku 
          WHERE judul_buku LIKE '%$search%' 
          OR nama_pengarang LIKE '%$search%'
          OR nama_penerbit LIKE '%$search%'
          OR kategori_buku LIKE '%$search%'
          OR id_buku LIKE '%$search%'
          ORDER BY nama_pengarang ASC";

$result = $conn->query($query);

// Cek error query
if (!$result) {
    die("Query error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Perpustakaan</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background: #f0f2f5;
        }
        .navbar {
            background: #0077cc;
            color: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            background: #005fa3;
            padding: 8px 16px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .navbar a:hover {
            background: #004080;
        }
        .container {
            margin: 30px auto;
            width: 90%;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button[type="submit"] {
            padding: 10px 15px;
            border: none;
            background-color: #0077cc;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }
        button[type="submit"]:hover {
            background-color: #005fa3;
        }
        .table-wrapper {
            max-height: 400px;
            overflow-y: auto;
            margin-top: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }
        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #0077cc;
            color: white;
            position: sticky;
            top: 0;
            z-index: 1;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .no-results {
            text-align: center;
            font-style: italic;
            color: #888;
            padding: 20px 0;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div>Admin Perpustakaan - Halo, <?php echo htmlspecialchars($username); ?>!</div>
    <div>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h2>Data Buku</h2>

    <form method="GET">
        <input type="text" name="search" placeholder="Cari buku..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Cari</button>
    </form>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Buku</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Kategori Buku</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$no}</td>
                                <td>".htmlspecialchars($row['id_buku'])."</td>
                                <td>".htmlspecialchars($row['judul_buku'])."</td>
                                <td>".htmlspecialchars($row['nama_pengarang'])."</td>
                                <td>".htmlspecialchars($row['nama_penerbit'])."</td>
                                <td>".htmlspecialchars($row['kategori_buku'])."</td>
                              </tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='6' class='no-results'>Buku tidak ditemukan</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>

<?php 
$conn->close();
?>

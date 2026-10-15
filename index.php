<?php
// DATABASE CONNECTION
$host = 'localhost';
$db   = 'it30a';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Database connection failed.");
}

// GET CURRENT SECTION
$section = $_GET['section'] ?? 'students';

$allowedSections = ['students', 'books', 'borrow'];

if (!in_array($section, $allowedSections, true)) {
    $section = 'students';
}

// FETCH STUDENTS
$students = [];

if ($section === 'students') {
    $stmt = $pdo->query("
        SELECT *
        FROM students
        ORDER BY student_id DESC
    ");

    $students = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple PHP PDO CRUD</title>
</head>
<body>

    <h1>Simple PHP PDO CRUD</h1>

    <!-- Simple Navbar -->
    <nav>
        <a href="index.php?section=students">Students</a> |
        <a href="index.php?section=books">Books</a> |
        <a href="index.php?section=borrow">Borrow</a>
    </nav>

    <hr>

    <!-- STUDENTS SECTION -->
    <?php if ($section === 'students'): ?>

        <h1>Students</h1>

        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Course</th>
                    <th>Created at</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($students)): ?>

                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($student['student_id']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($student['student_first_name']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($student['student_last_name']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($student['student_course']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($student['student_created_at']) ?>
                            </td>

                            <td>
                                <a href="edit.php?id=<?= urlencode($student['student_id']) ?>">Edit</a>
                                |
                                <a href="delete.php?id=<?= urlencode($student['student_id']) ?>">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php else: ?>
                    <tr>
                        <td colspan="6">No students found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    <?php endif; ?>

    <!-- BOOKS SECTION -->
    <?php if ($section === 'books'): ?>

        <h1>Books</h1>

        <!-- Insert Books Table Here -->

    <?php endif; ?>

    <!-- BORROW SECTION -->
    <?php if ($section === 'borrow'): ?>

        <h1>Borrow</h1>

        <!-- Insert Borrow Table Here -->

    <?php endif; ?>

</body>
</html>
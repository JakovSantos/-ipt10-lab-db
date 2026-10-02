<?php
require_once 'config.php';
$id = trim($_GET['id'] ?? '');
if ($id === '') { die('Invalid student ID'); }

$stmt = $pdo->prepare('SELECT first_name, last_name FROM students WHERE id = ?');
$stmt->execute([$id]);
$student = $stmt->fetch();

require 'header.php';
if (!$student) {
    echo '<div class="alert alert-warning">Student not found.</div><a href="index.php">Back</a>';
    require 'footer.php'; exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // autocommit is off, so the SELECT above may already have opened a transaction
        if (!$pdo->inTransaction()) { $pdo->beginTransaction(); }
        $d = $pdo->prepare('DELETE FROM students WHERE id = ?');
        $d->execute([$id]);
        if ($d->rowCount() === 1) {
            $pdo->commit();
            echo '<div class="alert alert-success">Student deleted successfully.</div>';
        } else {
            $pdo->rollBack();
            echo '<div class="alert alert-danger">Failed to delete student.</div>';
        }
    } catch (PDOException $e) {
        if ($pdo->inTransaction()) { $pdo->rollBack(); }
        error_log($e->getMessage());
        echo '<div class="alert alert-danger">Failed to delete student.</div>';
    }
    echo '<a class="btn btn-secondary" href="index.php">Back to list</a>';
} else {
?>
<h2>Delete Student</h2>
<p>Are you sure you want to delete <strong><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></strong>?</p>
<form method="POST">
  <button class="btn btn-danger" type="submit">Yes, delete</button>
  <a class="btn btn-secondary" href="index.php">Cancel</a>
</form>
<?php }
require 'footer.php';
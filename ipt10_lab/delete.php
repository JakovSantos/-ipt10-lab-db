<?php
require_once 'db_connect.php';
$id = trim($_GET['id'] ?? '');
if ($id === '') { die('Invalid student ID'); }

$s = $conn->prepare('SELECT first_name, last_name FROM students WHERE id = ?');   // TODO 18
$s->bind_param('s', $id);
$s->execute();
$r = $s->get_result()->fetch_assoc();
$s->close();

require 'header.php';
if (!$r) {
    echo '<div class="alert alert-warning">Student not found.</div><a href="index.php">Back</a>';
    $conn->close(); require 'footer.php'; exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {                      // TODO 19
    $d = $conn->prepare('DELETE FROM students WHERE id = ?');
    $d->bind_param('s', $id);
    $d->execute();
    if ($d->affected_rows === 1) {
        echo '<div class="alert alert-success">Student deleted successfully.</div>';
    } else {
        echo '<div class="alert alert-danger">Failed to delete student.</div>';
    }
    echo '<a class="btn btn-secondary" href="index.php">Back to list</a>';
    $d->close();
    $conn->close();
} else {                                                          // TODO 20
?>
<h2>Delete Student</h2>
<p>Are you sure you want to delete <strong><?= htmlspecialchars($r['first_name'] . ' ' . $r['last_name']) ?></strong>?</p>
<form method="POST">
  <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
  <button class="btn btn-danger" type="submit">Yes, delete</button>
  <a class="btn btn-secondary" href="index.php">Cancel</a>
</form>
<?php }
require 'footer.php';

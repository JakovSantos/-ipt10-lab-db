<?php
require_once 'config.php';
$id = trim($_GET['id'] ?? '');
if ($id === '') { die('Invalid student ID'); }

$stmt = $pdo->prepare('SELECT * FROM students WHERE id = ?');
$stmt->execute([$id]);
$row = $stmt->fetch();

require 'header.php';
if (!$row) {
    echo '<div class="alert alert-warning">Student not found.</div>';
} else {
    $full = trim($row['first_name'] . ' ' . ($row['middle_name'] ?? '') . ' ' . $row['last_name']);
?>
<h2>Student Details</h2>
<div class="card"><div class="card-body">
  <p><strong>Student ID:</strong> <?= htmlspecialchars($row['id']) ?></p>
  <p><strong>Full Name:</strong> <?= htmlspecialchars($full) ?></p>
  <p><strong>Birthday:</strong> <?= htmlspecialchars($row['birthday']) ?></p>
  <p><strong>Sex:</strong> <?= htmlspecialchars($row['sex']) ?></p>
  <p><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></p>
  <p><strong>Student Number:</strong> <?= htmlspecialchars($row['student_number']) ?></p>
  <p><strong>Program:</strong> <?= htmlspecialchars($row['program']) ?></p>
  <p><strong>Enrolment Date:</strong> <?= htmlspecialchars($row['enrolment_date']) ?></p>
  <p><strong>Created:</strong> <?= htmlspecialchars($row['created_at']) ?></p>
  <p><strong>Updated:</strong> <?= htmlspecialchars($row['updated_at']) ?></p>
</div></div>
<?php } ?>
<a class="btn btn-secondary mt-3" href="index.php">Back</a>
<?php require 'footer.php';

<?php
require_once 'db_connect.php';
$id = trim($_GET['id'] ?? '');
if ($id === '') { die('Invalid student ID'); }

$stmt = $conn->prepare('SELECT id, first_name, middle_name, last_name, birthday, sex, email,
    student_number, program, enrolment_date, created_at, updated_at
    FROM students WHERE id = ?');                              // TODO 7
$stmt->bind_param('s', $id);
$stmt->execute();
$result = $stmt->get_result();                                  // TODO 8
$row = $result->fetch_assoc();

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
<?php
$stmt->close();
$conn->close();
require 'footer.php';

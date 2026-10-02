<?php
require_once 'config.php';
$rows = $pdo->query('SELECT id, first_name, last_name, email, enrolment_date
                     FROM students ORDER BY enrolment_date DESC, id DESC')->fetchAll();
require 'header.php';
?>
<div class="d-flex justify-content-between mb-3">
  <h2>All Student Records</h2>
  <a class="btn btn-success" href="create.php">Add Student</a>
</div>
<div class="table-responsive">
<table class="table table-striped table-bordered bg-white">
  <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Enrolled</th><th>Actions</th></tr></thead>
  <tbody>
  <?php foreach ($rows as $row): ?>
    <tr>
      <td><?= htmlspecialchars($row['id']) ?></td>
      <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
      <td><?= htmlspecialchars($row['email']) ?></td>
      <td><?= htmlspecialchars($row['enrolment_date']) ?></td>
      <td>
        <a class="btn btn-sm btn-info" href="view.php?id=<?= urlencode($row['id']) ?>">View</a>
        <a class="btn btn-sm btn-warning" href="edit.php?id=<?= urlencode($row['id']) ?>">Edit</a>
        <a class="btn btn-sm btn-danger" href="delete.php?id=<?= urlencode($row['id']) ?>">Delete</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>
<?php require 'footer.php';

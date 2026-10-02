<?php
require_once 'config.php';
require_once 'validation.php';
$id = trim($_GET['id'] ?? '');
if ($id === '') { die('Invalid student ID'); }

$errors = [];
$message = '';

$s = $pdo->prepare('SELECT * FROM students WHERE id = ?');
$s->execute([$id]);
$existing = $s->fetch();

require 'header.php';
if (!$existing) {
    echo '<div class="alert alert-warning">Student not found.</div><a href="index.php">Back</a>';
    require 'footer.php'; exit;
}

$d = clean_input($existing);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $d = clean_input($_POST);
    $errors = validate_student($d);

    if (empty($errors)) {
        $sql = 'UPDATE students
                SET first_name = ?, middle_name = ?, last_name = ?,
                    birthday = ?, sex = ?, email = ?, student_number = ?,
                    program = ?, enrolment_date = ?
                WHERE id = ?';
        try {
            // autocommit is off, so the SELECT above may already have opened a transaction
            if (!$pdo->inTransaction()) { $pdo->beginTransaction(); }
            $stmt = $pdo->prepare($sql);
            // the id must be the LAST element because WHERE id = ? is the last placeholder
            $stmt->execute([
                $d['first_name'],
                $d['middle_name'] === '' ? null : $d['middle_name'],
                $d['last_name'], $d['birthday'], $d['sex'], $d['email'],
                $d['student_number'], $d['program'], $d['enrolment_date'], $id,
            ]);
            $changed = $stmt->rowCount();
            $pdo->commit();
            $message = $changed === 1
                ? 'Student updated successfully.'
                : 'No changes were made (the submitted values match the saved record).';
        } catch (PDOException $e) {
            if ($pdo->inTransaction()) { $pdo->rollBack(); }
            if (($e->errorInfo[1] ?? 0) === 1062) { $errors = duplicate_error($e->getMessage()); }
            else { error_log($e->getMessage()); $errors['sex'] = 'Could not update the record.'; }
        }
    }
}
?>
<h2>Edit Student</h2>
<?php if ($message): ?><div class="alert alert-info"><?= htmlspecialchars($message) ?></div><?php endif; ?>
<?php $submitLabel = 'Update Student'; require '_form.php'; ?>
<?php require 'footer.php'; ?>
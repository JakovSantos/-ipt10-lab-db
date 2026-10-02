<?php
require_once 'config.php';
require_once 'validation.php';
$errors = [];
$d = clean_input([]);
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $d = clean_input($_POST);
    $errors = validate_student($d);

    if (empty($errors)) {
        $sql = 'INSERT INTO students
            (id, first_name, middle_name, last_name, birthday, sex, email,
             student_number, program, enrolment_date)
            VALUES (UUID(), ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $data = [
            $d['first_name'],
            $d['middle_name'] === '' ? null : $d['middle_name'],
            $d['last_name'], $d['birthday'], $d['sex'], $d['email'],
            $d['student_number'], $d['program'], $d['enrolment_date'],
        ];
        try {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
            if ($stmt->rowCount() === 1) {
                $pdo->commit();
                $message = 'Student created successfully!';
                $d = clean_input([]);
            } else {
                $pdo->rollBack();
            }
        } catch (PDOException $e) {
            if ($pdo->inTransaction()) { $pdo->rollBack(); }
            if (($e->errorInfo[1] ?? 0) === 1062) { $errors = duplicate_error($e->getMessage()); }
            else { error_log($e->getMessage()); $errors['sex'] = 'Could not save the record.'; }
        }
    }
}
require 'header.php';
?>
<h2>Add New Student</h2>
<?php if ($message): ?><div class="alert alert-success"><?= htmlspecialchars($message) ?></div><?php endif; ?>
<?php $submitLabel = 'Save Student'; require '_form.php'; ?>
<?php require 'footer.php'; ?>

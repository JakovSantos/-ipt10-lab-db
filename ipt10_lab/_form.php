<?php
if (!function_exists('field')) {
    function field(string $name, string $label, string $type, array $d, array $errors): void {
        $v = htmlspecialchars((string)($d[$name] ?? ''));
        echo '<div class="mb-3"><label class="form-label" for="'.$name.'">'.$label.'</label>';
        echo '<input class="form-control" type="'.$type.'" id="'.$name.'" name="'.$name.'" value="'.$v.'">';
        if (isset($errors[$name])) echo '<div class="text-danger small">'.htmlspecialchars($errors[$name]).'</div>';
        echo '</div>';
    }
}
?>
<form method="POST" novalidate>
  <?php
  field('first_name', 'First Name', 'text', $d, $errors);
  field('middle_name', 'Middle Name (optional)', 'text', $d, $errors);
  field('last_name', 'Last Name', 'text', $d, $errors);
  field('birthday', 'Birthday', 'date', $d, $errors);
  ?>
  <div class="mb-3">
    <label class="form-label" for="sex">Sex</label>
    <select class="form-select" id="sex" name="sex">
      <option value="">Select</option>
      <?php foreach (['Male', 'Female'] as $opt): ?>
        <option value="<?= $opt ?>" <?= ($d['sex'] ?? '') === $opt ? 'selected' : '' ?>><?= $opt ?></option>
      <?php endforeach; ?>
    </select>
    <?php if (isset($errors['sex'])): ?><div class="text-danger small"><?= htmlspecialchars($errors['sex']) ?></div><?php endif; ?>
  </div>
  <?php
  field('email', 'Email', 'text', $d, $errors);
  field('student_number', 'Student Number', 'text', $d, $errors);
  field('program', 'Program', 'text', $d, $errors);
  field('enrolment_date', 'Enrolment Date', 'date', $d, $errors);
  ?>
  <button class="btn btn-primary" type="submit"><?= htmlspecialchars($submitLabel) ?></button>
  <a class="btn btn-secondary" href="index.php">Back</a>
</form>

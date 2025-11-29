<?php
// index.php - Online Multiple Choice Quiz
// Author: [Your Name] - Class: 65HTTT - CSE485

$quizFile = __DIR__ . '/quiz.txt';

if (!file_exists($quizFile)) {
    die('<h3 style="color:red;text-align:center;">Error: Missing quiz.txt file!</h3>');
}

$content = file_get_contents($quizFile);
$blocks = preg_split('/\R{2,}/', trim($content));  // split by blank lines

$questions = [];
$qIndex = 0;

foreach ($blocks as $block) {
    $lines = array_filter(array_map('trim', preg_split('/\R/', $block)));
    if (count($lines) < 3) continue;

    $questionText = $lines[0];
    $options = [];
    $correctAnswers = [];
    $answerLineIndex = -1;

    // Find ANSWER line
    foreach ($lines as $i => $line) {
        if (preg_match('/^\s*ANSWER\s*:/i', $line)) {
            $answerLineIndex = $i;
            break;
        }
    }
    if ($answerLineIndex === -1) continue;

    // Extract options (lines between question and ANSWER)
    for ($i = 1; $i < $answerLineIndex; $i++) {
        $line = trim($lines[$i]);
        if (preg_match('/^([A-D])[.)]\s*(.+)$/i', $line, $m)) {
            $key = strtoupper($m[1]);
            $options[$key] = trim($m[2]);
        } else if (!empty($line)) {
            $options[] = $line;
        }
    }

    // Extract correct answer(s)
    $answerPart = trim(preg_replace('/^\s*ANSWER\s*:\s*/i', '', $lines[$answerLineIndex]));
    $rawAnswers = preg_split('/[\s,;|]+/', $answerPart);
    foreach ($rawAnswers as $ans) {
        $clean = strtoupper(preg_replace('/[^A-D]/', '', $ans));
        if ($clean !== '') {
            $correctAnswers[] = $clean;
        }
    }

    if (empty($options) || empty($correctAnswers)) continue;

    $questions[] = [
        'text' => $questionText,
        'options' => $options,
        'correct' => $correctAnswers,
        'multiple' => count($correctAnswers) > 1
    ];
    $qIndex++;
}

// === PROCESS SUBMITTED ANSWERS ===
$score = 0;
$totalQuestions = count($questions);
$results = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($questions as $idx => $q) {
        $field = 'q' . $idx;
        $userAnswer = [];

        if ($q['multiple']) {
            $userAnswer = isset($_POST[$field]) ? (array)$_POST[$field] : [];
            $userAnswer = array_map(function($v) {
                return strtoupper(preg_replace('/[^A-D]/', '', $v));
            }, $userAnswer);
            sort($userAnswer);
            $correctSorted = $q['correct'];
            sort($correctSorted);
            $isCorrect = ($userAnswer === $correctSorted);
        } else {
            $selected = isset($_POST[$field]) ? strtoupper(preg_replace('/[^A-D]/', '', $_POST[$field])) : '';
            $isCorrect = in_array($selected, $q['correct']);
            $userAnswer = [$selected];
        }

        if ($isCorrect) $score++;

        $results[] = [
            'correct' => $isCorrect,
            'user' => $userAnswer ?: ['Not answered'],
            'answer' => $q['correct']
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSE485 - Multiple Choice Quiz</title>
    <style>
        body {font-family: 'Segoe UI', Arial, sans-serif; background:#f5f7fa; margin:30px; line-height:1.6;}
        .container {max-width:900px; margin:auto; background:white; padding:25px; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,0.1);}
        h1 {text-align:center; color:#2c5282;}
        .info {background:#e6f4ff; padding:15px; border-radius:8px; text-align:center; font-size:17px;}
        .question-box {background:#fdfdfd; border:1px solid #e2e8f0; border-radius:10px; padding:18px; margin:20px 0;}
        .question {font-weight:600; font-size:18px; color:#1a365d; margin-bottom:12px;}
        .options label {display:block; margin:10px 0; padding:8px; background:#f7fafc; border-radius:6px; cursor:pointer;}
        .options label:hover {background:#ebf8ff;}
        .options input {margin-right:10px;}
        .btn {padding:12px 24px; font-size:16px; border:none; border-radius:8px; cursor:pointer; text-decoration:none; display:inline-block;}
        .submit-btn {background:#3182ce; color:white;}
        .reset-btn {background:#718096; color:white;}
        .result {background:#d1edf6; padding:20px; border-radius:10px; text-align:center; font-size:20px; margin:20px 0;}
        .correct {color:#2f855a; font-weight:bold;}
        .wrong {color:#c53030; font-weight:bold;}
        footer {text-align:center; margin-top:40px; color:#666; font-size:14px;}
    </style>
</head>
<body>

<div class="container">
    <h1>Multiple Choice Quiz - CSE485</h1>
    <div class="info">
        Total questions: <strong><?= $totalQuestions ?></strong> | 
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            Your score: <span class="correct"><?= $score ?></span> / <?= $totalQuestions ?>
        <?php else: ?>
            Good luck!
        <?php endif; ?>
    </div>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <div class="result">
            <strong>FINAL SCORE: <?= $score ?> / <?= $totalQuestions ?></strong><br><br>
            <a href="" class="btn reset-btn">Try Again</a>
        </div>
    <?php endif; ?>

    <form method="post">
        <?php foreach ($questions as $idx => $q): 
            $fieldName = 'q' . $idx;
            $isMultiple = $q['multiple'];
        ?>
            <div class="question-box">
                <div class="question">
                    <?= ($idx + 1) ?>. <?= htmlspecialchars($q['text'], ENT_QUOTES, 'UTF-8') ?>
                </div>
                <div class="options">
                    <?php foreach ($q['options'] as $key => $option): 
                        $id = $fieldName . '_' . (is_numeric($key) ? 'opt' . $key : $key);
                        $checked = '';
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            if ($isMultiple && isset($_POST[$fieldName]) && in_array($key, (array)$_POST[$fieldName])) {
                                $checked = 'checked';
                            } elseif (!$isMultiple && isset($_POST[$fieldName]) && $_POST[$fieldName] === $key) {
                                $checked = 'checked';
                            }
                        }
                    ?>
                        <label for="<?= $id ?>">
                            <input type="<?= $isMultiple ? 'checkbox' : 'radio' ?>"
                                   name="<?= $fieldName ?><?= $isMultiple ? '[]' : '' ?>"
                                   value="<?= htmlspecialchars($key, ENT_QUOTES) ?>"
                                   id="<?= $id ?>" <?= $checked ?>>
                            <strong><?= htmlspecialchars($key) ?>.</strong> <?= htmlspecialchars($option) ?>
                        </label>
                    <?php endforeach; ?>
                </div>

                <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                    <div style="margin-top:12px; font-weight:600;">
                        <?php if ($results[$idx]['correct']): ?>
                            <span class="correct">Correct</span>
                        <?php else: ?>
                            <span class="wrong">Wrong</span>
                        <?php endif; ?>
                        → Correct answer: <strong><?= implode(', ', $q['correct']) ?></strong>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <div style="text-align:center; margin:30px 0;">
            <button type="submit" class="btn submit-btn">Submit Answers</button>
            <a href="" class="btn reset-btn">Start Over</a>
        </div>
    </form>

    <footer>
        Quiz data: <code>quiz.txt</code> | 
        Author: [Your Name] | 
        Class: 65HTTT - CSE485
    </footer>
</div>

</body>
</html>
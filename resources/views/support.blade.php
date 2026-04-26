<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $clinicName }} - Support & Help</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #1b3d2f;
            --accent: #3d8b6e;
            --accent-soft: #e8f5f0;
            --text-primary: #1a2e25;
            --text-muted: #6b7f77;
            --border: #e4ece8;
            --card-bg: #ffffff;
            --page-bg: #f4f7f5;
        }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--page-bg);
            color: var(--text-primary);
        }
        .support-wrap {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .support-header {
            margin-bottom: 20px;
        }
        .support-header h1 {
            font-family: 'DM Serif Display', serif;
            font-size: 2rem;
            margin: 0 0 6px;
        }
        .support-header p {
            color: var(--text-muted);
            margin: 0;
        }
        .support-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 18px;
        }
        .support-card h2 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 14px;
        }
        .support-item {
            padding: 14px 0;
            border-top: 1px solid var(--border);
        }
        .support-item:first-child {
            border-top: none;
            padding-top: 0;
        }
        .support-question {
            font-weight: 600;
            margin-bottom: 6px;
        }
        .support-answer {
            color: var(--text-muted);
            font-size: .92rem;
            line-height: 1.6;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 18px;
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
        }
        .support-highlight {
            background: var(--accent-soft);
            border: 1px solid #c0dfd0;
            border-radius: 12px;
            padding: 14px 16px;
            font-size: .92rem;
        }
    </style>
</head>
<body>
    <div class="support-wrap">
        <a href="{{ url()->previous() }}" class="back-link">Back</a>

        <div class="support-header">
            <h1>{{ $clinicName }} Support & Help</h1>
            <p>Quick guidance for daily clinic operations and system usage.</p>
        </div>

        <div class="support-highlight">
            Queue format is currently set to <strong>{{ $queueFormat }}</strong>, and the default role for newly added users is <strong>{{ ucfirst($defaultRole) }}</strong>.
        </div>

        <div class="support-card">
            <h2>Common Tasks</h2>

            <div class="support-item">
                <div class="support-question">How do I register a walk-in patient?</div>
                <div class="support-answer">Use the staff dashboard registration form. After submitting, the system saves the patient details and assigns a queue number based on the current queue format in System Settings.</div>
            </div>

            <div class="support-item">
                <div class="support-question">How do I know who is being served?</div>
                <div class="support-answer">The patient queue tracks each patient as waiting, diagnosing, or done. Doctors can call a patient, start diagnosis, and complete the consultation.</div>
            </div>

            <div class="support-item">
                <div class="support-question">Where can I check patient history?</div>
                <div class="support-answer">Open Medical Records to see completed consultations, diagnoses, prescriptions, and consultation dates grouped by day.</div>
            </div>

            <div class="support-item">
                <div class="support-question">What do System Settings affect?</div>
                <div class="support-answer">System Settings now control the clinic display name, queue number format for new queue entries, and the default role selected when creating a new user.</div>
            </div>
        </div>

        <div class="support-card">
            <h2>Need More Help?</h2>
            <div class="support-answer">
                If a workflow is not behaving correctly, check the Administration, Queue, and Medical Records pages first to confirm the data is saved correctly.
                For technical maintenance, review validation messages and recent records before retrying the action.
            </div>
        </div>
    </div>
</body>
</html>

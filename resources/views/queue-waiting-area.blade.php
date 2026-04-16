<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CuraSure Queue Display</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --bg: #0f241c;
            --panel: #173528;
            --panel-soft: #214735;
            --text: #eff9f4;
            --muted: #b6d1c4;
            --accent: #58c497;
            --accent-soft: #88d8b8;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            background: radial-gradient(circle at top, #1c3e2f 0%, var(--bg) 60%);
            color: var(--text);
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            padding: 28px;
        }

        .board {
            max-width: 1100px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 16px;
            padding: 14px 16px;
            backdrop-filter: blur(8px);
        }

        .brand-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-holder {
            width: 58px;
            height: 58px;
            border-radius: 14px;
            background: linear-gradient(145deg, rgba(88, 196, 151, 0.26), rgba(136, 216, 184, 0.12));
            border: 1px solid rgba(136, 216, 184, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #eafff5;
            font-size: 1.2rem;
            font-weight: 800;
            letter-spacing: 0.03em;
            box-shadow: 0 10px 22px rgba(0, 0, 0, 0.2);
        }

        .brand-copy {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .title {
            font-size: clamp(1.5rem, 2.4vw, 2.2rem);
            font-weight: 700;
            letter-spacing: 0.02em;
            margin: 0;
        }

        .sub {
            color: var(--muted);
            font-size: 0.95rem;
        }

        .tagline {
            color: #d5efe2;
            font-size: 0.82rem;
            letter-spacing: 0.01em;
            opacity: 0.92;
        }

        .time-chip {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 12px;
            padding: 8px 12px;
            color: var(--accent-soft);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .current {
            background: linear-gradient(145deg, #1d4a38, #1b402f);
            border: 1px solid rgba(136, 216, 184, 0.35);
            border-radius: 16px;
            padding: 22px;
            margin-bottom: 18px;
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.22);
        }

        .label {
            color: var(--muted);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .serving-number {
            font-size: clamp(2.1rem, 5vw, 4rem);
            font-weight: 800;
            color: #ffffff;
            line-height: 1.1;
        }

        .serving-status {
            margin-top: 6px;
            color: var(--accent-soft);
            font-weight: 600;
        }

        .panel {
            background: var(--panel);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.2);
        }

        .panel-head {
            background: var(--panel-soft);
            padding: 14px 18px;
            font-size: 1rem;
            font-weight: 700;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .queue-list {
            padding: 6px 0;
        }

        .queue-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            transition: background 0.2s ease;
        }

        .queue-item:hover {
            background: rgba(255, 255, 255, 0.04);
        }

        .queue-item:last-child {
            border-bottom: none;
        }

        .q-number {
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .q-meta {
            color: var(--muted);
            font-size: 0.86rem;
        }

        .badge-status {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-radius: 20px;
            padding: 5px 10px;
            border: 1px solid transparent;
        }

        .badge-waiting {
            color: #d6f5e8;
            background: rgba(88, 196, 151, 0.16);
            border-color: rgba(88, 196, 151, 0.38);
        }

        .badge-diagnosing {
            color: #fff8df;
            background: rgba(240, 180, 60, 0.2);
            border-color: rgba(240, 180, 60, 0.45);
        }

        .empty {
            padding: 34px 18px;
            text-align: center;
            color: var(--muted);
        }

        .footer-note {
            text-align: center;
            color: var(--muted);
            margin-top: 14px;
            font-size: 0.84rem;
        }

        @media (max-width: 760px) {
            body { padding: 16px; }
            .header { flex-direction: column; align-items: flex-start; gap: 10px; }
            .queue-item { align-items: flex-start; gap: 10px; flex-direction: column; }
        }
    </style>
</head>
<body>
    @php
        $serving = $queue->firstWhere('status', 'diagnosing');
    @endphp

    <div class="board">
        <div class="header">
            <div class="brand-wrap">
                <div class="logo-holder">CS</div>
                <div class="brand-copy">
                    <h1 class="title">CuraSure Clinic Queue</h1>
                    <div class="sub">Please wait for your queue number to be called.</div>
                    <div class="tagline">Where clinical precision meets acurate wellness</div>
                </div>
            </div>
            <div class="time-chip" id="clock">{{ now()->format('M d, Y h:i A') }}</div>
        </div>

        <section class="current">
            <div class="label">Now Serving</div>
            <div class="serving-number">{{ $serving?->display_queue_number ?? '---' }}</div>
            <div class="serving-status">
                {{ $serving ? 'Proceed to your assigned clinic room.' : 'No active consultation right now.' }}
            </div>
        </section>

        <section class="panel">
            <div class="panel-head">Waiting Queue ({{ $queue->count() }})</div>
            <div class="queue-list">
                @forelse($queue as $entry)
                    <div class="queue-item">
                        <div>
                            <div class="q-number">{{ $entry->display_queue_number }}</div>
                            <div class="q-meta">
                                Queued {{ $entry->created_at?->format('h:i A') ?? 'N/A' }}
                            </div>
                        </div>
                        <span class="badge-status {{ $entry->status === 'diagnosing' ? 'badge-diagnosing' : 'badge-waiting' }}">
                            {{ $entry->status === 'diagnosing' ? 'Now Serving' : 'Waiting' }}
                        </span>
                    </div>
                @empty
                    <div class="empty">No patients in queue right now.</div>
                @endforelse
            </div>
        </section>

        <div class="footer-note">This screen refreshes automatically every 20 seconds.</div>
    </div>

    <script>
        setTimeout(() => window.location.reload(), 20000);

        const clock = document.getElementById('clock');
        setInterval(() => {
            const now = new Date();
            clock.textContent = now.toLocaleString([], {
                year: 'numeric',
                month: 'short',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            });
        }, 1000);
    </script>
</body>
</html>

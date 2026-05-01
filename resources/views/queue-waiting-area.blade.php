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
            --room-bg: rgba(88, 196, 151, 0.13);
            --room-border: rgba(88, 196, 151, 0.50);
            --room-text: #a8f0d0;
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

        /* ── Header ── */
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

        .brand-copy { display: flex; flex-direction: column; gap: 4px; }

        .title {
            font-size: clamp(1.5rem, 2.4vw, 2.2rem);
            font-weight: 700;
            letter-spacing: 0.02em;
            margin: 0;
        }

        .sub   { color: var(--muted); font-size: 0.95rem; }
        .tagline { color: #d5efe2; font-size: 0.82rem; letter-spacing: 0.01em; opacity: 0.92; }

        .time-chip {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 12px;
            padding: 8px 12px;
            color: var(--accent-soft);
            font-weight: 600;
            font-size: 0.9rem;
            white-space: nowrap;
        }

        /* ── Now Serving card ── */
        .current {
            display: grid;
            gap: 18px;
            margin-bottom: 18px;
        }

        .current-card {
            background: linear-gradient(145deg, #1d4a38, #1b402f);
            border: 1px solid rgba(136, 216, 184, 0.35);
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.22);
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 22px;
            align-items: center;
            position: relative;
        }

        .current-inner {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
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

        /* ── Room indicator (Now Serving) ── */
        .room-indicator {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: var(--room-bg);
            border: 2px solid var(--room-border);
            border-radius: 14px;
            padding: 14px 22px;
            min-width: 150px;
            text-align: center;
            box-shadow: 0 0 18px rgba(88, 196, 151, 0.12);
            gap: 4px;
            justify-self: end;
            align-self: start;
        }

        .current-card .label {
            margin-bottom: 10px;
        }

        .current-card .serving-number {
            margin-bottom: 12px;
        }

        .room-indicator .room-label {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--muted);
            font-weight: 700;
        }

        .room-indicator .room-name {
            font-size: clamp(1.1rem, 2vw, 1.6rem);
            font-weight: 800;
            color: var(--room-text);
            line-height: 1.15;
        }

        .room-indicator .room-icon {
            font-size: 1.5rem;
            margin-bottom: 2px;
        }

        /* ── Queue panel ── */
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

        .queue-list { padding: 6px 0; }

        .queue-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            transition: background 0.2s ease;
            gap: 12px;
        }

        .queue-item:hover { background: rgba(255, 255, 255, 0.04); }
        .queue-item:last-child { border-bottom: none; }

        .q-number {
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .q-meta { color: var(--muted); font-size: 0.86rem; }

        /* ── Room pill (queue list) ── */
        .q-room-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--room-bg);
            border: 1px solid var(--room-border);
            border-radius: 20px;
            padding: 3px 10px;
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--room-text);
            letter-spacing: 0.03em;
            white-space: nowrap;
        }

        .q-room-pill svg {
            width: 12px;
            height: 12px;
            flex-shrink: 0;
            opacity: 0.85;
        }

        /* ── Status badges ── */
        .badge-status {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-radius: 20px;
            padding: 5px 10px;
            border: 1px solid transparent;
            white-space: nowrap;
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

        .q-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-end;
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
            .current-inner { flex-direction: column; }
            .room-indicator { align-items: flex-start; min-width: unset; width: 100%; flex-direction: row; gap: 10px; }
            .queue-item { align-items: flex-start; gap: 10px; flex-direction: column; }
            .q-right { justify-content: flex-start; }
        }
    </style>
</head>
<body>
    @php
        $servingEntries = $queue->where('status', 'diagnosing');
    @endphp

    <div class="board">
        {{-- Header --}}
        <div class="header">
            <div class="brand-wrap">
                 <img src="{{ asset('img/logo.png') }}" alt="CuraSure" style="width:80px; height:80px; object-fit:contain; border-radius:12px;">
                <div class="brand-copy">
                    <h1 class="title">CuraSure Clinic Queue</h1>
                    <div class="sub">Please wait for your queue number to be called.</div>
                    <div class="tagline">Where clinical precision meets accurate wellness</div>
                </div>
            </div>
            <div class="time-chip" id="clock">{{ now()->format('M d, Y h:i A') }}</div>
        </div>

        {{-- Now Serving --}}
        <section class="current">
            @if ($servingEntries->isEmpty())
                <div class="current-card">
                    <div class="label">Now Serving</div>
                    <div class="serving-number">---</div>
                    <div class="serving-status">No active consultation right now.</div>
                </div>
            @else
                @foreach ($servingEntries as $serving)
                    <div class="current-card">
                        <div class="label">Now Serving</div>
                        <div class="serving-number">{{ $serving->display_queue_number }}</div>
                        <div class="serving-status">Proceed to your assigned clinic room.</div>
                        <div class="room-indicator">
                            <div class="room-icon"></div>
                            <div class="room-label">Assigned Room</div>
                            <div class="room-name">{{ $serving->assigned_room ?? 'Unassigned' }}</div>
                        </div>
                    </div>
                @endforeach
            @endif
        </section>

        {{-- Queue List --}}
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

                        <div class="q-right">
                            {{-- Room pill: only show when assigned --}}
                            @if ($entry->assigned_room)
                                <span class="q-room-pill">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                        <polyline points="9 22 9 12 15 12 15 22"/>
                                    </svg>
                                    {{ $entry->assigned_room }}
                                </span>
                            @endif

                            <span class="badge-status {{ $entry->status === 'diagnosing' ? 'badge-diagnosing' : 'badge-waiting' }}">
                                {{ $entry->status === 'diagnosing' ? 'Now Serving' : 'Waiting' }}
                            </span>
                        </div>
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
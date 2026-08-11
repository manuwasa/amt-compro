<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Down for Maintenance — {{ config('app.name') }}</title>
    <style>
        body { margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #f8fafc; color: #0f172a; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        .wrap { max-width: 32rem; padding: 2rem; text-align: center; }
        .dot { display: inline-block; width: 0.5rem; height: 0.5rem; border-radius: 50%; background: #f59e0b; margin-bottom: 1.25rem; }
        h1 { font-size: 1.75rem; font-weight: 700; margin: 0 0 1rem; }
        p { color: #64748b; margin: 0; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="dot"></div>
        <h1>Down for Maintenance</h1>
        <p>{{ config('app.name') }} is undergoing scheduled maintenance. We'll be back shortly.</p>
    </div>
</body>
</html>

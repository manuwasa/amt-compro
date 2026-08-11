<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Something Went Wrong — {{ config('app.name') }}</title>
    <style>
        body { margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #f8fafc; color: #0f172a; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        .wrap { max-width: 32rem; padding: 2rem; text-align: center; }
        .code { font-size: 3rem; font-weight: 800; color: #f59e0b; margin: 0 0 0.5rem; }
        h1 { font-size: 1.75rem; font-weight: 700; margin: 0 0 1rem; }
        p { color: #64748b; margin: 0 0 2rem; }
        a { display: inline-block; background: #0f172a; color: #fff; text-decoration: none; padding: 0.75rem 1.5rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600; transition: background 0.2s; }
        a:hover { background: #1e293b; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="code">500</div>
        <h1>Something Went Wrong</h1>
        <p>We're experiencing a temporary issue. Please try again shortly.</p>
        <a href="/">Go Home</a>
    </div>
</body>
</html>

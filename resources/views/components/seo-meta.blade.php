@props([
    'title' => null,
    'description' => null,
    'image' => null,
    'type' => 'website',
    'canonical' => null,
])

@php
    $groupName = $groupSettings['group_name'] ?? config('app.name');
    $resolvedTitle = $title ? "{$title} — {$groupName}" : $groupName;
    $resolvedDescription = $description ?: ($groupSettings['meta_description'] ?? null);
    $resolvedImage = $image ?: ($groupSettings['group_logo'] ?? null);
    $resolvedImageUrl = $resolvedImage ? \Illuminate\Support\Facades\Storage::url($resolvedImage) : null;
    $resolvedCanonical = $canonical ?: url()->current();
@endphp

<title>{{ $resolvedTitle }}</title>
@if ($resolvedDescription)
    <meta name="description" content="{{ $resolvedDescription }}">
@endif
<link rel="canonical" href="{{ $resolvedCanonical }}">

<meta property="og:site_name" content="{{ $groupName }}">
<meta property="og:type" content="{{ $type }}">
<meta property="og:title" content="{{ $resolvedTitle }}">
@if ($resolvedDescription)
    <meta property="og:description" content="{{ $resolvedDescription }}">
@endif
<meta property="og:url" content="{{ $resolvedCanonical }}">
@if ($resolvedImageUrl)
    <meta property="og:image" content="{{ $resolvedImageUrl }}">
@endif

<meta name="twitter:card" content="{{ $resolvedImageUrl ? 'summary_large_image' : 'summary' }}">
<meta name="twitter:title" content="{{ $resolvedTitle }}">
@if ($resolvedDescription)
    <meta name="twitter:description" content="{{ $resolvedDescription }}">
@endif
@if ($resolvedImageUrl)
    <meta name="twitter:image" content="{{ $resolvedImageUrl }}">
@endif

@php
$icons = [
  'dashboard' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10h5v-6h4v6h5V10"/>',
  'trophy' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8 21h8M12 17v4M7 4h10v4a5 5 0 01-10 0V4zM17 5h3v2a3 3 0 01-3 3M7 5H4v2a3 3 0 003 3"/>',
  'plus' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/>',
  'check' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
  'scale' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M5 7h14M7 7l-3 6h6l-3-6zm10 0l-3 6h6l-3-6M5 21h14"/>',
  'user' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a4 4 0 10-8 0 4 4 0 008 0zM3 21v-1a6 6 0 0118 0v1"/>',
  'logout' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 12H4m0 0l4-4m-4 4l4 4M14 4h4a2 2 0 012 2v12a2 2 0 01-2 2h-4"/>',
  'star' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3l2.7 5.5 6.1.9-4.4 4.3 1 6.1L12 17l-5.4 2.8 1-6.1L3.2 9.4l6.1-.9L12 3z"/>',
  'doc' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6M9 16h6M7 4h7l4 4v12a1 1 0 01-1 1H7a1 1 0 01-1-1V5a1 1 0 011-1z"/>',
  'menu' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>',
  'calendar' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8 2v4M16 2v4M3 9h18M5 4h14a2 2 0 012 2v13a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z"/>',
  'building' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V5a2 2 0 012-2h6a2 2 0 012 2v16M13 9h4a2 2 0 012 2v10M8 7h2M8 11h2M8 15h2"/>',
];
@endphp
@isset($name)
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="{{ $class ?? 'h-5 w-5' }}" stroke-width="1.8">
  {!! $icons[$name] ?? '' !!}
</svg>
@endisset

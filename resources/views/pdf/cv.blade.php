<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $settings['site_name'] ?? 'CV' }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1a1a1a; line-height: 1.5; padding: 30px; }
        h1 { font-size: 22px; margin-bottom: 4px; }
        h2 { font-size: 14px; border-bottom: 2px solid #c97a2b; padding-bottom: 4px; margin-top: 20px; }
        .job-title { color: #c97a2b; font-size: 13px; margin-bottom: 10px; }
        .contact { font-size: 10px; color: #666; margin-bottom: 20px; }
        .item { margin-bottom: 12px; }
        .item-title { font-weight: bold; font-size: 12px; }
        .item-sub { color: #666; font-size: 10px; }
        .item-desc { margin-top: 4px; font-size: 10px; }
        .skills { display: flex; flex-wrap: wrap; gap: 6px; }
        .skill { background: #f0ece4; padding: 3px 8px; border-radius: 3px; font-size: 10px; display: inline-block; margin: 2px; }
    </style>
</head>
<body>
    <h1>{{ $settings['site_name'] ?? '' }}</h1>
    <div class="job-title">{{ $settings['job_title'] ?? '' }}</div>
    <div class="contact">
        {{ $settings['email'] ?? '' }}
        @if(!empty($settings['phone'])) | {{ $settings['phone'] }} @endif
    </div>

    @if(!empty($settings['bio']))
        <p>{{ $settings['bio'] }}</p>
    @endif

    <h2>Expériences</h2>
    @foreach($experiences as $exp)
        <div class="item">
            <div class="item-title">{{ $exp['title'] }}</div>
            <div class="item-sub">{{ $exp['company'] }} @if($exp['location']) | {{ $exp['location'] }} @endif</div>
            <div class="item-desc">{{ $exp['description'] }}</div>
        </div>
    @endforeach

    <h2>Formation</h2>
    @foreach($education as $edu)
        <div class="item">
            <div class="item-title">{{ $edu['degree'] }}</div>
            <div class="item-sub">{{ $edu['institution'] }} @if($edu['location']) | {{ $edu['location'] }} @endif</div>
        </div>
    @endforeach

    <h2>Compétences</h2>
    <div class="skills">
        @foreach($skills as $skill)
            <span class="skill">{{ $skill['name'] }}</span>
        @endforeach
    </div>
</body>
</html>

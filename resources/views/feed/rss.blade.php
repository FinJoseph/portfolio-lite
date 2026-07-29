<?php echo '<?xml version="1.0" encoding="UTF-8"?>'."\n"; ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title><![CDATA[{{ $title }}]]></title>
        <link>{{ $siteUrl }}</link>
        <atom:link href="{{ $feedUrl }}" rel="self" type="application/rss+xml" />
        <description><![CDATA[{{ $description }}]]></description>
        <language>{{ $language }}</language>
        <lastBuildDate>{{ $lastBuildDate }}</lastBuildDate>
        @foreach($items as $item)
        <item>
            <title><![CDATA[{{ $item['title'] }}]]></title>
            <link>{{ $item['link'] }}</link>
            <guid isPermaLink="true">{{ $item['guid'] }}</guid>
            <description><![CDATA[{{ $item['description'] }}]]></description>
            <pubDate>{{ $item['pubDate'] }}</pubDate>
            <category><![CDATA[{{ $item['category'] }}]]></category>
        </item>
        @endforeach
    </channel>
</rss>

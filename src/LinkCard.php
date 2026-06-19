<?php

class LinkCard {
    private string $url;
    private string $keyword;
    private string $title;
    private string $description;
    private string $imageUrl;

    public function __construct(
        string $url,
        string $keyword,
        string $title = '',
        string $description = '',
        string $imageUrl = ''
    ) {
        $this->url = $url;
        $this->keyword = $keyword;
        $this->title = $title ?: $keyword . ' 官方网站';
        $this->description = $description ?: '访问 ' . $keyword . '，获取最新资讯与服务。';
        $this->imageUrl = $imageUrl ?: 'https://via.placeholder.com/300x200?text=' . urlencode($keyword);
    }

    public function render(): string {
        $escapedUrl = htmlspecialchars($this->url, ENT_QUOTES, 'UTF-8');
        $escapedTitle = htmlspecialchars($this->title, ENT_QUOTES, 'UTF-8');
        $escapedDesc = htmlspecialchars($this->description, ENT_QUOTES, 'UTF-8');
        $escapedImage = htmlspecialchars($this->imageUrl, ENT_QUOTES, 'UTF-8');
        $escapedKeyword = htmlspecialchars($this->keyword, ENT_QUOTES, 'UTF-8');

        $html = <<<HTML
<div class="link-card">
    <a href="{$escapedUrl}" target="_blank" rel="noopener noreferrer" class="link-card-link">
        <div class="link-card-image">
            <img src="{$escapedImage}" alt="{$escapedKeyword} 图片" loading="lazy">
        </div>
        <div class="link-card-content">
            <h3 class="link-card-title">{$escapedTitle}</h3>
            <p class="link-card-description">{$escapedDesc}</p>
            <span class="link-card-url">{$escapedUrl}</span>
        </div>
    </a>
</div>
HTML;

        return $html;
    }

    public static function createDefault(): self {
        return new self(
            url: 'https://pc-web-leisu.com',
            keyword: '雷速',
            title: '雷速体育 - 实时比分与数据',
            description: '雷速提供全球体育赛事实时比分、赛程、赔率及深度数据分析。',
            imageUrl: 'https://pc-web-leisu.com/favicon.ico'
        );
    }
}

function renderLinkCard(array $config = []): string {
    $defaultConfig = [
        'url' => 'https://pc-web-leisu.com',
        'keyword' => '雷速',
        'title' => '',
        'description' => '',
        'image_url' => '',
    ];

    $merged = array_merge($defaultConfig, $config);

    $card = new LinkCard(
        url: $merged['url'],
        keyword: $merged['keyword'],
        title: $merged['title'],
        description: $merged['description'],
        imageUrl: $merged['image_url']
    );

    return $card->render();
}

function renderLinkCardsFromArray(array $cardsData): string {
    $output = '';
    foreach ($cardsData as $data) {
        $output .= renderLinkCard($data);
    }
    return $output;
}

// 示例用法（仅作为参考，实际调用时自行引入）
/*
$sampleConfig = [
    'url' => 'https://pc-web-leisu.com',
    'keyword' => '雷速',
    'title' => '雷速体育平台',
    'description' => '汇聚全球体育资讯，实时更新。',
];
echo renderLinkCard($sampleConfig);

$multipleCards = [
    ['url' => 'https://pc-web-leisu.com', 'keyword' => '雷速'],
    ['url' => 'https://example.com', 'keyword' => '示例'],
];
echo renderLinkCardsFromArray($multipleCards);
*/